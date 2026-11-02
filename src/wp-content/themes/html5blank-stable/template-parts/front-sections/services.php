<?php 
$args = array(
    'post_type' => 'services',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
       array(
           'key' => 'in_front_page',
           'value' => true,
           'compare' => '=',
       )
    ),
    'orderby' => 'date',
    'order' => 'ASC'
);
$posts = get_posts($args);
$totalItems = count($posts);
?>

<section id="jcci-services" class="section">
    <div class="section--inner">
        <h3 class="section--title text-white">
            <?= jcci_translate_text('会員向けサービス') ?>
        </h3>
        <div class="section--content">
            <div class="section--content-inner">
                <div class="container">
                    <div class="row m-0">
                        <div id="services--slider" class="owl-carousel owl-theme text-white">
                            <?php foreach ($posts as $item): ?>
                                <div id="post-service-<?php echo $item->ID ?>" class="item services--item">
                                    <h4 class="services--title">
                                        <a href="<?= get_the_permalink($item->ID) ?>"><?= $item->post_title ?></a>
                                    </h4>
                                    <p class="services--excerpt"><?= $item->post_excerpt ?></p>
                                    <a class="d-flex justify-content-center mt-5" href="<?= get_the_permalink($item->ID) ?>">
                                        <div class="d-none text-white f-size-30 title--big title--big-sm">
                                            <?= jcci_translate_text('詳しくはこちら') ?>
                                        </div>
                                        <div class="icon--explorer">
                                            <i class="zmdi zmdi-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach ?>
                          </div>
                    </div>
                    <?php if ($totalItems > 1): ?>
                    <div class="slider--pagination">
                        <button class="slider--nav service-slider--nav slider--btn-prev" data-direction="prev"><i class="zmdi zmdi-arrow-left"></i></button>
                        <span class="slider--counter-current">01</span>/<span class="slider--counter-total"><?php echo str_pad($totalItems, 2, '0', STR_PAD_LEFT); ?></span>
                        <button class="slider--nav service-slider--nav slider--btn-next" data-direction="next"><i class="zmdi zmdi-arrow-right"></i></button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>  
</section>