<?php
$post_type = 'organization';
$taxonomy = 'organization_category';
$cat_title = array();

$post_id = $post->ID;
$post_parent = $post->post_parent;
if ( $post_parent ) {
    $post_id = $post_parent; 
}

$term_list = wp_get_post_terms($post_id, $taxonomy); 

foreach ($term_list as $term) {
    $cat_title[$term->parent] = $term->name;
}
ksort($cat_title);
$group_cat_title = isset(array_keys($cat_title)[0]) ? $cat_title[array_keys($cat_title)[0]] : "";

$post_categories = jcci_get_primary_category($post_id, $taxonomy);
$primary_category = $post_categories['primary_category'];
$posts_same_cat = jcci_get_posts_by_term_id ($primary_category->term_id, $post_type, $taxonomy, array('posts_per_page' => -1,));

$breadcrumb = array();
if ( $posts_same_cat && count($posts_same_cat) > 0 ) {
    usort($posts_same_cat, function ($post1, $post2) {
        return $post1->menu_order <=> $post2->menu_order;
    });
    $parent_link = esc_url( get_the_permalink( $posts_same_cat[0] ) );
    $breadcrumb[] = ['url' => $parent_link, 'text' => $group_cat_title];
}
if ( $post_parent ) {
    $parent_link = esc_url( get_the_permalink( $post_parent ) );
    $breadcrumb[] = ['url' => $parent_link, 'text' => strip_tags(get_the_title( $post_parent ))];
}
$breadcrumb[] = ['url' => '#!', 'text' => strip_tags($post->post_title)];

$main_title = $group_cat_title ? $group_cat_title : strip_tags($post->post_title);
?>

<?php get_header(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('article single-organization'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h1 class="page--title"><?php echo $main_title; ?></h1>
        </div>
        <div class="page--breadcrumb">
            <div class="container">
                <?php jcci_render_breadcrumb($breadcrumb); ?>
            </div>
        </div>
        <div class="page--content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 page--content-left">
                        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                            <?php edit_post_link(); ?>
                            <?php the_content(); ?>
                        <?php endwhile; endif; ?>
                    </div>
                    <div class="col-md-4 text-center page--content-right">
                        <?= jcci_right_menu_organization($posts_same_cat) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>