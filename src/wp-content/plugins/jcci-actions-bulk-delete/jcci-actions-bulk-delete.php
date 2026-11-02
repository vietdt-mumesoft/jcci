<?php
/**
 * Plugin Name:  JCCI Actions Bulk Delete
 * Description:  Permanently delete "actions" CPT posts by Japanese financial
 *               year, including their orphaned attachment images. Accessible
 *               under Tools → Actions Bulk Delete in the WP admin.
 * Version:      1.0.0
 * Author:       JCCI
 * License:      GPL-2.0+
 *
 * Financial-year logic mirrors the frontend taxonomy.php template exactly:
 *   - Year list  : uses the same CASE WHEN DATE_FORMAT(post_date,'%m') <= '03'
 *                  logic as jcci_get_posts_financial_years() in functions-jcci.php
 *   - Date range : {year}-04-01  →  {year+1}-03-31, identical to filter_where()
 *                  in taxonomy.php
 */

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/attachment-deleter.php';


// ═══════════════════════════════════════════════════════════════════════════
//  Admin menu
// ═══════════════════════════════════════════════════════════════════════════

add_action( 'admin_menu', 'jcci_abd_register_menu' );

function jcci_abd_register_menu() {
    add_management_page(
        'JCCI Actions Bulk Delete',  // <title>
        'Actions Bulk Delete',       // menu label
        'manage_options',            // capability
        'jcci-actions-bulk-delete',  // slug
        'jcci_abd_render_page'       // callback
    );
}


// ═══════════════════════════════════════════════════════════════════════════
//  Financial year list
//  Mirrors jcci_get_posts_financial_years() SQL exactly, but also returns
//  the numeric year so it can be used as a form checkbox value.
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Return distinct financial years that have published `actions` posts.
 *
 * Uses the identical CASE WHEN condition from jcci_get_posts_financial_years():
 *   DATE_FORMAT(post_date, '%d') <= '31' && DATE_FORMAT(post_date, '%m') <= '03'
 * (the %d condition is always true; retained verbatim to match original logic.)
 *
 * No $wpdb->prepare() is used here because:
 *   - post_type ('actions') and post_status ('publish') are hard-coded strings.
 *   - MySQL's DATE_FORMAT % specifiers would need to be doubled (%%) inside
 *     prepare(), adding noise with no security benefit when there is no
 *     user-supplied input to sanitize.
 *
 * @return object[]  Each object has: year_num (string e.g. "2024"),
 *                                    year_label (string e.g. "2024年度").
 */
function jcci_abd_get_financial_years() {
    global $wpdb;

    // phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
    $sql = "SELECT
        (CASE WHEN DATE_FORMAT(post_date, '%d') <= '31' && DATE_FORMAT(post_date, '%m') <= '03'
            THEN DATE_FORMAT(DATE_SUB(post_date, INTERVAL 1 YEAR), '%Y')
            ELSE DATE_FORMAT(post_date, '%Y')
        END) AS year_num,
        (CASE WHEN DATE_FORMAT(post_date, '%d') <= '31' && DATE_FORMAT(post_date, '%m') <= '03'
            THEN DATE_FORMAT(DATE_SUB(post_date, INTERVAL 1 YEAR), '%Y年度')
            ELSE DATE_FORMAT(post_date, '%Y年度')
        END) AS year_label
        FROM {$wpdb->posts}
        WHERE post_status = 'publish'
          AND post_type   = 'actions'
        GROUP BY year_num, year_label
        ORDER BY year_num DESC";

    return $wpdb->get_results( $sql );
    // phpcs:enable
}


// ═══════════════════════════════════════════════════════════════════════════
//  Post ID query
//  Date range logic is identical to filter_where() in taxonomy.php.
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Return IDs of all `actions` posts whose post_date falls within the supplied
 * financial years.
 *
 * Date range per year (matches filter_where() in taxonomy.php exactly):
 *   Start : {year}-04-01
 *   End   : {year+1}-03-31
 *   WHERE : DATE_FORMAT(post_date,'%Y-%m-%d') >= '{start}'
 *           AND DATE_FORMAT(post_date,'%Y-%m-%d') <= '{end}'
 *
 * Statuses targeted: publish, draft, private, pending.
 * The year-list query only surfaces years that have *published* posts (matching
 * the frontend template), but we widen deletion to all non-trashed statuses so
 * unpublished posts from the same fiscal period are not left as orphans.
 *
 * No $wpdb->prepare() for the date clauses because every value passed into the
 * SQL is constructed from an intval()-cast integer — there is no user input
 * that reaches the SQL string directly.
 *
 * @param int[] $selected_years  Already intval()-cast years, e.g. [2024, 2023].
 * @return int[]
 */
function jcci_abd_get_post_ids_for_years( array $selected_years ) {
    global $wpdb;

    if ( empty( $selected_years ) ) {
        return [];
    }

    $year_clauses = [];
    foreach ( $selected_years as $year ) {
        $year  = intval( $year );                       // guarantee integer
        $start = $year       . '-04-01';                // e.g. 2024-04-01
        $end   = ( $year + 1 ) . '-03-31';              // e.g. 2025-03-31
        // Date strings are derived solely from an intval'd integer — safe.
        $year_clauses[] =
            "(DATE_FORMAT(post_date, '%Y-%m-%d') >= '{$start}'"
            . " AND DATE_FORMAT(post_date, '%Y-%m-%d') <= '{$end}')";
    }

    $where_years = implode( ' OR ', $year_clauses );

    // phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
    $sql = "SELECT ID FROM {$wpdb->posts}
             WHERE post_type   = 'actions'
               AND post_status IN ('publish', 'draft', 'private', 'pending')
               AND ( {$where_years} )";

    return array_map( 'intval', (array) $wpdb->get_col( $sql ) );
    // phpcs:enable
}


// ═══════════════════════════════════════════════════════════════════════════
//  POST form handler
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Process the submitted deletion form.
 * Always exits via wp_safe_redirect().
 */
function jcci_abd_handle_form() {
    // Nonce check — dies on failure.
    check_admin_referer( 'jcci_abd_delete_action' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to perform this action.' ) );
    }

    // Sanitize submitted years: cast every value to int, drop zeros / non-numeric.
    $raw_years      = isset( $_POST['years'] ) ? (array) $_POST['years'] : []; // phpcs:ignore
    $selected_years = array_values( array_filter( array_map( 'intval', $raw_years ) ) );

    $page_url = menu_page_url( 'jcci-actions-bulk-delete', false );

    if ( empty( $selected_years ) ) {
        wp_safe_redirect( add_query_arg( [ 'jcci_abd_error' => 'no_years_selected' ], $page_url ) );
        exit;
    }

    $post_ids      = jcci_abd_get_post_ids_for_years( $selected_years );
    $posts_deleted = 0;
    $att_deleted   = 0;

    foreach ( $post_ids as $post_id ) {
        $att_deleted += jcci_abd_delete_post_with_attachments( $post_id );
        $posts_deleted++;
    }

    wp_safe_redirect(
        add_query_arg(
            [
                'jcci_abd_posts_deleted' => $posts_deleted,
                'jcci_abd_att_deleted'   => $att_deleted,
            ],
            $page_url
        )
    );
    exit;
}


// ═══════════════════════════════════════════════════════════════════════════
//  Admin page render
// ═══════════════════════════════════════════════════════════════════════════

function jcci_abd_render_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to view this page.' ) );
    }

    // Route POST submissions through the handler (which always redirects + exits).
    if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) { // phpcs:ignore
        jcci_abd_handle_form();
    }

    // Sanitize GET result params before use.
    $error_key     = isset( $_GET['jcci_abd_error'] ) // phpcs:ignore
                        ? sanitize_key( wp_unslash( $_GET['jcci_abd_error'] ) ) // phpcs:ignore
                        : '';
    $posts_deleted = isset( $_GET['jcci_abd_posts_deleted'] ) // phpcs:ignore
                        ? intval( $_GET['jcci_abd_posts_deleted'] ) // phpcs:ignore
                        : null;
    $att_deleted   = isset( $_GET['jcci_abd_att_deleted'] ) // phpcs:ignore
                        ? intval( $_GET['jcci_abd_att_deleted'] ) // phpcs:ignore
                        : null;

    $years = jcci_abd_get_financial_years();

    ?>
    <div class="wrap">
        <h1>JCCI Actions &mdash; Bulk Delete by Financial Year</h1>

        <?php /* ── Result notices (shown after a redirect) ── */ ?>

        <?php if ( null !== $posts_deleted ) : ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    Permanently deleted <strong><?php echo intval( $posts_deleted ); ?></strong>
                    action post(s) and <strong><?php echo intval( $att_deleted ); ?></strong>
                    orphaned attachment(s).
                </p>
            </div>

        <?php elseif ( 'no_years_selected' === $error_key ) : ?>
            <div class="notice notice-error is-dismissible">
                <p>Please select at least one financial year before submitting.</p>
            </div>
        <?php endif; ?>

        <?php /* ── Explanation ── */ ?>
        <p>
            Select one or more financial years below. All <code>actions</code> posts
            whose publish date falls within those years will be
            <strong>permanently deleted</strong>, together with any attached images
            that are not used elsewhere in the site.
        </p>
        <p>
            <strong>This action is irreversible.</strong>
            Please back up your database before proceeding.
        </p>
        <p style="color:#888;font-size:12px;">
            Note: The year list is built from <em>published</em> posts only
            (matching the frontend filter). Deletion also removes any
            <em>draft / private / pending</em> posts from those same fiscal periods.
        </p>

        <?php if ( empty( $years ) ) : ?>
            <div class="notice notice-warning inline">
                <p>No published <code>actions</code> posts found. Nothing to delete.</p>
            </div>

        <?php else : ?>

            <form method="post" id="jcci-abd-form">
                <?php wp_nonce_field( 'jcci_abd_delete_action' ); ?>

                <table class="widefat striped" style="max-width:480px;margin-bottom:16px;">
                    <thead>
                        <tr>
                            <th style="width:44px;text-align:center;">
                                <input type="checkbox" id="jcci-abd-check-all" title="Select / deselect all">
                            </th>
                            <th>Financial Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $years as $row ) : ?>
                            <tr>
                                <td style="text-align:center;">
                                    <input type="checkbox"
                                           name="years[]"
                                           value="<?php echo esc_attr( $row->year_num ); ?>"
                                           class="jcci-abd-year-cb">
                                </td>
                                <td><?php echo esc_html( $row->year_label ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p>
                    <input type="submit"
                           id="jcci-abd-submit"
                           class="button button-primary button-large"
                           value="Permanently Delete Selected Years">
                </p>
            </form>

            <script>
            (function () {
                'use strict';

                var checkAll  = document.getElementById('jcci-abd-check-all');
                var form      = document.getElementById('jcci-abd-form');
                var cbClass   = '.jcci-abd-year-cb';

                // ── Select/deselect all toggle ──────────────────────────────
                checkAll.addEventListener('change', function () {
                    document.querySelectorAll(cbClass).forEach(function (cb) {
                        cb.checked = checkAll.checked;
                    });
                });

                // ── Confirm before submit ───────────────────────────────────
                form.addEventListener('submit', function (e) {
                    var checked = document.querySelectorAll(cbClass + ':checked');

                    if (checked.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one financial year.');
                        return;
                    }

                    // Build a readable list of selected years for the confirm dialog.
                    var years = Array.from(checked).map(function (cb) {
                        var row = cb.closest('tr');
                        return row ? row.cells[1].textContent.trim() : cb.value;
                    });

                    var msg =
                        'WARNING: You are about to PERMANENTLY DELETE all Actions posts for:\n\n' +
                        years.join('\n') +
                        '\n\n' +
                        'This also removes their orphaned attachment images.\n' +
                        'This action CANNOT BE UNDONE.\n\n' +
                        'Are you absolutely sure?';

                    if ( ! confirm(msg) ) {
                        e.preventDefault();
                    }
                });
            })();
            </script>

        <?php endif; ?>
    </div>
    <?php
}
