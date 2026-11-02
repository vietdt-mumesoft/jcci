<?php /* Template Name: Messages Ambassador Template */ 

$page_parent   = jcci_get_children_page();
$parent_title  = $page_parent['parent_title'];
$parent_id     = $page_parent['parent_id'];
$children      = $page_parent['children'];
$parent_link   = '#!';

if ($children && count($children) > 0) {
  $parent_link = esc_url( get_the_permalink( $children[0] ) );
}

$breadcrumb = array();
if ($parent_title) {
  array_push($breadcrumb, ['url' => $parent_link, 'text' => $parent_title]);
}
array_push($breadcrumb, ['url' => '#!', 'text' => strip_tags($post->post_title)]);

// get post lastest
$post_type = 'messages';
$taxonomy = 'messages_category';

//get all term
$terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => true,
    'orderby' => 'term_id',
    'order'   => 'ASC',
]);

$term_order = 2;
$index = 1;

foreach( $terms as $term ){
    if($index < 2) {
        $index++;
        continue; 
    }
    $term_id = $term->term_id;
    break;
}

$args = [
    'post_type'      => $post_type,
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => $taxonomy,
            'terms'    => $term_id,
            'field'    => 'term_id',
        )
    ),
    'orderby' => 'date',
    'order'   => 'DESC',
];

if (isset($_GET['y'])) {
    $y = filter_var($_GET['y'], FILTER_SANITIZE_NUMBER_FLOAT);
    $arrDate = array( 'year' => substr($y, 0, 4), 'month' => substr($y, 5, 2) );
    $args = array_merge($args, ['date_query' => array($arrDate)]);
}

// Get all years with published post    
$years = jcci_get_posts_year_months($post_type, $term_id, 'year_month');

$query = new WP_Query( $args );
?>

<?php get_header(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class('page--inner'); ?>>
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
                        <div class="mb-5 filter--year--month cus-select">
                            <select name="select--year" class="no-appearance">
                                <?php foreach ($years as $y): ?>
                                    <option value="<?= $y['val'] ?>" <?= ($y['val'] == $_GET['y']) ? 'selected' : '' ?>><?= $y['key'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    <?php if ($query->have_posts()): while ($query->have_posts()) : $query->the_post(); ?>
                        <?php edit_post_link(); ?>
                        <h3 class="content-title"><?php the_title(); ?></h3>
                        

        				    <?php the_content(); ?>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <p><?php _e( 'Sorry, no posts matched your criteria.', 'html5blank' ); ?></p>

                        <?php endif; ?>
        			</div>
                    <?php if ($parent_id && $children) { ?>
        			<div class="col-lg-3 col-md-4 page--content-right">
        				<?= jcci_right_menu($children); ?>
        			</div>
                    <?php } ?>
        		</div>
        	</div>
        </div>
    </div>

    <script>
        let G_CURRENT_REQUEST = '<?= jcci_get_current_url() ?>'
    </script>

<?php get_footer(); ?>
