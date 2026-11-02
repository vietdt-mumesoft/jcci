<?php /* Template Name: JCCI Newspaper Template */ ?>

<?php get_header(); ?>

<?php
global $wpdb;

$page_parent = jcci_get_children_page();
$parent_title = $page_parent['parent_title'];
$parent_id = $page_parent['parent_id'];
$children = $page_parent['children'];

$parent_link = '#!';

if ($children && count($children) > 0) {
  $parent_link = esc_url( get_the_permalink( $children[0] ) );
}

$post_content = $post->post_content;
$dom = new DomDocument();
$dom->preserveWhitespace = true;
$dom->encoding              = 'UTF-8';
$dom->formatOutput          = true;
$dom->loadHTML('<?xml encoding="utf-8" ?>' . $post_content ); 
// $dom->loadHTML(mb_convert_encoding($post_content, 'HTML-ENTITIES', 'UTF-8'));
$xpath = new DOMXPath($dom);
$classname = 'table_newspaper'; // The class we are looking for
$item_list = $xpath->query("//*[contains(@class, '$classname')]/tbody/tr/td");
$tds=array();
$data = array();
$per_page = 10;
$totalItems = 19;

foreach ($item_list as $k => $td) {
    // $tds[]=$td->nodeValue;
    $tds[]=jcci_innerXML($td);
    if (($k + 1) % 3 == 0) {
        $data[] = $tds;
        $tds = array();
    }
}
$data = array_chunk($data,$per_page);

$breadcrumb = array();
if ($parent_title) {
  array_push($breadcrumb, ['url' => $parent_link, 'text' => $parent_title]);
}
array_push($breadcrumb, ['url' => '#!', 'text' => $post->post_title]);

?>

<style>
    .newspaper-no {
        color: #036;
    }
    .page--newspaper .slider--pagination {
        position: static;
    }
    .slider--pagination .slider--counter-current {
        color: #036;
    }
    .slider--pagination .slider--nav:hover {
        color: #036;
    }
</style>

    <div id="post-<?php the_ID(); ?>" <?php post_class('page--inner page--newspaper'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h1 class="page--title"><?= $parent_title ? $parent_title : the_title() ?></h1>
        </div>
        <div class="page--breadcrumb">
            <div class="container">
                <?php jcci_render_breadcrumb($breadcrumb); ?>
            </div>
        </div>
        <div id="page-newspaper-slide" class="page--content">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-md-8 page--content-left">
                      <h3 class="content-title"><?= the_title() ?></h3>
                      <div id="newspaper-slide" class="mb-5 newspaper-slide owl-carousel owl-theme">
                      <?php foreach ($data as $k => $value): ?>
                          <div class="newspaper-item">
                            <div class="table-responsive-sm">
                                <table class="text-center table">
                                    <tbody>
                                        <?php foreach ($value as $i => $item): ?>
                                            <?php $no = explode('.', $item[0]); ?>
                                            <tr>
                                                <td class="align-middle newspaper-no"><?= $no[0] ?>.<span class="f-size-48"><?= $no[1] ?></span></td>
                                                <td class="align-middle newspaper-date"><?= $item[1] ?></td>
                                                <td class="text-left align-middle newspaper-link">
                                                    <i class="zmdi zmdi-collection-pdf"></i> <?= $item[2] ?>
                                                    <?= $k == 0 && $i == 0 ? '<span class="text-danger">　　// 最終号</span>' : '' ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      <?php endforeach ?>
                      </div>

                        <?php if ($totalItems > 1): ?>
                        <div class="slider--pagination">
                            <button class="slider--nav newspaper-slider--nav slider--btn-prev" data-direction="prev"><i class="zmdi zmdi-arrow-left"></i></button>
                            <span class="slider--counter-current">01</span>/<span class="slider--counter-total"><?php echo str_pad($totalItems, 2, '0', STR_PAD_LEFT); ?></span>
                            <button class="slider--nav newspaper-slider--nav slider--btn-next" data-direction="next"><i class="zmdi zmdi-arrow-right"></i></button>
                        </div>
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
