<?php
$breadcrumb = array();
$breadcrumb[] = ['url' => '#!', 'text' => 'Archives'];
?>

<?php get_header(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('article category fag-category'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h1 class="page--title"><?php _e( 'Archives', 'html5blank' ); ?></h1>
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
                        <div class="table-responsive-sm">
                            <table class="table table-sm">
                                <tbody>
                                <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                                    <tr>
                                        <td class="post--date"><?= get_the_date('Y.m.d') ?></td>
                                        <td>
                                            <a class="hover-underline post--title" href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                            
                        <div class="pagination"><?php html5wp_pagination(); ?></div>

                        <?php else: ?>
                            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-3 col-md-4 page--content-right">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
