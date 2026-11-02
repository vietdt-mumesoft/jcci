<?php 
$term = get_queried_object();
$parent_cat_name = get_the_category_by_ID($term->parent);
$main_title = [$parent_cat_name];
$main_title = join('_',$main_title);

$children = get_terms( $term->taxonomy, array(
    'parent'    => $term->parent,
    'hide_empty' => false
) );

$posts = jcci_get_posts_by_term_id ($term->term_id, 'post-faq', $term->taxonomy, ['posts_per_page' => -1]);

$parent_cat_link = get_term_link($term);
if ($children && $children[0]) {
    $parent_cat_link = get_term_link($children[0]);
}

$breadcrumb = array();
array_push($breadcrumb, ['url' => $parent_cat_link, 'text' => $parent_cat_name]);
array_push($breadcrumb, ['url' => '#!', 'text' => single_cat_title('', false)]);
?>

<?php get_header(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('article category fag-category'); ?>>
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
                        <h3 class="content-title"><?php single_cat_title(); ?></h3>
                            <div class="accordion" id="accordion-tab-1">
                                <?php 
                                $count = 1;
                                if ($posts):
                                    foreach ($posts as $item):
                                    $count = $count < 10 ? '0' . $count : $count; 
                                    $edit_post_link = get_edit_post_link($item->ID)
                                        ? '<a class="post-edit-link" href="' . esc_url( get_edit_post_link($item->ID) ) . '">Edit</a>'
                                        : '';
                                ?>
                                
                                <div class="card">
                                    <div class="card-header" id="accordion-tab-<?= $count ?>-heading-<?= $count ?>">
                                        <h5 class="clearfix">
                                            <div class="float-left faq-number"><?= $count.'.' ?></div>
                                            <div class="float-left faq-char-qa">Q:</div>
                                            <div class="float-left faq-question"><?= $item->post_title ?></div>
                                            <button class="btn btn-link" type="button" 
                                                data-toggle="collapse" 
                                                data-target="#accordion-tab-<?= $count ?>-content-<?= $count ?>" 
                                                aria-expanded="false" 
                                                aria-controls="accordion-tab-<?= $count ?>-content-<?= $count ?>">
                                            </button>
                                        </h5>
                                    </div>
                                    <div class="collapse" id="accordion-tab-<?= $count ?>-content-<?= $count ?>" 
                                        aria-labelledby="accordion-tab-<?= $count ?>-heading-<?= $count ?>" 
                                        data-parent="#accordion-tab-1">
                                        <div class="card-body">
                                            <div class="clearfix">
                                                <div class="float-left faq-char-qa">A:</div>
                                                <div class="float-left faq-answer">
                                                    <?= apply_filters('the_content', $item->post_content) ?>
                                                    <?= $edit_post_link; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php $count++; endforeach; else: ?>
                                <p>No answers and questions</p> 
                                <?php endif; ?>
                            </div>
                    </div>
                    <div class="col-lg-3 col-md-4 page--content-right">
                        <?php echo jcci_right_menu( $children ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
