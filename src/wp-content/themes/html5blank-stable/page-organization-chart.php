<?php /* Template Name: Organization Chart Template */ ?>

<?php get_header(); ?>

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
array_push($breadcrumb, ['url' => '#!', 'text' => $post->post_title]);
?>

<style>
    .toggle-organization-chart {
        cursor: pointer;
    }
.toggle-organization-chart:after {
    margin-left: 2rem;
    content: '\f278';
    display: inline-block;
    font: normal 700 normal 14px/1 'Material-Design-Iconic-Font';
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.toggle-organization-chart.show-chart:after {
    content: '\f273';
}
.organization-chart {
    display: none;
}
.show-chart ~ .organization-chart {
    display: inline-block;
}
</style>

    <div id="post-<?php the_ID(); ?>" <?php post_class('page--inner page--organization-chart'); ?>>
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

                        <?php if (0): //Here is format content in case editor input wrong content ?>
                        <h4>組織図</h4>
                        <p class="toggle-organization-chart">クリックすると別ウィンドウにて表示されます</p>

                        <div class="organization-chart"><img class="alignnone size-full wp-image-2320" src="http://jcci.lo/wp-content/uploads/2019/10/4.-Lesson-4.jpg" alt="" /></div>
                        <h4>支援団体</h4>
                        <h5>ハノイ日本婦人会</h5>
                        <img class="size-full wp-image-2321 aligncenter" src="http://jcci.lo/wp-content/uploads/2019/10/03.jpg" alt="" />

                        1998年4月発足
                        ハノイ市またはその近郊に居住する日本人女性を対象に、会員相互の親睦と情報提供の窓口として活動しています。

                        <strong class="text-primary">連絡先</strong>: <a href="mailto:info@hjwc-vn.com">info@hjwc-vn.com</a>
                        <strong class="text-primary">ホームページ</strong>: <a href="mailto:info@hjwc-vn.com">info@hjwc-vn.com</a>
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
