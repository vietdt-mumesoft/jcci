<?php

$required_login = get_field('required_login');
if ($required_login) {
    jcci_force_login();
}

$post_id = $post->ID;
$post_parent = $post->post_parent;
if ( $post_parent ) {
    $post_id = $post_parent; 
}

$post_type = 'services';
$taxonomy = 'services_category';
$cat_title = array();
$term_list = wp_get_post_terms($post_id, $taxonomy); 

foreach ($term_list as $term) {
    if (!$term->parent) {
        continue;
    }
    $cat_title[$term->parent] = $term->name;
}
ksort($cat_title);
$group_cat_title = join('_', $cat_title);
if (empty($group_cat_title)) {
    $group_cat_title = jcci_translate_text('会員向けサービス');
}


$post_categories = jcci_get_primary_category($post_id, $taxonomy); 
if($post_categories){
    $primary_category = $post_categories['primary_category'];
}
// $posts_same_cat = jcci_get_posts_by_term_id ($primary_category->term_id, $post_type, $taxonomy, array('posts_per_page' => -1,));

$children = jcci_get_main_service_member();

$breadcrumb = array();
if ($children && count($children) > 0) {
  $parent_link = esc_url( get_the_permalink( $children[0] ) );
  $breadcrumb[] = ['url' => $parent_link, 'text' => strip_tags($group_cat_title)];
}
if ( $post_parent ) {
    $parent_link = esc_url( get_the_permalink( $post_parent ) );
    $breadcrumb[] = ['url' => $parent_link, 'text' => strip_tags(get_the_title( $post_parent ))];
}
$breadcrumb[] = ['url' => '#!', 'text' => strip_tags($post->post_title)];

?>

<?php get_header(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('article single-organization'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h1 class="page--title"><?php echo $group_cat_title; ?></h1>
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
                        <?= jcci_right_menu($children) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>