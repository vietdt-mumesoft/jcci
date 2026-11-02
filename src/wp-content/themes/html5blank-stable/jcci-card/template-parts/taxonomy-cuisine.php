<?php
/**
 * Template for Cuisine taxonomy
 */

$color = jcci_card_get_post_color();
$en_label = 'Restaurant';
$jp_label = 'レストラン';
?>

<main id="main" class="">
    <div id="content" class="content-area restaurant-wrapper <?php echo $color; ?>" role="main">
        <div class="row row-main">
            <div class="large-10 col mx-auto">
                <?php get_template_part('jcci-card/template-parts/parts/store-taxonomy-head'); ?>
                <?php get_template_part('jcci-card/template-parts/parts/store-taxonomy-terms'); ?>
                <?php get_template_part('jcci-card/template-parts/parts/store-taxonomy-meta'); ?>
                <div class="row">
                    <div class="large-12 col">
                      <?php
                      if (have_posts()) {
                        while (have_posts()) {
                          the_post();
                          get_template_part('jcci-card/template-parts/parts/store-list-item');
                        }
                      }
                      ?>
                    </div>
                </div>
                <!-- Pagination -->
                <!-- <ul class="page-numbers nav-pagination links text-center"><li><span aria-current="page" class="page-number current">1</span></li><li><a class="page-number" href="https://jcci-card.vn/restaurants/page/2/">2</a></li><li><a class="page-number" href="https://jcci-card.vn/restaurants/page/3/">3</a></li><li><a class="next page-number" href="https://jcci-card.vn/restaurants/page/2/"><i class="icon-angle-right"></i></a></li></ul> --> 
                <?php
                // Get the pagination links
                $pagination_args = array(
                    'type'      => 'array',
                    'prev_text' => '<i class="icon-angle-left"></i>',
                    'next_text' => '<i class="icon-angle-right"></i>',
                    'mid_size'  => 1,
                    'end_size'  => 1,
                );
                $pagination = paginate_links($pagination_args);
                ?>
                
                <?php if ($pagination) : ?>
                  <ul class="page-numbers nav-pagination links text-center">
                      <?php foreach ($pagination as $page_link) : ?>
                          <li><?php echo $page_link; ?></li>
                      <?php endforeach; ?>
                  </ul>
                <?php endif; ?>

            </div>
            <!-- .large-12 -->
        </div>
        <!-- .row -->
    </div>

    <?php get_template_part('jcci-card/template-parts/parts/store-archive-bottom'); ?>
</main>