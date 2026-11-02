<?php 
/**
 * [custom_clean_head description]
 * @return [type] [description]
 */
function custom_clean_head() {
    // remove_action('wp_head', 'wp_print_scripts');
    // remove_action('wp_head', 'wp_print_head_scripts', 9);
    // remove_action('wp_head', 'wp_enqueue_scripts', 1);

    // add_action('wp_footer', 'wp_print_scripts', 5);
    // add_action('wp_footer', 'wp_enqueue_scripts', 5);
    // add_action('wp_footer', 'wp_print_head_scripts', 5);
}
add_action( 'wp_enqueue_scripts', 'custom_clean_head' );

/**
 * Disable the emoji's
 * @return [type] [description]
 */
function fuji_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    // add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    // add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'fuji_disable_emojis' );

/**
 * Remove query string from static files
 * @param  [type] $src [description]
 * @return [type]      [description]
 */
function cleanup_query_string( $src ) {
    if( strpos( $src, '?ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'cleanup_query_string', 15, 1 );
add_filter( 'script_loader_src', 'cleanup_query_string', 15, 1 );

/**
 * [disable_embeds_code_init description]
 * @return [type] [description]
 */
function disable_embeds_code_init() {

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    // Turn off oEmbed auto discovery.
    add_filter( 'embed_oembed_discover', '__return_false' );

    // Don't filter oEmbed results.
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    // Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    // add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

    // Remove all embeds rewrite rules.
    add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

    // Remove filter of the oEmbed result before any HTTP requests are made.
    remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}
add_action( 'init', 'disable_embeds_code_init', 9999 );

function disable_embeds_tiny_mce_plugin($plugins) {
    return array_diff($plugins, array('wpembed'));
}

function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}


/**
 * [remove_jquery_migrate description]
 * @param  [type] $scripts [description]
 * @return [type]          [description]
 */
function remove_jquery_migrate($scripts) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];

        if ( $script->deps ) { // Check whether the script has any dependencies
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');

/**
 * [remove_wp_version description]
 * @return [type] [description]
 */
function remove_wp_version() {
    return '';
}
add_filter('the_generator', 'remove_wp_version');

/**
 * Pick out the version number from scripts and styles
 * @param  [type] $src [description]
 * @return [type]      [description]
 */
function remove_version_from_style_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
// add_filter( 'style_loader_src', 'remove_version_from_style_js');
// add_filter( 'script_loader_src', 'remove_version_from_style_js');

/**
 * Disable all feed on site
 * @return [type] [description]
 */
function disable_feed() {
    wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">Return Home</a>!' ) );
}
add_action('do_feed', 'disable_feed', 1);
add_action('do_feed_rdf', 'disable_feed', 1);
add_action('do_feed_rss', 'disable_feed', 1);
add_action('do_feed_rss2', 'disable_feed', 1);
add_action('do_feed_atom', 'disable_feed', 1);
add_action('do_feed_rss2_comments', 'disable_feed', 1);
add_action('do_feed_atom_comments', 'disable_feed', 1);

/**
 * [disable_self_pingback description]
 * @param  [type] &$links [description]
 * @return [type]         [description]
 */
function disable_self_pingback( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_pingback' );

function stop_heartbeat() {
    wp_deregister_script('heartbeat');
}
add_action( 'init', 'stop_heartbeat', 1 );

function disable_dashicon() {
    if (current_user_can( 'update_core' )) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'disable_dashicon' );

function disable_password_strength_meter() {
    wp_dequeue_script('user-profile');
    wp_dequeue_script('password-strength-meter');
    wp_deregister_script('user-profile');

    $suffix = SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_script( 'user-profile', "/wp-admin/js/user-profile$suffix.js", array( 'jquery', 'wp-util' ), false, 1 );
}
add_action('login_enqueue_scripts', 'disable_password_strength_meter');

/**
 * In case test site, if no favicon, will display blank favicon
 * @return [type] [description]
 */
function blank_favicon() {
    echo '<link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAYAAABPYyMiAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAAAF0lEQVRIx2NgGAWjYBSMglEwCkbBSAcACBAAAeaR9cIAAAAASUVORK5CYII=" rel="icon" type="image/x-icon" />';
}
// add_action('wp_head', 'blank_favicon');

// Disable JSON Rest API in WordPress
// Check: https://test.zodiaq.tokyo/wp-json/wp/v2/users
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

/**
 * Disable gutenberg style in Front
 * @return [type] [description]
 */
function remove_block_css() {
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );

/**
 * Adding DNS Prefetching
 * @return [type] [description]
 */
function ism_dns_prefetch() {
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">
        <link rel="dns-prefetch" href="//fonts.gstatic.com" />
        <link rel="dns-prefetch" href="//fonts.googleapis.com" />';
}
add_action('wp_head', 'ism_dns_prefetch', 0);


function fuji_custom_tag_query( $query ) {
    if(is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
     $query->set( 'post_type', array(
     'post', 'recruitment'
     ));
     return $query;
     }
    }
// add_filter( 'pre_get_posts', 'fuji_custom_tag_query' );


/**
 * Hide the +Add new category link in post and post new
 * @return [type] [description]
 */
function fuji_custom_admin_style() {
  echo '<style>
    #category-adder {display: none !important;}
  </style>';
}
// add_action('admin_head', 'fuji_custom_admin_style');

