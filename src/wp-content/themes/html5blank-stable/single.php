<?php 
$post_type = $post->post_type;
$taxonomy = 'category';
switch ($post_type) {
    case 'post-news':
        $taxonomy = 'news_category';
        break;
    case 'actions':
        $taxonomy = 'actions_category';
        break;
    case 'ecwd_organizer':
        $taxonomy = ''; // you can get related post here
        break;
    default:
        $taxonomy = 'category';
        break;
}

$post_id = $post->ID;
$post_parent = $post->post_parent;
if ( $post_parent ) {
    $post_id = $post_parent; 
}

$post_categories = jcci_get_primary_category($post_id, $taxonomy); 
$primary_category = $post_categories['primary_category'];
$gorup_cat_title = $primary_category->name;

$posts_same_cat = jcci_get_posts_by_term_id ($primary_category->term_id, $post_type, $taxonomy, ['post__not_in' => array($post_id)]);

$breadcrumb = array();
array_push($breadcrumb, ['url' => get_term_link($primary_category->term_id), 'text' => $gorup_cat_title]);
if ( $post_parent ) {
    $parent_link = esc_url( get_the_permalink( $post_parent ) );
    $breadcrumb[] = ['url' => $parent_link, 'text' => strip_tags(get_the_title( $post_parent ))];
}
array_push($breadcrumb, ['url' => '#!', 'text' => strip_tags($post->post_title)]);
?>
<?php get_header(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class('article single-actions'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h2 class="page--title"><?php echo $gorup_cat_title ? $gorup_cat_title : $post->post_title; ?></h2>
        </div>
        <div class="page--breadcrumb">
            <div class="container">
                <?php jcci_render_breadcrumb($breadcrumb); ?>
            </div>
        </div>
        <div class="page--content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 page--content-left">
                        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                            <?php edit_post_link(); ?>
                            <h1 class="post--title"><?php the_title() ?></h1>
                            <div class="post--meta">
                                <span class="date"><i class="zmdi zmdi-calendar"></i>&nbsp;<?= get_the_date('Y.m.d') ?></span>
                            </div>
                            <div class="mt-3 divider"></div>
                            <?php the_content(); ?>
                        <?php endwhile; endif; ?>
                        <?php if ($posts_same_cat): ?>
                        <div class="divider"></div>
                        <div class="post--related">
                            <h4><?= jcci_translate_text('同じカテゴリの記事一覧') ?></h4>
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($posts_same_cat as $k => $item): ?>
                                            <tr>
                                                <td>
                                                    <a href="<?= get_the_permalink($item->ID) ?>">
                                                        <?= $item->post_title ?> 
                                                        <?php 
                                                        $diff = jcci_date_diff(get_the_date("Y-m-d", $item), date('Y-m-d'));
                                                        if ( $diff <= 2 ) {
                                                            echo '<span class="post--new">// New</span>';
                                                        }
                                                        ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>