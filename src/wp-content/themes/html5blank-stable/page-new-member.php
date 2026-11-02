<?php /* Template Name: New Member Template */ ?>

<?php get_header(); ?>

<?php
global $wpdb;

$page_parent = jcci_get_children_page();
$parent_title = $page_parent['parent_title'];
$parent_id = $page_parent['parent_id'];
$children = $page_parent['children'];

$parent_link = '#!';

if ($children && count($children) > 0) {
  $parent_link = esc_url( get_the_permalink( $children[0] ) );
}

// Get all posts
$taxonomy = 'new_member_category';
$post_type = 'new-member';
$default_thumb = get_template_directory_uri() . '/assets/img/actions-1.jpg';

$term_meta = $wpdb->get_results( "SELECT term_id FROM {$wpdb->termmeta} WHERE meta_key='period_date_to_date' AND meta_value > NOW()" );
$term_ids = [];
foreach ($term_meta as $v) {
    $term_ids[] = $v->term_id;
}
rsort($term_ids);
$term_id = reset($term_ids);
$term = get_term( $term_id, $taxonomy );

$posts = jcci_get_posts_by_term_id($term_id, $post_type, $taxonomy, array('posts_per_page' => -1));

if (!$posts) {
    $term_meta = $wpdb->get_results( "SELECT term_id FROM {$wpdb->termmeta} WHERE meta_key='period_date_to_date' AND meta_value < NOW()" );
    foreach ($term_meta as $v) {
        $term_ids[] = $v->term_id;
    }
    rsort($term_ids);
    $term_id = reset($term_ids);
    $term = get_term( $term_id, $taxonomy );
    $posts = jcci_get_posts_by_term_id($term_id, $post_type, $taxonomy, array('posts_per_page' => -1));
}

$breadcrumb = array();
if ($parent_title) {
  array_push($breadcrumb, ['url' => $parent_link, 'text' => $parent_title]);
}
array_push($breadcrumb, ['url' => '#!', 'text' => $post->post_title]);

foreach ($posts as $key => $item){
    $is_table = get_field('is_table', $item->ID);
    if(boolval($is_table) && empty($tableItem)){
        $tableItem = $item;
        break;
    }
}
?>

<style>
.page--member-list h4 {
    margin-bottom: 2rem;
    margin-top: 3rem;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
table td, table th,
.table td, .table th {
    padding: 1.6rem .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    min-width: auto;
}
.group-table table tr td, .group-table table tr th {
    border: 1px solid #dee2e6;
}
.group-table table tr td:first-child,
.group-table table tr th:first-child {
    border-left-width: 0;
}
.group-table table tr td:last-child,
.group-table table tr th:last-child {
    border-right-width: 0;
}
.group-table table tr:first-child td,
.group-table table tr:first-child th {
    border-top: unset;
}
.group-table table tr:last-child td {
    border-bottom: 1px solid #dee2e6;
}
</style>

    <div id="post-<?php the_ID(); ?>" <?php post_class('page--inner page--member-list'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h1 class="page--title"><?= $parent_title ? $parent_title : the_title() ?></h1>
        </div>
        <div class="page--breadcrumb">
            <div class="container">
                <?php jcci_render_breadcrumb($breadcrumb); ?>
            </div>
        </div>
        <div class="page--content">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-md-8 page--content-left">
                        <?php if ($posts): ?>
                        <h3 class="content-title"><?= $term->name ?></h3>
                        <div class="row">
                            <?php
                            $col_class = count($posts) == 1 ? 'col-sm-12' : 'col-sm-6';
                            foreach ($posts as $item) : 
                                $is_table = get_field('is_table', $item->ID);
                                $position = get_field('position', $item->ID);
                                $full_name = get_field('full_name', $item->ID);
                                $organization = get_field('organization', $item->ID);
                                $thumb_url = get_the_post_thumbnail_url($item->ID, 'new-member-thumb');
                                $thumb_url = $thumb_url ? $thumb_url : $default_thumb;
                                if(!boolval($is_table)): 
                            ?>
                                <div class="<?= $col_class ?> col-xs-12 mb-5">
                                    <div class="p-3 mb-4 member-thumb">
                                        <img src="<?= $thumb_url ?>" alt="<?= $item->post_title ?>">
                                    </div>
                                    <div class="p-3 member-info">
                                        <div class="mb-4 text-primary f-size-30 font-weight-bold member-info--title">
                                            <?= $item->post_title ?>
                                        </div>
                                        <div class="mb-4 member-info--posname">
                                            <span class="f-size-18 member-info-position"><?= $position ?></span><br>
                                            <span class="f-size-20 font-weight-extrabold member-info-name"><?= $full_name ?></span><br>
                                            <span class="member-info-organiztion"><?= $organization ?></span>
                                        </div>
                                        <div class="text-justify member-info--desc">
                                            <?= apply_filters('the_content', $item->post_content) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php  endif; 
                                endforeach; ?>

                            <?php if(!empty($tableItem)):?>
                                <div class="col-sm-6 col-xs-12 mb-5">
                                    <div class="p-3 member-info">
                                        <div class="text-justify member-info--desc">
                                            <div class="mb-4 group-table">
                                                <?= apply_filters('the_content', $tableItem->post_content) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                            endif; 
                            ?>

                        </div>
                        <?php else: ?>
                            <p><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></p>
                        <?php endif; ?>
        			</div>
                    <?php if ($parent_id && $children) { ?>
        			<div class="col-lg-3 col-md-4 page--content-right text-center">
        				<?= jcci_right_menu($children); ?>
        			</div>
                    <?php } ?>
        		</div>
        	</div>
        </div>
    </div>

<?php get_footer(); ?>
