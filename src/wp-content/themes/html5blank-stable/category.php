<?php
$term = get_queried_object();
$main_title = $term->name;
if ($term->parent) {
    $parent_cat_name = get_the_category_by_ID($term->parent);
    $main_title = $parent_cat_name;
}

$children = get_terms( $term->taxonomy, array(
    'parent'     => $term->parent,
    'hide_empty' => false
) );

$taxonomy  = $term->taxonomy;
$term_id   = $term->term_id;
$post_type = 'post';

switch ($taxonomy) {
    case 'news_category':
        $post_type = 'post-news';
        break;
    case 'actions_category':
        $post_type = 'actions';
        break;
    
    default:
        $post_type = 'post';
        break;
}

// Get all years with published post
$years = jcci_get_posts_years($post_type);

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

if (isset($_GET['y'])) {
    $year = intval($_GET['y']);
    $args = array_merge($args, [
        'date_query' => array(
            'relation' => 'OR',
            array('year' => $year)
        ),]);
}

$query = new WP_Query( $args );
$max_query = $query->max_num_pages;

$breadcrumb = array();
array_push($breadcrumb, ['url' => '#!', 'text' => $parent_cat_name]);
array_push($breadcrumb, ['url' => '#!', 'text' => single_cat_title('', false)]);
?>


<?php get_header(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('article category fag-category'); ?>>
        <div class="page--header">
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
                        <h3><?php single_cat_title(); ?></h3>
                        <div class="mb-5 filter--year cus-select">
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

                        <div class="pagination">
                        <?php html5wp_pagination($max_query); ?>
                        </div>

                        <?php wp_reset_postdata(); ?>
                        <?php else: ?>
                            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if (0) { // don't show right menu if it's taxonomy be category ?>
                    <div class="col-lg-3 col-md-4 page--content-right">
                    <?php if ( $children ) :?>
                        <ul class="p-0 m-0 list-unstyled text-center right-menu">
                        <?php foreach( $children as $subcat ) :
                            $class_active = $term->term_id == $subcat->term_id ? 'active' : '';
                        ?>
                            <li class="<?= $class_active ?>">
                                <a href="<?= esc_url(get_term_link($subcat, $subcat->taxonomy)) ?>" title="<?= $subcat->name ?>">
                                    <?= $subcat->name ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
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
