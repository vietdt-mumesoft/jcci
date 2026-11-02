<?php 
$post_type = 'post-news';
$taxonomy = 'news_category';
$cats=  get_categories(array( 'taxonomy' => $taxonomy ));
$posts = jcci_get_posts_by_post_type($post_type);

if (!$cats) {
    $cats=  get_categories(array( 'taxonomy' => $taxonomy, 'lang' => 'ja' ));
}

if (!$posts) {
    $posts = jcci_get_posts_by_post_type( $post_type, array( 'lang' => 'ja' ) );
}
?>

<section id="jcci-news" class="section">
    <div class="section--inner">
        <h3 class="section--title" style="color: red;">
            最新情報 
        </h3>
        <div class="section--content">
            <div class="section--content-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 ">
                            <nav>
                                <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true"><?php echo jcci_translate_text('最新情報') ?></a>
                                    <?php foreach ($cats as $key => $cat): 
                                        if ($cat->parent) {
                                            continue;
                                        }
                                        ?>
                                        <a class="nav-item nav-link" id="nav-<?= $key ?>-tab" data-toggle="tab" href="#nav-<?= $key ?>" role="tab" aria-controls="nav-<?= $key ?>" aria-selected="false"><?= $cat->name ?></a>
                                    <?php endforeach ?>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0 col-md-12 m-auto" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <tbody>
                                                <?php $count = 0;
						foreach ($posts as $item): 
                                                    if ($count >= 3) break;
						    $terms = get_the_terms($item->ID, $taxonomy);
                                                    $cat_name = '';
                                                    $cat_link = '#';
                                                    if ( ! empty( $terms ) ) {
                                                        $cat_name = esc_html( $terms[0]->name );
                                                        $cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
                                                    }
                                                    ?>
                                                <tr class="post-id-<?= $item->ID ?>">
                                                    <td><a class="news--cat" href="<?= $cat_link ?>" title="<?= $cat_name ?>"><?= $cat_name ?></a></td>
                                                    <td><a class="news--date" href="#">
                                                        <?= date('Y年m月d日', strtotime($item->post_date)) ?></a>
                                                    </td>
                                                    <td>
                                                        <a class="hover-underline news--title" href="<?= get_permalink($item->ID) ?>" title="<?= $item->post_title ?>">
                                                            <?= $item->post_title ?></a><br>
                                                        <span class="news--excerpt"><?= $item->post_excerpt ?></span>
                                                    </td>
                                                </tr>
                                                <?php
						    $count++; 
						endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php foreach ($cats as $key => $cat): 
                                    if ($cat->parent) {
                                        continue;
                                    }
                                    ?>
                                <div class="tab-pane fade" id="nav-<?= $key ?>" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <tbody>
                                                <?php 
                                                $myposts = jcci_get_posts_by_term_id($cat->term_id, $post_type, $taxonomy);
                                                ?>
                                                <?php if ($myposts): ?>
                                                <?php foreach ($myposts as $item): ?>
                                                <tr>
                                                    <td>
                                                        <a class="news--cat" href="<?= get_category_link($cat->term_id) ?>">
                                                        <?= $cat->name ?></a></td>
                                                    <td><a class="news--date" href="#" title="">
                                                    <?= date('Y年m月d日', strtotime($item->post_date)) ?></a></td>
                                                    <td>
                                                        <a class="hover-underline news--title" href="<?= get_permalink($item->ID) ?>">
                                                            <?= $item->post_title ?></a><br>
                                                        <span class="news--excerpt"><?= $item->post_excerpt ?></span>
                                                    </td>
                                                </tr>
                                                <?php break; endforeach ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>
                        
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-sm-12 text-center">
                            <?php
                            $link_view_all_news = get_field( 'link_view_all_news', get_query_var( 'page_id' ) );
                            $link_view_all_news = is_string( $link_view_all_news ) ? $link_view_all_news : '';
                            ?>
                            <a href="<?= esc_url( $link_view_all_news ) ?>" class="btn btn-large btn-hover btn-view-all"><?php echo jcci_translate_text('一覧はこちら') ?> <i class="zmdi zmdi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
