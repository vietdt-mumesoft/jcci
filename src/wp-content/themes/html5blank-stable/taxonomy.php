<?php
$term = get_queried_object();
$main_title = $term->name;
$term_parent = null;
if ($term->parent) {
    $term_parent = get_term($term->parent, $term->taxonomy);
    $main_title = $term_parent->name ? $term_parent->name : '';
}

$args = array(
    'taxonomy'   => $term->taxonomy,
    'parent'     => $term->parent,
    'hide_empty' => false,
    'orderby'    => 'term_order',
    'order'      => 'ASC'
);
$children = get_terms( $args );

$taxonomy  = $term->taxonomy;
$term_id   = $term->term_id;
$post_type = 'post';

switch ($taxonomy) {
    case 'news_category':
        $post_type = 'post-news';
        unset($args['orderby']);
        unset($args['order']);
        $children = get_terms( $args );
        break;
    case 'actions_category':
        $post_type = 'actions';
        if (!$term->parent) {
            $args['parent'] = $term->term_id;
            $children = get_terms( $args );
        }
        break;
    case 'services_category':
        $post_type = 'services';
        break;
    
    default:
        $post_type = 'post';
        break;
}

// Get all years with published post
$years = jcci_get_posts_financial_years($post_type);

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$per_page = 10;
$args = [
    'post_type'      => $post_type,
    'posts_per_page' => $per_page,
    'paged'     => $paged,
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

// add condition posts with financial years
if (isset($_GET['y'])) {
    function filter_where( $where = '' ) {
        $year = intval($_GET['y']);
        $date_year = $year.'-04-01';
        $date_next_year = ($year+1).'-03-31';

        $where .= " AND DATE_FORMAT(post_date,'%Y-%m-%d') >= '".$date_year."'";
        $where .= " AND DATE_FORMAT(post_date,'%Y-%m-%d') <= '".$date_next_year."'";
        return $where;
    }
    add_filter( 'posts_where', 'filter_where' );
}

$query = new WP_Query( $args );
$max_query = $query->max_num_pages;
remove_filter( 'posts_where', 'filter_where' );

$breadcrumb = array();
if ($term_parent) {
    $breadcrumb[] = ['url' => esc_url( get_term_link( $term_parent ) ), 'text' => $term_parent->name];
}
$breadcrumb[] = ['url' => '#!', 'text' => single_cat_title('', false)];
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
                        <div class="mb-5 filter--year--financial cus-select">
                            <select name="select--year" class="no-appearance">
                                <option value=""><?= jcci_translate_text('全て') ?></option>
                                <?php foreach ($years as $y): 
                                    $selected_year = $y == $_GET['y'] ? 'selected' : '';
                                    ?>
                                    <option value="<?= $y ?>" <?= $selected_year ?>><?= $y ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <?php if ( $query->have_posts() ) : ?>
                            <?php if ($post_type == 'actions') { ?>

                            <ul class="list-item img-list">
                                <?php $default_thumb = get_template_directory_uri() . '/assets/img/thumb-default.jpg'; ?>
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <?php 
                                    $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'actions-thumb');
                                    $thumb_url = $thumb_url ? $thumb_url : $default_thumb; 
                                    ?>

                                    <li>
                                        <a href="<?php the_permalink() ?>" class="list--inner" title="<?php the_title(); ?>">
                                            <div class="list--img">
                                                <div class="list--img-thumb" style="background-image: url(<?php echo $thumb_url ?>);"></div>
                                            </div>
                                            <div class="list--text">
                                                <div class="list--meta">
                                                    <span><?= jcci_get_date( 'Y/m/d', get_the_ID() ) ?></span>
                                                </div>
                                                <div class="list--head"><?php the_title(); ?></div>
                                            </div>
                                        </a>
                                    </li>

                                <?php endwhile; ?>
                            </ul>

                            <?php } else { ?>

                                <div class="table-responsive-sm">
                                    <table class="table table-sm">
                                        <tbody>
                                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                            <tr>
                                                <td class="post--date"><?= get_the_date('Y.m.d') ?></td>
                                                <td>
                                                    <a class="hover-underline post--title" href="<?php the_permalink(); ?>" 
                                                        title="<?= $item->post_title ?>"><?php the_title(); ?></a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>

                            <?php } ?>

                        <div class="pagination">
                        <?php html5wp_pagination($max_query); ?>
                        </div>

                        <?php wp_reset_postdata(); ?>
                        <?php else: ?>
                            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-3 col-md-4 page--content-right">
                        <?php echo jcci_right_menu( $children ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let G_CURRENT_REQUEST = '<?= jcci_get_current_url() ?>'
    </script>

<?php get_footer(); ?>
