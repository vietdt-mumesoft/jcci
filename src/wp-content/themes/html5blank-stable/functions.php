<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */


/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/
//require only in admin!
if(is_admin()){ 
    require_once('lib/jcci-theme-settings-basic.php');
}

require_once __DIR__. '/functions-jcci.php';
require_once __DIR__. '/functions-jcci-up.php';
require_once __DIR__. '/functions-jcci-card.php';


// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    // add_image_size('large', 700, '', true); // Large Thumbnail
    // add_image_size('medium', 250, '', true); // Medium Thumbnail
    // add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('actions-thumb', 426, 260, true);
    add_image_size('organization-thumb', 331, 331, true);
    add_image_size('vbf-thumb', 517, 344, true);
    add_image_size('new-member-thumb', 475, 475, true);
    // add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        // Remove jquery default
        // wp_deregister_script('jquery');

        // wp_register_script('jquery-3.4.1', get_template_directory_uri() . '/assets/js/jquery-3.4.1.min.js');
        // wp_enqueue_script('jquery-3.4.1');
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (!is_admin()) {
        wp_register_script('materialize', get_template_directory_uri() . '/assets/js/materialize.js', array('jquery'), false, true);
        wp_enqueue_script('materialize');

        wp_register_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), false, true);
        wp_enqueue_script('bootstrap');

        wp_register_script('wow', get_template_directory_uri() . '/assets/js/wow.min.js', array('jquery'), false, true);
        wp_enqueue_script('wow');

        wp_register_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), false, true);
        wp_enqueue_script('owl-carousel');

        wp_register_script('jcci-main', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery'), false, true);
        wp_enqueue_script('jcci-main');
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    if (is_jcci_card_page()) {
        return;
    }

    wp_register_style('google-font', 'https://fonts.googleapis.com/css?family=Jomolhari&display=swap');
    wp_enqueue_style('google-font');

    wp_register_style('material-design-iconic-font', get_template_directory_uri() . '/assets/css/material-design-iconic-font.min.css');
    wp_enqueue_style('material-design-iconic-font');

    wp_register_style('animate', get_template_directory_uri() . '/assets/css/animate.min.css');
    wp_enqueue_style('animate');

    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');

    wp_register_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css');
    wp_enqueue_style('owl-carousel');

    wp_register_style('owl-theme', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css');
    wp_enqueue_style('owl-theme');

    if (is_front_page()) {
        wp_register_style('event-calendar', get_template_directory_uri() . '/assets/css/event-calendar.css');
        wp_enqueue_style('event-calendar');
    }

    wp_register_style('jcci-main', get_template_directory_uri() . '/assets/css/main.min.css');
    wp_enqueue_style('jcci-main');
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'footer-menu' => __('Footer Menu', 'html5blank'), // Sidebar Navigation
        //'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination($max_num_pages = 0)
{
    global $wp_query;
    $big = 999999999;
    $max_num_pages = $max_num_pages ? $max_num_pages : $wp_query->max_num_pages;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $max_num_pages,
        'prev_text' => '<i class="zmdi zmdi-arrow-left"></i>',
        'next_text' => '<i class="zmdi zmdi-arrow-right"></i>',
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/**
 * Transform a navigational menu to it's tree structure
 *
 * @uses  buildTree()
 * @uses  wp_get_nav_menu_items()
 *
 * @param  String     $menud_id 
 * @return Array|null $tree 
 */
function wpse_nav_menu_2_tree( $menu_id )
{
    $items = wp_get_nav_menu_items( $menu_id );
    return  $items ? buildTree( $items, 0 ) : null;
}

/**
 * Modification of "Build a tree from a flat array in PHP"
 *
 * Authors: @DSkinner, @ImmortalFirefly and @SteveEdson
 *
 * @link https://stackoverflow.com/a/28429487/2078474
 */
function buildTree( array &$elements, $parentId = 0 )
{
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parentId )
        {
            $children = buildTree( $elements, $element->ID );
            if ( $children )
                $element->wpse_children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}

function jcci_custom_menu( $theme_location ) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu_term = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu_term->term_id);
        $trees = buildTree($menu_items, 0);
        $menu_list  = '<ul class="navbar-nav">' ."\n";
        foreach ($trees as $m) {
            $children = $m->wpse_children;
            if (empty($children)) {
                $menu_list .= '<li class="nav-item">' . "\n";
                $menu_list .= '<a class="nav-link" href="'.$m->url.'">'. $m->title .'</a>' . "\n";
            } else {
                $menu_list .= '<li class="nav-item dropdown">' . "\n";
                $menu_list .= '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">'. $m->title .'</a>' . "\n";
                $menu_list .= '<div class="dropdown-menu">' . "\n";
                $menu_list .= '<div class="row">' . "\n";
                $menu_list .= '<div class="col-md-4 col-sm-12 dropdown-menu--left">' . "\n";
                $menu_list .= '<div class="pr-5">'. $m->title .'</div>' . "\n";
                $menu_list .= '</div>' . "\n";
                $menu_list .= '<div class="p-0 col-md-8 col-sm- 12 dropdown-menu--right">' . "\n";
                $menu_list .= '<div class="dropdown-menu--right-inner">' . "\n";
                $menu_list .= '<div class="row">' . "\n";
                $col = 6;
                if ( is_array($children) && count($children) == 4) {
                    $col = 12;
                }
                foreach ($children as $child) {
                    $grand_children = $child->wpse_children;
                    $menu_list .= '<div class="col-md-'.$col.'">' . "\n";
                    if ($grand_children) {
                        $menu_list .= '<a href="'.$child->url.'"><h4>'.$child->title.'</h4></a>' . "\n";
                        $menu_list .= '<ul class="row">' . "\n";
                        foreach ($grand_children as $grand) {
                            $menu_list .= '<li class="col-md-6"><a href="'.$grand->url.'">'.$grand->title.'</a></li>' . "\n";
                        }
                        $menu_list .= '</ul>' . "\n";
                    } else {
                        $menu_list .= '<ul>' . "\n";
                        $menu_list .= '<li><a href="'.$child->url.'">'.$child->title.'</a></li>' . "\n";
                        $menu_list .= '</ul>' . "\n";
                    }
                    $menu_list .= '</div>' . "\n"; // .col-md-
                }
                $menu_list .= '</div>' . "\n"; // .row
                $menu_list .= '</div>' . "\n"; // .dropdown-menu--right-inner
                $menu_list .= '</div>' . "\n"; // .dropdown-menu--right
                $menu_list .= '</div>' . "\n"; // .row
                $menu_list .= '</div>' . "\n"; //.dropdown-menu
            }
            $menu_list .= '</li>' . "\n";
        }
        $menu_list .= '</ul>' ."\n";
    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    
    echo $menu_list;
    // echo "<pre>" . var_export($trees, true) . "</pre>"; die;
}

function jcci_custom_footer_menu ($theme_location) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu_term = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu_term->term_id);

        $trees = buildTree($menu_items, 0);
        $active_class = 'active';
        
        $menu_list  = '<div class="row d-flex justify-content-center">' ."\n";
        foreach ($trees as $m) {
            $children = $m->wpse_children;

            $menu_list .= '<div class="col-md-2 mb-2">' . "\n";
            $menu_list .= '<h5><a href="'.$m->url.'" title="">'.$m->title.'</a></h5>' . "\n";
            if ($children) {
                $menu_list .= '<ul class="list-unstyled">' . "\n";
                foreach ($children as $child) {
                    $grand_children = $child->wpse_children;
                    $menu_list .= '<li><a href="'.$child->url.'">'.$child->title.'</a></li>' . "\n";
                }
                $menu_list .= '</ul>' . "\n"; // ul.list-unstyled
            }
            $menu_list .= '</div>' . "\n"; // .col-md-2
        }
        $menu_list .= '</div>' ."\n"; // .row .d-flex
    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    
    echo $menu_list;
}

/**
  * Get all in polylang configured languages
  * @return \PLL_Language[] list of languages
  */
 function jcci_getLanguages()
 {
     if (function_exists('pll_languages_list')) {
         $translations = pll_the_languages(array('raw'=>1));
         $current_lang_slug = pll_current_language();
         $current_language = $translations[$current_lang_slug];
         unset($translations[$current_lang_slug]);
         $current_lang_flag = get_template_directory_uri() . '/assets/img/icons/flag-'.$current_lang_slug.'.svg';
?>
        <div class="pll-switcher">
            <a href="#pll_switcher" class="d-inline-block pll-current">
                <img src="<?php echo $current_lang_flag; ?>" alt="<?php echo $current_language['locale'] ?>" width="24">
                <span style="margin-left:0.3em;"><?php echo $current_language['name'] ?></span>
                <i class="zmdi zmdi-caret-down ml-3 pll-drop-icon pll-drop-icon-down"></i>
                <i class="zmdi zmdi-caret-up ml-3 pll-drop-icon pll-drop-icon-up"></i>
            </a>
            <ul class="p-0 m-0 list-unstyled pll-sub-menu">
                <?php foreach ($translations as $key => $lang): ?>
                <li class="lang-item lang-item-ja ">
                    <a href="<?php echo $lang['url'] ?>" hreflang="<?php echo $lang['locale'] ?>" lang="<?php echo $lang['locale'] ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/flag-<?php echo $lang['slug'] ?>.svg" alt="<?php echo $lang['locale'] ?>" width="24">
                        <span style="margin-left:0.3em;"><?php echo $lang['name'] ?></span>
                    </a>
                </li>
                <?php endforeach ?>
            </ul>
        </div>

 <?php 
    }
 }

 function jcci_get_primary_category($post_id, $term='category', $return_all_categories=false) {
    $return = array();

    if (class_exists('WPSEO_Primary_Term')){
        // Show Primary category by Yoast if it is enabled & set
        $wpseo_primary_term = new WPSEO_Primary_Term( $term, $post_id );
        $primary_term = get_term($wpseo_primary_term->get_primary_term());

        if (!is_wp_error($primary_term)){
            $return['primary_category'] = $primary_term;
        }
    }

    if (empty($return['primary_category']) || $return_all_categories){
        $categories_list = get_the_terms($post_id, $term);

        if (empty($return['primary_category']) && !empty($categories_list)){
            $return['primary_category'] = $categories_list[0];  //get the first category
        }
        if ($return_all_categories){
            $return['all_categories'] = array();

            if (!empty($categories_list)){
                foreach($categories_list as &$category){
                    $return['all_categories'][] = $category->term_id;
                }
            }
        }
    }

    return $return;
}

function jcci_get_posts_faq () {
    $args = array(
        'post_type' => 'album',
        'post_status' => 'publish',
    );
    $postslist = get_posts( $args );
}

function jcci_debug($data = null, $die = false) {
    echo "<pre>" . var_export($data, true) . "</pre>"; 
    if ($die) {
        die(__FILE__);
    }
}

function jcci_get_total_users () {
    global $wpdb;
    $total_member = $wpdb->get_results( "SELECT MAX(meta_value) AS meta_value FROM {$wpdb->postmeta} WHERE meta_key='total_member' GROUP BY meta_key;" );
    
    if (!$total_member) {
        return 0;
    }

    return $total_member[0]->meta_value;
}

/**
 * Using for pickup in front page
 * @return [array] Return all pages which was set is sticky
 */
function jcci_get_sticky_posts () {
    $sticky = get_option( 'sticky_posts' );
    $args = array(
        'posts_per_page'      => 5,
        'post__in'            => $sticky,
        'ignore_sticky_posts' => 1,
        'order'          => 'DESC',
        'orderby'        => 'date',
        'post_status'    => 'publish'
        );
    if ( empty($sticky) ) return array();

    $posts = get_posts( $args );

    return $posts;
}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu

// Add Custom Post Type
add_action('init', 'jcci_create_post_news');
add_action('init', 'jcci_create_news_taxonomies', 5 );
add_action('init', 'jcci_create_post_faq');
add_action('init', 'jcci_create_faq_taxonomies', 0 );
add_action('init', 'jcci_create_post_actions');
add_action('init', 'jcci_create_actions_taxonomies', 5 );
add_action('init', 'jcci_create_post_messages');
add_action('init', 'jcci_create_messages_taxonomies', 5 );
add_action('init', 'jcci_create_post_services');
add_action('init', 'jcci_create_services_taxonomies', 5 );
add_action('init', 'jcci_create_post_organization');
add_action('init', 'jcci_create_organization_taxonomies', 5 );
add_action('init', 'jcci_create_post_member');
add_action('init', 'jcci_create_member_taxonomies', 5 );

add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10); // Disable REST API link tag
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10); // Disable oEmbed Discovery Links

remove_action('template_redirect', 'rest_output_link_header', 11, 0); // Disable REST API link in HTTP headers

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.
add_shortcode('wpb_childpages', 'jcci_list_child_pages'); // Place [wpb_childpages] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

function jcci_create_post_news()
{
    $theme_name = 'html5blank';
    $labels = array(
        'name'               => _x( 'News', 'Post Type General Name', $theme_name ),
        'singular_name'      => _x( 'News', 'Post Type Singular Name', $theme_name ),
        'menu_name'          => __( 'JCCI News', $theme_name ),
        'parent_item_colon'  => __( 'Parent Item:', $theme_name ),
        'all_items'          => __( 'All Items', $theme_name ),
        'view_item'          => __( 'View Item', $theme_name ),
        'view'               => __( 'View Custom Post', $theme_name),
        'add_new_item'       => __( 'Add New Item', $theme_name ),
        'add_new'            => __( 'Add New', $theme_name ),
        'edit'               => __( 'Edit', $theme_name),
        'edit_item'          => __( 'Edit Item', $theme_name ),
        'new_item'           => __( 'New Custom Post', $theme_name),
        'update_item'        => __( 'Update Item', $theme_name ),
        'search_items'       => __( 'Search Item', $theme_name ),
        'not_found'          => __( 'Not found', $theme_name ),
        'not_found_in_trash' => __( 'Not found in Trash', $theme_name ),
    );
    $args = array(
        'label'               => __( 'News', $theme_name ),
        'description'         => __( 'Daily news', $theme_name ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        // 'taxonomies'          => array( 'category' ), // Add Category and Post Tags support
        'hierarchical'        => true, // Allows your posts to behave like Hierarchy Pages
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-smiley',
        'can_export'          => true, // Allows export in Tools > Export
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // register_taxonomy_for_object_type('category', 'post-news'); // Register Taxonomies for Category
    // register_taxonomy_for_object_type('post_tag', 'post-news');
    register_post_type('post-news', $args);
}

function jcci_create_news_taxonomies() {
    $theme_name = 'html5blank';

    $labels = array(
        'name'              => _x( 'News Categories', 'taxonomy general name', $theme_name ),
        'singular_name'     => _x( 'News Category', 'taxonomy singular name', $theme_name ),
        'search_items'      => __( 'Search News Categories', $theme_name ),
        'all_items'         => __( 'All News Categories', $theme_name ),
        'parent_item'       => __( 'Parent Category', $theme_name ),
        'parent_item_colon' => __( 'Parent Category:', $theme_name ),
        'edit_item'         => __( 'Edit Category', $theme_name ),
        'update_item'       => __( 'Update Category', $theme_name ),
        'add_new_item'      => __( 'Add New Category', $theme_name ),
        'new_item_name'     => __( 'New Category Name', $theme_name ),
        'menu_name'         => __( 'Categories', $theme_name ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true,
    );

    register_taxonomy( 'news_category', array( 'post-news' ), $args );
}

function jcci_create_post_faq()
{
    $theme_name = 'html5blank';
    $labels = array(
        'name'               => _x( 'FAQ', 'Post Type General Name', $theme_name ),
        'singular_name'      => _x( 'FAQ', 'Post Type Singular Name', $theme_name ),
        'menu_name'          => __( 'JCCI FAQ', $theme_name ),
        'parent_item_colon'  => __( 'Parent Item:', $theme_name ),
        'all_items'          => __( 'All Items', $theme_name ),
        'view_item'          => __( 'View Item', $theme_name ),
        'view'               => __( 'View Custom Post', $theme_name),
        'add_new_item'       => __( 'Add New Item', $theme_name ),
        'add_new'            => __( 'Add New', $theme_name ),
        'edit'               => __( 'Edit', $theme_name),
        'edit_item'          => __( 'Edit Item', $theme_name ),
        'new_item'           => __( 'New Custom Post', $theme_name),
        'update_item'        => __( 'Update Item', $theme_name ),
        'search_items'       => __( 'Search Item', $theme_name ),
        'not_found'          => __( 'Not found', $theme_name ),
        'not_found_in_trash' => __( 'Not found in Trash', $theme_name ),
    );
    $args = array(
        'label'               => __( 'FAQ', $theme_name ),
        'description'         => __( 'Frequently answers and questions', $theme_name ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        // 'taxonomies'          => array( 'category' ), // Add Category and Post Tags support
        'hierarchical'        => true, // Allows your posts to behave like Hierarchy Pages
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-testimonial',
        'can_export'          => true, // Allows export in Tools > Export
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    //register_taxonomy_for_object_type('category', 'post-faq'); // Register Taxonomies for Category
    // register_taxonomy_for_object_type('post_tag', 'post-faq');

    // Register Custom Post Type
    register_post_type('post-faq', $args);
}

function jcci_create_faq_taxonomies() {
    $labels = array(
        'name'              => _x( 'Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'categories' ),
    );

    register_taxonomy( 'faq_category', array( 'post-faq' ), $args );
}

function jcci_create_post_actions()
{
    $theme_name = 'html5blank';
    $labels = array(
        'name'               => _x( 'Actions', 'Post Type General Name', $theme_name ),
        'singular_name'      => _x( 'Actions', 'Post Type Singular Name', $theme_name ),
        'menu_name'          => __( 'JCCI Actions', $theme_name ),
        'parent_item_colon'  => __( 'Parent Item:', $theme_name ),
        'all_items'          => __( 'All Items', $theme_name ),
        'view_item'          => __( 'View Item', $theme_name ),
        'view'               => __( 'View Custom Post', $theme_name),
        'add_new_item'       => __( 'Add New Item', $theme_name ),
        'add_new'            => __( 'Add New', $theme_name ),
        'edit'               => __( 'Edit', $theme_name),
        'edit_item'          => __( 'Edit Item', $theme_name ),
        'new_item'           => __( 'New Custom Post', $theme_name),
        'update_item'        => __( 'Update Item', $theme_name ),
        'search_items'       => __( 'Search Item', $theme_name ),
        'not_found'          => __( 'Not found', $theme_name ),
        'not_found_in_trash' => __( 'Not found in Trash', $theme_name ),
    );
    $args = array(
        'label'               => __( 'Actions', $theme_name ),
        'description'         => __( 'JCCI actions', $theme_name ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        // 'taxonomies'          => array( 'category' ), // Add Category and Post Tags support
        'hierarchical'        => true, // Allows your posts to behave like Hierarchy Pages
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-buddicons-tracking',
        'can_export'          => true, // Allows export in Tools > Export
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    // Register Custom Post Type
    register_post_type('actions', $args);
}
function jcci_create_actions_taxonomies() {
    $labels = array(
        'name'              => _x( 'Actions Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Actions Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Actions  Categories' ),
        'all_items'         => __( 'All Actions Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true,
    );

    register_taxonomy( 'actions_category', array( 'actions' ), $args );
}

function jcci_create_post_messages()
{
    $theme_name = 'html5blank';
    $labels = array(
        'name'               => _x( 'Messages', 'Post Type General Name', $theme_name ),
        'singular_name'      => _x( 'Messages', 'Post Type Singular Name', $theme_name ),
        'menu_name'          => __( 'JCCI Messages', $theme_name ),
        'parent_item_colon'  => __( 'Parent Item:', $theme_name ),
        'all_items'          => __( 'All Items', $theme_name ),
        'view_item'          => __( 'View Item', $theme_name ),
        'view'               => __( 'View Custom Post', $theme_name),
        'add_new_item'       => __( 'Add New Item', $theme_name ),
        'add_new'            => __( 'Add New', $theme_name ),
        'edit'               => __( 'Edit', $theme_name),
        'edit_item'          => __( 'Edit Item', $theme_name ),
        'new_item'           => __( 'New Custom Post', $theme_name),
        'update_item'        => __( 'Update Item', $theme_name ),
        'search_items'       => __( 'Search Item', $theme_name ),
        'not_found'          => __( 'Not found', $theme_name ),
        'not_found_in_trash' => __( 'Not found in Trash', $theme_name ),
    );
    $args = array(
        'label'               => __( 'Messages', $theme_name ),
        'description'         => __( 'JCCI messages', $theme_name ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        // 'taxonomies'          => array( 'category' ), // Add Category and Post Tags support
        'hierarchical'        => true, // Allows your posts to behave like Hierarchy Pages
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-welcome-write-blog',
        'can_export'          => true, // Allows export in Tools > Export
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    // Register Custom Post Type
    register_post_type('messages', $args);
}
function jcci_create_messages_taxonomies() {
    $labels = array(
        'name'              => _x( 'Messages Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Messages Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Messages  Categories' ),
        'all_items'         => __( 'All Messages Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true,
    );

    register_taxonomy( 'messages_category', array( 'messages' ), $args );
}

function jcci_create_post_member()
{
    $theme_name = 'html5blank';
    $labels = array(
        'name'               => _x( 'New Member', 'Post Type General Name', $theme_name ),
        'singular_name'      => _x( 'New Member', 'Post Type Singular Name', $theme_name ),
        'menu_name'          => __( 'JCCI New Member', $theme_name ),
        'parent_item_colon'  => __( 'Parent Item:', $theme_name ),
        'all_items'          => __( 'All Items', $theme_name ),
        'view_item'          => __( 'View Item', $theme_name ),
        'view'               => __( 'View Custom Post', $theme_name),
        'add_new_item'       => __( 'Add New Item', $theme_name ),
        'add_new'            => __( 'Add New', $theme_name ),
        'edit'               => __( 'Edit', $theme_name),
        'edit_item'          => __( 'Edit Item', $theme_name ),
        'new_item'           => __( 'New Custom Post', $theme_name),
        'update_item'        => __( 'Update Item', $theme_name ),
        'search_items'       => __( 'Search Item', $theme_name ),
        'not_found'          => __( 'Not found', $theme_name ),
        'not_found_in_trash' => __( 'Not found in Trash', $theme_name ),
    );
    $args = array(
        'label'               => __( 'New Member', $theme_name ),
        'description'         => __( 'JCCI new member', $theme_name ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        // 'taxonomies'          => array( 'category' ), // Add Category and Post Tags support
        'hierarchical'        => true, // Allows your posts to behave like Hierarchy Pages
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-groups',
        'can_export'          => true, // Allows export in Tools > Export
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    // Register Custom Post Type
    register_post_type('new-member', $args);
}
function jcci_create_member_taxonomies() {
    $labels = array(
        'name'              => _x( 'New Member Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'New Member Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true,
    );

    register_taxonomy( 'new_member_category', array( 'new-member' ), $args );
}

function jcci_create_post_services()
{
    $theme_name = 'html5blank';
    $labels = array(
        'name'               => _x( 'Services', 'Post Type General Name', $theme_name ),
        'singular_name'      => _x( 'Services', 'Post Type Singular Name', $theme_name ),
        'menu_name'          => __( 'JCCI Services', $theme_name ),
        'parent_item_colon'  => __( 'Parent Item:', $theme_name ),
        'all_items'          => __( 'All Items', $theme_name ),
        'view_item'          => __( 'View Item', $theme_name ),
        'view'               => __( 'View Custom Post', $theme_name),
        'add_new_item'       => __( 'Add New Item', $theme_name ),
        'add_new'            => __( 'Add New', $theme_name ),
        'edit'               => __( 'Edit', $theme_name),
        'edit_item'          => __( 'Edit Item', $theme_name ),
        'new_item'           => __( 'New Custom Post', $theme_name),
        'update_item'        => __( 'Update Item', $theme_name ),
        'search_items'       => __( 'Search Item', $theme_name ),
        'not_found'          => __( 'Not found', $theme_name ),
        'not_found_in_trash' => __( 'Not found in Trash', $theme_name ),
    );
    $args = array(
        'label'               => __( 'Services', $theme_name ),
        'description'         => __( 'JCCI services for member', $theme_name ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        // 'taxonomies'          => array( 'category' ), // Add Category and Post Tags support
        'hierarchical'        => true, // Allows your posts to behave like Hierarchy Pages
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-generic',
        'can_export'          => true, // Allows export in Tools > Export
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    // Register Custom Post Type
    register_post_type('services', $args);
}
function jcci_create_services_taxonomies() {
    $labels = array(
        'name'              => _x( 'Services Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Services Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Services  Categories' ),
        'all_items'         => __( 'All Services Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true,
    );

    register_taxonomy( 'services_category', array( 'services' ), $args );
}

function jcci_create_post_organization()
{
    $theme_name = 'html5blank';
    $labels = array(
        'name'               => _x( 'Organization', 'Post Type General Name', $theme_name ),
        'singular_name'      => _x( 'Organization', 'Post Type Singular Name', $theme_name ),
        'menu_name'          => __( 'JCCI Organization', $theme_name ),
        'parent_item_colon'  => __( 'Parent Item:', $theme_name ),
        'all_items'          => __( 'All Items', $theme_name ),
        'view_item'          => __( 'View Item', $theme_name ),
        'view'               => __( 'View Custom Post', $theme_name),
        'add_new_item'       => __( 'Add New Item', $theme_name ),
        'add_new'            => __( 'Add New', $theme_name ),
        'edit'               => __( 'Edit', $theme_name),
        'edit_item'          => __( 'Edit Item', $theme_name ),
        'new_item'           => __( 'New Custom Post', $theme_name),
        'update_item'        => __( 'Update Item', $theme_name ),
        'search_items'       => __( 'Search Item', $theme_name ),
        'not_found'          => __( 'Not found', $theme_name ),
        'not_found_in_trash' => __( 'Not found in Trash', $theme_name ),
    );
    $args = array(
        'label'               => __( 'Organization', $theme_name ),
        'description'         => __( 'JCCI services for member', $theme_name ),
        'labels'              => $labels,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'page-attributes'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        // 'taxonomies'          => array( 'category' ), // Add Category and Post Tags support
        'hierarchical'        => true, // Allows your posts to behave like Hierarchy Pages
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-building',
        'can_export'          => true, // Allows export in Tools > Export
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    // Register Custom Post Type
    register_post_type('organization', $args);
}
function jcci_create_organization_taxonomies() {
    $labels = array(
        'name'              => _x( 'Organization Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Organization Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true,
    );

    register_taxonomy( 'organization_category', array( 'organization' ), $args );
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

function jcci_list_child_pages() { 
    global $post;

    if ( is_page() && $post->post_parent ) {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
    } else {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
    }

    if ( $childpages ) {
        $string = '<ul class="p-0 m-0 list-unstyled right-menu">' . $childpages . '</ul>';
    }

    echo $string;
}

?>
