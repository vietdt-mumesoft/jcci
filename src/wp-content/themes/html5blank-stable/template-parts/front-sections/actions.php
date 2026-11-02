<?php 
$post_type = 'actions';
$posts = jcci_get_posts_by_post_type($post_type, array('posts_per_page' => 4));

if (!$posts) {
    $posts = jcci_get_posts_by_post_type($post_type, array('posts_per_page' => 4, 'lang' => 'ja'));
}

$default_thumb = get_template_directory_uri() . '/assets/img/thumb-default.jpg';
?>

<section id="jcci-actions" class="section">
    <div class="section--inner">
        <h3 class="section--title">
            <?= jcci_translate_text('活動報告') ?>
        </h3>
        <div class="section--content">
            <div class="section--content-inner">
                <div class="row m-0">
                    <?php foreach ($posts as $key => $item): 
                        $thumb_url = get_the_post_thumbnail_url($item->ID, 'actions-thumb');
                        $thumb_url = $thumb_url ? $thumb_url : $default_thumb;
                        ?>
                    <div class="actions--item p-0 mb-4">
                        <div class="actions--inner">
                            <a href="<?= get_the_permalink($item->ID) ?>" class="actions--thumb" style="background-image: url(<?= $thumb_url; ?>);">
                                <div class="icon--explorer">
                                    <i class="zmdi zmdi-arrow-right"></i>
                                </div>
                                <div class="d-sm-none mb-0 text-white f-size-30 title--big title--big-sm">
                                    <?= jcci_translate_text('詳しくはこちら') ?>
                                </div>
                            </a>
                            <div class="actions--info">
                                <div class="actions--info-number"><?php echo '0' . ($key + 1) . '.' ?></div>
                                <a class="actions--info-title" href="<?= get_the_permalink($item->ID) ?>" title="<?= $item->post_title ?>"><?php echo strip_tags($item->post_title) ?></a>
                                <div class="actions--info-date">
                                    <span><?= date('Y年m月d日', strtotime($item->post_date)) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <div class="row m-0">
                    <div class="col-sm-12 text-center">
                        <a href="<?= get_field('link_view_all_actions', get_query_var( 'page_id' )) ?>" class="btn btn-large btn-hover btn-view-all">
                            <?php echo jcci_translate_text('一覧はこちら') ?> <i class="zmdi zmdi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>