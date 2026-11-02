<?php
$page_parent = jcci_get_children_page();
$parent_title = $page_parent['parent_title'];
$parent_id = $page_parent['parent_id'];
$children = $page_parent['children'];

$parent_link = '#!';

if ($children && count($children) > 0) {
  $parent_link = esc_url( get_the_permalink( $children[0] ) );
}

$breadcrumb = array();
if ($parent_title) {
  array_push($breadcrumb, ['url' => $parent_link, 'text' => $parent_title]);
}
array_push($breadcrumb, ['url' => '#!', 'text' => strip_tags($post->post_title)]);
?>

<?php get_header(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class('page--inner'); ?>>
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
                        <?php edit_post_link(); ?>
                        <h3 class="content-title"><?php the_title(); ?></h3>
                        
                        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

        				    <?php the_content(); ?>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <p><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></p>

                        <?php endif; ?>
        			</div>
                    <?php if ($parent_id && $children) { ?>
        			<div class="col-lg-3 col-md-4 page--content-right">
        				<?= jcci_right_menu($children); ?>
        			</div>
                    <?php } ?>
        		</div>
        	</div>
        </div>
    </div>

<?php get_footer(); ?>
