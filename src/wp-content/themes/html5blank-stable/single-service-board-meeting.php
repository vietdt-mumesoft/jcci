<?php
/*
 * Template Name: Board Meeting Document Template
 * Template Post Type: services
 */
?>

<?php 
$required_login = get_field('required_login');
if ($required_login) {
    jcci_force_login();
}

$children = jcci_get_main_service_member();
$main_title = jcci_translate_text('会員向けサービス');

$breadcrumb = array();
if ($children && count($children) > 0) {
    $parent_link = esc_url( get_the_permalink( $children[0] ) );
    $breadcrumb[] = ['url' => $parent_link, 'text' => strip_tags($main_title)];
}
$breadcrumb[] = ['url' => '#!', 'text' => strip_tags(get_the_title())];
?>

<?php get_header(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class('article fag-category single-services'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h1 class="page--title"><?= $main_title ?></h1>
        </div>
        <div class="page--breadcrumb">
            <div class="container">
                <?php jcci_render_breadcrumb($breadcrumb); ?>
            </div>
        </div>
        <div class="page--content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-8 mb-5 page--content-left">
                        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                            <h3><?php the_title(); ?></h3>
                            <?php the_content(); ?>
                            <?php edit_post_link(); ?>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <p><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-3 col-md-4 page--content-right">
                        <?= jcci_right_menu($children) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
