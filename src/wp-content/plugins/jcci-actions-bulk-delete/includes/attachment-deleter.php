<?php
/**
 * Attachment collection and deletion helpers for JCCI Actions Bulk Delete.
 *
 * Separated from the main plugin file so this logic can be reviewed
 * and updated independently.
 *
 * Functions provided:
 *   - jcci_abd_get_post_attachment_ids()       collect all attachment IDs for a post
 *   - jcci_abd_is_attachment_used_elsewhere()  check whether an attachment is still referenced
 *   - jcci_abd_delete_post_with_attachments()  permanently delete post + orphaned attachments
 */

defined( 'ABSPATH' ) || exit;


// ═══════════════════════════════════════════════════════════════════════════
//  1.  Collect attachment IDs
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Collect all attachment IDs associated with a post.
 *
 * Three sources are checked:
 *   (a) Featured image (_thumbnail_id postmeta).
 *   (b) Attachments uploaded directly to this post (tracked by post_parent).
 *   (c) Images embedded in post_content via <img src="...">.
 *
 * Call this BEFORE deleting the post so all postmeta / content is still intact.
 *
 * @param int $post_id
 * @return int[]  Unique, non-zero attachment IDs.
 */
function jcci_abd_get_post_attachment_ids( $post_id ) {
    $post_id = intval( $post_id );
    $ids     = [];

    // (a) Featured image
    $thumbnail_id = (int) get_post_thumbnail_id( $post_id );
    if ( $thumbnail_id > 0 ) {
        $ids[] = $thumbnail_id;
    }

    // (b) Attachments whose post_parent is this post
    //     Covers files uploaded while editing this specific post.
    $children = get_posts( [
        'post_type'   => 'attachment',
        'post_parent' => $post_id,
        'post_status' => 'inherit',
        'fields'      => 'ids',
        'numberposts' => -1,
    ] );
    if ( ! empty( $children ) ) {
        $ids = array_merge( $ids, array_map( 'intval', $children ) );
    }

    // (c) Images embedded in post_content via <img src="...">
    //     Covers images inserted from the media library into the post body.
    $post = get_post( $post_id );
    if ( $post && ! empty( $post->post_content ) ) {
        preg_match_all( '/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $post->post_content, $matches );
        if ( ! empty( $matches[1] ) ) {
            foreach ( $matches[1] as $src_url ) {
                $att_id = (int) attachment_url_to_postid( esc_url_raw( $src_url ) );
                if ( $att_id > 0 ) {
                    $ids[] = $att_id;
                }
            }
        }
    }

    return array_values( array_unique( array_filter( $ids ) ) );
}


// ═══════════════════════════════════════════════════════════════════════════
//  2.  Check whether an attachment is still used elsewhere
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Check whether an attachment is currently referenced by any post still in
 * the database.
 *
 * Two checks are performed:
 *   1. Whether the attachment is set as a featured image (_thumbnail_id) on
 *      any remaining post.
 *   2. Whether the attachment's URL path appears in any remaining post's
 *      post_content (path-only comparison to handle http/https and domain
 *      variations transparently).
 *
 * IMPORTANT: Call this AFTER wp_delete_post() for the parent post.
 * wp_delete_post( $id, true ) removes all postmeta rows (including
 * _thumbnail_id) for that post, so those references are already gone from
 * the database when this function runs.
 *
 * @param int $attachment_id
 * @return bool  TRUE if the attachment is still in use somewhere.
 */
function jcci_abd_is_attachment_used_elsewhere( $attachment_id ) {
    global $wpdb;
    $attachment_id = intval( $attachment_id );

    // 1. Used as a featured image on any remaining post?
    $thumbnail_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
               FROM {$wpdb->postmeta}
              WHERE meta_key   = '_thumbnail_id'
                AND meta_value = %d",
            $attachment_id
        )
    );
    if ( $thumbnail_count > 0 ) {
        return true;
    }

    // 2. URL referenced inside any remaining post's content?
    $attachment_url = wp_get_attachment_url( $attachment_id );
    if ( ! $attachment_url ) {
        return false;   // attachment record likely gone already
    }

    // Compare the URL path only — avoids http/https or domain-variant mismatches.
    $url_path = (string) parse_url( $attachment_url, PHP_URL_PATH );
    if ( ! $url_path ) {
        return false;
    }

    $content_count = (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*)
               FROM {$wpdb->posts}
              WHERE post_status != 'trash'
                AND post_content LIKE %s",
            '%' . $wpdb->esc_like( $url_path ) . '%'
        )
    );

    return $content_count > 0;
}


// ═══════════════════════════════════════════════════════════════════════════
//  3.  Delete post + orphaned attachments
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Permanently delete a post and any of its attachments that are not used
 * elsewhere in the database.
 *
 * Workflow:
 *   1. Collect attachment IDs from the post BEFORE deletion (postmeta / content
 *      are still intact at this point).
 *   2. Permanently delete the post via wp_delete_post( $post_id, true ).
 *      WordPress removes the post record, all its postmeta (including
 *      _thumbnail_id), and all its term relationships.
 *   3. For each collected attachment ID, call jcci_abd_is_attachment_used_elsewhere().
 *      If the attachment is not referenced anywhere else, permanently delete it
 *      via wp_delete_attachment( $att_id, true ).
 *
 * @param int $post_id
 * @return int  Number of attachments permanently deleted.
 */
function jcci_abd_delete_post_with_attachments( $post_id ) {
    $post_id = intval( $post_id );

    // Step 1 — collect before we lose postmeta / post_content
    $attachment_ids = jcci_abd_get_post_attachment_ids( $post_id );

    // Step 2 — permanently delete the post
    wp_delete_post( $post_id, true );

    // Step 3 — delete attachments that are no longer referenced anywhere
    $deleted_count = 0;
    foreach ( $attachment_ids as $att_id ) {
        if ( ! jcci_abd_is_attachment_used_elsewhere( $att_id ) ) {
            wp_delete_attachment( $att_id, true );
            $deleted_count++;
        }
    }

    return $deleted_count;
}
