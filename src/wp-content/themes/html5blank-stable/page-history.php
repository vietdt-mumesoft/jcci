<?php /* Template Name: History Template */ ?>
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
$item_list = $xpath->query("///table/tbody/tr/td");
$history_desc = $xpath->query("//*[@id='history-desc']");

$history_desc = $history_desc['length'] ? jcci_innerXML($history_desc[0]) : '';

$tds=array();
$data = array();

foreach ($item_list as $k => $td) {
    if ($k % 2 == 0) {
      $year = strip_tags(jcci_innerXML($td));
      $value = jcci_innerXML($item_list[$k + 1]);
      $content2 = explode("\n", $value);

      foreach ($content2 as $i => $v) {
          if (empty($v)) {
              unset($content2[$i]);
          }
      }
      $data[$year] = array_values($content2);
    }
}

$breadcrumb = array();
if ($parent_title) {

  array_push($breadcrumb, ['url' => $parent_link, 'text' => $parent_title]);
}
array_push($breadcrumb, ['url' => '#!', 'text' => $post->post_title]);

?>

<?php get_header(); ?>

<style>
    .timeline {
      list-style: none;
      padding: 50px 0 20px;
      position: relative;
    }

    .timeline:before {
      top: 0;
      bottom: 0;
      position: absolute;
      content: " ";
      width: 1px;
      background-color: #cad3d9;
      left: 50%;
      margin-left: -1px;
    }

    .timeline > li {
      margin-bottom: 20px;
      position: relative;
      width: 50%;
      float: left;
      clear: both;
    }

    .timeline > li:before,
    .timeline > li:after {
      content: " ";
      display: table;
    }

    .timeline > li:after {
      clear: both;
    }

    .timeline > li:before,
    .timeline > li:after {
      content: " ";
      display: table;
    }

    .timeline > li:after {
      clear: both;
    }

    .timeline > li > .timeline-panel {
      width: 95%;
      float: left;
      position: relative;
    }

    .timeline > li > .timeline-badge {
      color: #fff;
      width: 24px;
      height: 24px;
      line-height: 50px;
      font-size: 1.4em;
      text-align: center;
      position: absolute;
      top: 10px;
      right: -12px;
      /*background-color: #999999;*/
      z-index: 100;
      /*
      border-top-right-radius: 50%;
      border-top-left-radius: 50%;
      border-bottom-right-radius: 50%;
      border-bottom-left-radius: 50%;
      */;
    }
    .timeline > li.li-year {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .timeline > li.li-year .timeline-year {
        font-weight: bold;
        font-size: 24px;
        color: white;
        background-color: #036;
        padding: 5px 30px;
        border-radius: 50px;
    }

    .timeline > li.timeline-inverted > .timeline-panel {
      float: right;
    }

    .timeline-badge {
      color: #036 !important;
    }

    .timeline-badge:hover {
      color: #036666 !important;
    }

    .timeline-body > p,
    .timeline-body > ul {
      padding: 1.6rem 2rem;
      margin-bottom: 0;
    }

    .timeline-body > p + p {
      margin-top: 5px;
    }


    .timeline > li.timeline-inverted {
      float: right;
      clear: both;
      /*margin-top: 70px;*/
      /*margin-bottom: 30px;*/
    }

    .timeline > li:nth-child(2) {
      /*margin-top: 60px;*/
    }

    .timeline > li.timeline-inverted > .timeline-badge {
      left: -12px;
    }

    @media (max-width: 767px) {
      .timeline:before {
        left: 40px;
      }

      .timeline > li {
        width: 100%;
      }

      .timeline > li > .timeline-panel {
        width: calc(100% - 70px);
        width: -moz-calc(100% - 70px);
        width: -webkit-calc(100% - 70px);
      }

      .timeline > li > .timeline-badge {
        left: 28px;
        margin-left: 0;
        top: 0;
      }

      .timeline > li.li-year {
        justify-content: flex-start;
      }

      .timeline > li > .timeline-panel {
        float: right;
      }

      .timeline > li.timeline-inverted > .timeline-badge {
        left: 28px;
      }
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
                  <h3 class="content-title"><?= the_title() ?></h3>
                  <?php if ($history_desc) { ?>
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <div style="margin-bottom: 5rem;">
                        <?php echo $history_desc; ?>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <ul class="timeline">
                      <?php $count = 0; foreach ($data as $k => $year): ?>
                          <li class="li-year"><div class="timeline-year"><?= $k ?></div></li>
                          <?php foreach ($year as $i => $v): 
                              $class_inverted = $count % 2 != 0 ? 'timeline-inverted' : '';
                              ?>
                          <li class="<?= $class_inverted ?>">
                            <div class="timeline-badge text-primary"><i class="zmdi zmdi-dot-circle" rel="tooltip" title="11 hours ago via Twitter" id=""></i></div>
                            <div class="timeline-panel">
                              <div class="timeline-body">
                                <p><?= $v ?></p>
                              </div>
                            </div>
                          </li>
                          <?php $count++; endforeach ?>
                      <?php endforeach ?>
                      <li class="clearfix" style="float: none;"></li>
                  </ul>
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
