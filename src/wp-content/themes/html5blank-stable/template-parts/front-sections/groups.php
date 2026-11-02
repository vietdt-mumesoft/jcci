<?php 
$post_type = 'organization';
$taxonomy = 'organization_category';
$args = array(
    'number' => 4, 
    'hide_empty' => false, 
    'childless' => true,
    'order' => 'ASC',
    'orderby' => 'description' 
);
$cats = get_terms( $taxonomy, $args );

$menus = [];
?>

<section id="jcci-groups" class="section">
    <div class="section--inner">
        <h3 class="section--title">
        <?= jcci_translate_text('組織構成') ?>
        </h3>
        <div class="section--content">
            <div class="container">
                <div class="section--content-inner">
                    <div class="row m-0">
                        <?php foreach ($cats as $key => $item): 
                            $tax_term_id = $item->term_taxonomy_id;
                            $images = get_option('taxonomy_image_plugin'); // Must install plugin firstly.
                            $posts = jcci_get_posts_by_term_id ($tax_term_id, $post_type, $taxonomy, array('posts_per_page' => -1));
                            // TODO: because current system is using admin menu to display in order and we don't know special character to check the values in ['商工部会', 'Các chi hội', 'Departments']. Need to update this code when re-ordering menu in admin.
                            if ($key == 0) {
                                foreach ($posts as $post) {
                                    $menus[$post->menu_order] = [
                                        'ID' => $post->ID,
                                        'post_title' => $post->post_title
                                    ];
                                }
                                ksort($menus);
                            }
                        ?>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 groups--item">
                            <div class="groups--item-inner">
                                <h4 class="groups--title">
                                    <div class="groups--title-number"><?= '0' . ($key + 1) ?></div>
                                    <div class="groups--title-text"><?= $item->name ?></div>
                                </h4>
                                <div class="groups--desc">
                                    <ul>
                                        <?php 
                                            // TODO: because current system is using admin menu to display in order and we don't know special character to check the values in ['商工部会', 'Các chi hội', 'Departments']. Need to update this code when re-ordering menu in admin.
                                            if ($key == 0):
                                        ?>
                                            <?php foreach ($menus as $menu):?>
                                                <li><a href="<?= get_the_permalink($menu['ID']) ?>"><?= $menu['post_title'] ?></a></li>
                                            <?php endforeach?>
                                        <?php else: ?>
                                            <?php foreach ($posts as $v):?>
                                                <li><a href="<?= get_the_permalink($v->ID) ?>"><?= $v->post_title ?></a></li>
                                            <?php endforeach?>
                                        <?php endif?>
                                    </ul>
                                </div>
                                <div class="text-center groups--thumb">
                                    <?php if (wp_get_attachment_image( $images[$tax_term_id], 'organization-thumb' )): ?>
                                    <?php echo wp_get_attachment_image( $images[$tax_term_id], 'organization-thumb' ); ?>
                                    <?php else: ?>
                                        <img src="<?= get_template_directory_uri() . '/assets/img/groups-'.($key + 1).'.jpg' ?>" alt="<?= $item->name ?>">
                                    <?php endif; ?>
                                    <div class="d-none text-white f-size-30 title--big title--big-sm">
                                        <?= jcci_translate_text('詳しくはこちら') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>