<?php /* Template Name: Member List Template */ ?>

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

$tabs = ['貿易部会', '建設部会', '工業部会', '金融保険部会', 'サービス等部会', '運輸部会'];
$char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$char = str_split($char);
$users = [
    [
        'group' => '貿易部会',
        'company_name' => 'ALCONIX VIETNAM CO., LTD',
        'company_name_ja' => 'アルコニックス　ベトナム'
    ],
    [
        'group' => '貿易部会',
        'company_name' => 'ALPS ELECTRIC VIETNAM CO., LTD',
        'company_name_ja' => 'アルプスエレクトリックベトナム'
    ],
    [
        'group' => '貿易部会',
        'company_name' => 'AZUMA VIETNAM INVESTMENT AND TRADING CO., LTD',
        'company_name_ja' => 'アズマ　ベトナム'
    ],
    [
        'group' => '貿易部会',
        'company_name' => 'COMINIX VIETNAM CO., LTD',
        'company_name_ja' => 'コミニックス　ベトナム'
    ],
    [
        'group' => '貿易部会',
        'company_name' => 'DAIICHI JITSUGYO (VIETNAM) CO., LTD',
        'company_name_ja' => '第一実業　ベトナム'
    ],
];

$breadcrumb = array();
if ($parent_title) {
  array_push($breadcrumb, ['url' => $parent_link, 'text' => $parent_title]);
}
array_push($breadcrumb, ['url' => '#!', 'text' => $post->post_title]);

?>

<style>
.page--member-list h4 {
    margin-bottom: 2rem;
    margin-top: 3rem;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
table td, table th,
.table td, .table th {
    padding: 1.6rem .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    min-width: auto;
}
.group-table table tr td, .group-table table tr th {
    border: 1px solid #dee2e6;
}
.group-table table tr td:first-child,
.group-table table tr th:first-child {
    border-left-width: 0;
}
.group-table table tr td:last-child,
.group-table table tr th:last-child {
    border-right-width: 0;
}
.group-table table tr:first-child td,
.group-table table tr:first-child th {
    border-top: unset;
}
.group-table table tr:last-child td {
    border-bottom: 1px solid #dee2e6;
}
</style>

    <div id="post-<?php the_ID(); ?>" <?php post_class('page--inner page--member-list'); ?>>
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

                        <?php if (0) { ?>
                        <nav class="mb-5">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <?php foreach ($tabs as $key => $item): ?>
                                    <a class="nav-item nav-link" href="#group-<?= $key ?>"><?= $item ?></a>
                                <?php endforeach ?>
                            </div>
                        </nav>
                        
                        <?php foreach ($tabs as $key => $item): ?>
                        <div id="group-<?= $key ?>" class="mb-4 group-table">
                            <div class="table-responsive-sm">
                                <h4><?= $item ?></h4>
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($users as $k => $u): ?>
                                        <tr>
                                            <td>TD<?php echo str_pad($k + 1, 4, '0', STR_PAD_RIGHT); ?></td>
                                            <td><?= $u['company_name'] ?></td>
                                            <td><?= $u['company_name_ja'] ?></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php } ?>
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
