<?php
/**
 * JCCI Card functions
 */

// constants
define('JCCI_CARD_VERSION', '1.0.0');
define('JCCI_CARD_PATH', get_template_directory() . '/jcci-card');
define('JCCI_CARD_URL', get_template_directory_uri() . '/jcci-card');
define('JCCI_CARD_LOGIN_MAX_ATTEMPTS', 5);

// Register and enqueue scripts & styles for JCCI Card
function jcci_card_enqueue_scripts() {

    // Only load on the specific template
    if (!is_jcci_card_page()) {
        return;
    }

    // Register and enqueue styles

    // 1. <link rel="stylesheet" id="liathia-login-css" href="http://jcci-card.local/wp-content/themes/liathia-jbav/inc/extensions/liathia-admin-theme/assets/css/login.css?ver=6.4.5" type="text/css" media="all">
    wp_register_style('liathia-login-css', JCCI_CARD_URL . '/assets/css/login.css', array(), JCCI_CARD_VERSION);

    // 2. <link rel="stylesheet" id="font-awesome-four-css" href="http://jcci-card.local/wp-content/themes/liathia-jbav/assets/css/font-awesome.min.css?ver=4.7.0" type="text/css" media="all">
    wp_register_style('font-awesome-four-css', JCCI_CARD_URL . '/assets/css/font-awesome.min.css', array(), JCCI_CARD_VERSION);
    
    // 3. <link rel="stylesheet" id="liathia-icons-css" href="http://jcci-card.local/wp-content/themes/liathia-jbav/assets/css/fl-icons.css?ver=3.3" type="text/css" media="all">
    wp_register_style('liathia-icons-css', JCCI_CARD_URL . '/assets/css/fl-icons.css', array(), JCCI_CARD_VERSION);

    // 4. <link rel="stylesheet" id="fancybox-css" href="http://jcci-card.local/wp-content/themes/liathia-jbav/inc/extensions/easy-fancybox/fancybox/jquery.fancybox.min.css?ver=1.3.17" type="text/css" media="screen">
    wp_register_style('fancybox-css', JCCI_CARD_URL . '/assets/css/jquery.fancybox.min.css', array(), JCCI_CARD_VERSION);

    // 5. <link rel="stylesheet" id="liathia-main-css" href="http://jcci-card.local/wp-content/themes/liathia-jbav/assets/css/liathia.css?ver=1.0.0" type="text/css" media="all">
    wp_register_style('liathia-main-css', JCCI_CARD_URL . '/assets/css/liathia.css', array(), JCCI_CARD_VERSION);

    // 6. <link rel="stylesheet" id="liathia-style-css" href="http://jcci-card.local/wp-content/themes/liathia-jbav/style.css?ver=1.0.0" type="text/css" media="all">
    wp_register_style('liathia-style-css', JCCI_CARD_URL . '/assets/css/style.css', array(), JCCI_CARD_VERSION);

    // 7. <script type="text/javascript" src="http://jcci-card.local/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
    wp_register_script('jquery-core-js', JCCI_CARD_URL . '/assets/js/jquery.min.js', array(), JCCI_CARD_VERSION);

    // 8. <script type="text/javascript" src="http://jcci-card.local/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>
    wp_register_script('jquery-migrate-js', JCCI_CARD_URL . '/assets/js/jquery-migrate.min.js', array(), JCCI_CARD_VERSION);

    // 9. <script type="text/javascript" src="http://jcci-card.local/wp-content/themes/liathia-jbav/inc/extensions/liathia-admin-theme/assets/js/modernizr.js?ver=6.4.5" id="liathia-modernizr-js"></script>
    wp_register_script('liathia-modernizr-js', JCCI_CARD_URL . '/assets/js/modernizr.js', array(), JCCI_CARD_VERSION);

    // 10. <script type="text/javascript" src="http://jcci-card.local/wp-content/themes/liathia-jbav/inc/extensions/easy-fancybox/fancybox/jquery.fancybox.min.js?ver=1.3.17" id="jquery-fancybox-js"></script>
    wp_register_script('jquery-fancybox-js', JCCI_CARD_URL . '/assets/js/jquery.fancybox.min.js', array(), JCCI_CARD_VERSION);

    // 11. <script type="text/javascript" src="http://jcci-card.local/wp-content/themes/liathia-jbav/inc/extensions/easy-fancybox/js/jquery.easing.min.js?ver=1.4.1" id="jquery-easing-js"></script>
    wp_register_script('jquery-easing-js', JCCI_CARD_URL . '/assets/js/jquery.easing.min.js', array(), JCCI_CARD_VERSION);

    // 12. <script type="text/javascript" src="http://jcci-card.local/wp-content/themes/liathia-jbav/inc/extensions/easy-fancybox/js/jquery.mousewheel.min.js?ver=3.1.13" id="jquery-mousewheel-js"></script>
    wp_register_script('jquery-mousewheel-js', JCCI_CARD_URL . '/assets/js/jquery.mousewheel.min.js', array(), JCCI_CARD_VERSION);

    // 13. <script type="text/javascript" src="http://jcci-card.local/wp-includes/js/hoverIntent.min.js?ver=1.10.2" id="hoverIntent-js"></script>
    wp_register_script('hoverIntent-js', JCCI_CARD_URL . '/assets/js/hoverIntent.min.js', array(), JCCI_CARD_VERSION);

    // 14. <script type="text/javascript" src="http://jcci-card.local/wp-content/themes/liathia-jbav/assets/js/liathia.js?ver=1.0.0" id="liathia-js-js"></script>
    wp_register_script('liathia-js-js', JCCI_CARD_URL . '/assets/js/liathia.js', array(), JCCI_CARD_VERSION);

    // 15. Custom CSS
    wp_register_style('jcci-card-css', JCCI_CARD_URL . '/assets/css/custom.css', array(), JCCI_CARD_VERSION);

    wp_enqueue_style('liathia-login-css');
    wp_enqueue_style('font-awesome-four-css');
    wp_enqueue_style('liathia-icons-css');
    wp_enqueue_style('fancybox-css');
    wp_enqueue_style('liathia-main-css');
    wp_enqueue_style('liathia-style-css');
    wp_enqueue_style('jcci-card-css');

    wp_enqueue_script('jquery-core-js');
    wp_enqueue_script('jquery-migrate-js');
    wp_enqueue_script('liathia-modernizr-js');
    wp_enqueue_script('jquery-fancybox-js');
    wp_enqueue_script('jquery-easing-js');
    wp_enqueue_script('jquery-mousewheel-js');
    wp_enqueue_script('hoverIntent-js');
    wp_enqueue_script('liathia-js-js');
}
add_action('wp_enqueue_scripts', 'jcci_card_enqueue_scripts');


/******************
 * CTP register
 ******************/

// Register Restaurant Custom Post Type
function register_restaurant_post_type() {
    $labels = array(
        'name'                  => _x('Restaurants', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Restaurant', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Restaurants', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Restaurant', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Restaurant', 'textdomain'),
        'new_item'              => __('New Restaurant', 'textdomain'),
        'edit_item'             => __('Edit Restaurant', 'textdomain'),
        'view_item'             => __('View Restaurant', 'textdomain'),
        'all_items'             => __('All Restaurants', 'textdomain'),
        'search_items'          => __('Search Restaurants', 'textdomain'),
        'parent_item_colon'     => __('Parent Restaurants:', 'textdomain'),
        'not_found'             => __('No restaurants found.', 'textdomain'),
        'not_found_in_trash'    => __('No restaurants found in Trash.', 'textdomain'),
        'featured_image'        => __('Restaurant Image', 'textdomain'),
        'set_featured_image'    => __('Set restaurant image', 'textdomain'),
        'remove_featured_image' => __('Remove restaurant image', 'textdomain'),
        'use_featured_image'    => __('Use as restaurant image', 'textdomain'),
        'archives'              => __('Restaurant archives', 'textdomain'),
        'insert_into_item'      => __('Insert into restaurant', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this restaurant', 'textdomain'),
        'filter_items_list'     => __('Filter restaurants list', 'textdomain'),
        'items_list_navigation' => __('Restaurants list navigation', 'textdomain'),
        'items_list'            => __('Restaurants list', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'restaurants'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-store',
        'supports'           => array('title', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('restaurants', $args);
}
add_action('init', 'register_restaurant_post_type');

// Register Cuisine Hierarchical Taxonomy
function register_cuisine_taxonomy() {
    $labels = array(
        'name'                       => _x('Cuisines', 'taxonomy general name', 'textdomain'),
        'singular_name'              => _x('Cuisine', 'taxonomy singular name', 'textdomain'),
        'search_items'               => __('Search Cuisines', 'textdomain'),
        'popular_items'              => __('Popular Cuisines', 'textdomain'),
        'all_items'                  => __('All Cuisines', 'textdomain'),
        'parent_item'                => __('Parent Cuisine', 'textdomain'),
        'parent_item_colon'          => __('Parent Cuisine:', 'textdomain'),
        'edit_item'                  => __('Edit Cuisine', 'textdomain'),
        'update_item'                => __('Update Cuisine', 'textdomain'),
        'add_new_item'               => __('Add New Cuisine', 'textdomain'),
        'new_item_name'              => __('New Cuisine Name', 'textdomain'),
        'separate_items_with_commas' => __('Separate cuisines with commas', 'textdomain'),
        'add_or_remove_items'        => __('Add or remove cuisines', 'textdomain'),
        'choose_from_most_used'      => __('Choose from the most used cuisines', 'textdomain'),
        'not_found'                  => __('No cuisines found.', 'textdomain'),
        'menu_name'                  => __('Cuisines', 'textdomain'),
        'back_to_items'              => __('← Back to cuisines', 'textdomain'),
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'cuisine'),
        'show_in_rest'      => true,
    );

    register_taxonomy('cuisine', 'restaurants', $args);
}
add_action('init', 'register_cuisine_taxonomy');

// Register Hotel Apart Custom Post Type
function register_hotel_apart_post_type() {
    $labels = array(
        'name'                  => _x('Hotel / Apart', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Hotel / Apart', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Hotel / Apart', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Hotel / Apart', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Hotel / Apart', 'textdomain'),
        'new_item'              => __('New Hotel / Apart', 'textdomain'),
        'edit_item'             => __('Edit Hotel / Apart', 'textdomain'),
        'view_item'             => __('View Hotel / Apart', 'textdomain'),
        'all_items'             => __('All Hotel / Apart', 'textdomain'),
        'search_items'          => __('Search Hotel / Apart', 'textdomain'),
        'parent_item_colon'     => __('Parent Hotel / Apart:', 'textdomain'),
        'not_found'             => __('No hotel / apart found.', 'textdomain'),
        'not_found_in_trash'    => __('No hotel / apart found in Trash.', 'textdomain'),
        'featured_image'        => __('Hotel & Apart Image', 'textdomain'),
        'set_featured_image'    => __('Set hotel & apart image', 'textdomain'),
        'remove_featured_image' => __('Remove hotel / apart image', 'textdomain'),
        'use_featured_image'    => __('Use as hotel / apart image', 'textdomain'),
        'archives'              => __('Hotel / Apart archives', 'textdomain'),
        'insert_into_item'      => __('Insert into hotel / apart', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this hotel / apart', 'textdomain'),
        'filter_items_list'     => __('Filter hotel / apart list', 'textdomain'),
        'items_list_navigation' => __('Hotel / Apart list navigation', 'textdomain'),
        'items_list'            => __('Hotel / Apart list', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'hotel-apart'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array('title', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('hotel-apart', $args);
}
add_action('init', 'register_hotel_apart_post_type');

// Register Place Hierarchical Taxonomy
function register_place_taxonomy() {
    $labels = array(
        'name'                       => _x('Places', 'taxonomy general name', 'textdomain'),
        'singular_name'              => _x('Place', 'taxonomy singular name', 'textdomain'),
        'search_items'               => __('Search Places', 'textdomain'),
        'popular_items'              => __('Popular Places', 'textdomain'),
        'all_items'                  => __('All Places', 'textdomain'),
        'parent_item'                => __('Parent Place', 'textdomain'),
        'parent_item_colon'          => __('Parent Place:', 'textdomain'),
        'edit_item'                  => __('Edit Place', 'textdomain'),
        'update_item'                => __('Update Place', 'textdomain'),
        'add_new_item'               => __('Add New Place', 'textdomain'),
        'new_item_name'              => __('New Place Name', 'textdomain'),
        'separate_items_with_commas' => __('Separate places with commas', 'textdomain'),
        'add_or_remove_items'        => __('Add or remove places', 'textdomain'),
        'choose_from_most_used'      => __('Choose from the most used places', 'textdomain'),
        'not_found'                  => __('No places found.', 'textdomain'),
        'menu_name'                  => __('Places', 'textdomain'),
        'back_to_items'              => __('← Back to places', 'textdomain'),
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'place'),
        'show_in_rest'      => true,
    );

    register_taxonomy('place', 'hotel-apart', $args);
}
add_action('init', 'register_place_taxonomy');

// Register Shop/Golf/Other Custom Post Type
function register_shop_golf_other_post_type() {
    $labels = array(
        'name'                  => _x('Shop / Golf / Other', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Shop / Golf / Other', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Shop / Golf / Other', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Shop / Golf / Other', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Shop / Golf / Other', 'textdomain'),
        'new_item'              => __('New Shop / Golf / Other', 'textdomain'),
        'edit_item'             => __('Edit Shop / Golf / Other', 'textdomain'),
        'view_item'             => __('View Shop / Golf / Other', 'textdomain'),
        'all_items'             => __('All Shop / Golf / Other', 'textdomain'),
        'search_items'          => __('Search Shop / Golf / Other', 'textdomain'),
        'parent_item_colon'     => __('Parent Shop / Golf / Other:', 'textdomain'),
        'not_found'             => __('No shop / golf / other found.', 'textdomain'),
        'not_found_in_trash'    => __('No shop / golf / other found in Trash.', 'textdomain'),
        'featured_image'        => __('Shop / Golf / Other Image', 'textdomain'),
        'set_featured_image'    => __('Set shop / golf / other image', 'textdomain'),
        'remove_featured_image' => __('Remove shop / golf / other image', 'textdomain'),
        'use_featured_image'    => __('Use as shop / golf / other image', 'textdomain'),
        'archives'              => __('Shop / Golf / Other archives', 'textdomain'),
        'insert_into_item'      => __('Insert into shop / golf / other', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this shop / golf / other', 'textdomain'),
        'filter_items_list'     => __('Filter shop / golf / other list', 'textdomain'),
        'items_list_navigation' => __('Shop / Golf / Other list navigation', 'textdomain'),
        'items_list'            => __('Shop / Golf / Other list', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'shop-golf-other'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-cart',
        'supports'           => array('title', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('shop-golf-other', $args);
}
add_action('init', 'register_shop_golf_other_post_type');

// Register Store Hierarchical Taxonomy
function register_store_taxonomy() {
    $labels = array(
        'name'                       => _x('Stores', 'taxonomy general name', 'textdomain'),
        'singular_name'              => _x('Store', 'taxonomy singular name', 'textdomain'),
        'search_items'               => __('Search Stores', 'textdomain'),
        'popular_items'              => __('Popular Stores', 'textdomain'),
        'all_items'                  => __('All Stores', 'textdomain'),
        'parent_item'                => __('Parent Store', 'textdomain'),
        'parent_item_colon'          => __('Parent Store:', 'textdomain'),
        'edit_item'                  => __('Edit Store', 'textdomain'),
        'update_item'                => __('Update Store', 'textdomain'),
        'add_new_item'               => __('Add New Store', 'textdomain'),
        'new_item_name'              => __('New Store Name', 'textdomain'),
        'separate_items_with_commas' => __('Separate stores with commas', 'textdomain'),
        'add_or_remove_items'        => __('Add or remove stores', 'textdomain'),
        'choose_from_most_used'      => __('Choose from the most used stores', 'textdomain'),
        'not_found'                  => __('No stores found.', 'textdomain'),
        'menu_name'                  => __('Stores', 'textdomain'),
        'back_to_items'              => __('← Back to stores', 'textdomain'),
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'store'),
        'show_in_rest'      => true,
    );

    register_taxonomy('store', 'shop-golf-other', $args);
}
add_action('init', 'register_store_taxonomy');





/******************
 * Store Repeater Metabox
 ******************/

// Add Restaurant Pairs Metabox
function store_repeater_metabox() {
    add_meta_box(
        'store_repeater_metabox',           
        'Sale off text',                   
        'store_repeater_metabox_callback',  
        'restaurants',                        
        'normal',                             
        'default'                             
    );

    add_meta_box(
        'store_repeater_metabox',           
        'Sale off text',                   
        'store_repeater_metabox_callback',  
        'hotel-apart',                        
        'normal',                             
        'default'                             
    );

    add_meta_box(
        'store_repeater_metabox',           
        'Sale off text',                   
        'store_repeater_metabox_callback',  
        'shop-golf-other',                        
        'normal',                             
        'default'                             
    );
}
add_action('add_meta_boxes', 'store_repeater_metabox');

// Metabox HTML callback
function store_repeater_metabox_callback($post) {
    wp_nonce_field('store_repeater_metabox', 'store_repeater_nonce');
    
    // Get existing pairs if any
    $pairs = get_post_meta($post->ID, '_store_repeater', true);
    if (!is_array($pairs)) {
        $pairs = array();
    }
    
    ?>
    <style>
        .flex-row {
            display: flex;
            align-items: center;
        }
        .flex-grow {
            flex-grow: 1;
        }
    </style>
    <div id="store-repeater-container">
        <?php 
        // Display existing pairs
        if (!empty($pairs)) {
            foreach ($pairs as $index => $pair) {
                ?>
                <div class="pair-row" data-index="<?php echo esc_attr($index); ?>">
                    <div style="margin-bottom: 16px;">
                        <div class="flex-row" style="margin-bottom: 8px;">
                            <label style="margin-right: 8px;" for="pr1_<?php echo esc_attr($index); ?>">PR1:</label>
                            <input class="flex-grow" type="text" name="store_repeater[<?php echo esc_attr($index); ?>][pr1]" 
                                id="pr1_<?php echo esc_attr($index); ?>" 
                                value="<?php echo esc_attr($pair['pr1']); ?>">
                        </div>
                        
                        <div class="flex-row" style="margin-bottom: 8px;">
                            <label style="margin-right: 8px;" for="pr2_<?php echo esc_attr($index); ?>">PR2:</label>
                            <input class="flex-grow" type="text" name="store_repeater[<?php echo esc_attr($index); ?>][pr2]" 
                                id="pr2_<?php echo esc_attr($index); ?>" 
                                value="<?php echo esc_attr($pair['pr2']); ?>">
                        </div>

                        <div class="flex-row" style="margin-bottom: 8px;">
                            <label style="margin-right: 8px;" for="pr3_<?php echo esc_attr($index); ?>">PR3:</label>
                            <input class="flex-grow" type="text" name="store_repeater[<?php echo esc_attr($index); ?>][pr3]" 
                                id="pr3_<?php echo esc_attr($index); ?>" 
                                value="<?php echo esc_attr($pair['pr3']); ?>">
                        </div>
                        
                        <button type="button" class="button remove-pair">Remove</button>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div id="pairs-template" style="display: none;">
            <div class="pair-row" data-index="{{index}}">
                <div style="margin-bottom: 16px;">
                    <div class="flex-row" style="margin-bottom: 8px;">
                        <label style="margin-right: 8px;" for="pr1_{{index}}">PR1:</label>
                        <input class="flex-grow" type="text" name="store_repeater[{{index}}][pr1]" 
                            id="pr1_{{index}}" value="" >
                    </div>

                    <div class="flex-row" style="margin-bottom: 8px;">
                        <label style="margin-right: 8px;" for="pr2_{{index}}">PR2:</label>
                        <input class="flex-grow" type="text" name="store_repeater[{{index}}][pr2]" 
                            id="pr2_{{index}}" value="" >
                    </div>

                    <div class="flex-row" style="margin-bottom: 8px;">
                        <label style="margin-right: 8px;" for="pr3_{{index}}">PR3:</label>
                        <input class="flex-grow" type="text" name="store_repeater[{{index}}][pr3]" 
                            id="pr3_{{index}}" value="" >
                    </div>

                    <button type="button" class="button remove-pair">Remove</button>
                </div>
            </div>
        </div>
        <p>
            <button type="button" class="button" id="add-pair">Add More</button>
        </p>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Counter for new pairs - ensure we start with a safe index
        var pairIndex = <?php echo !empty($pairs) ? max(array_keys($pairs) + [0]) + 1 : 0; ?>;
        
        // Add new pair
        $('#add-pair').on('click', function() {
            var template = $('#pairs-template').html();
            var newRow = template.replace(/{{index}}/g, pairIndex);
            $('#store-repeater-container').append(newRow);
            pairIndex++;
        });
        
        // Remove pair
        $('#store-repeater-container').on('click', '.remove-pair', function() {
            $(this).closest('.pair-row').remove();
        });
    });
    </script>
    <?php
}

// Save metabox data
function save_store_repeater_metabox($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['store_repeater_nonce']) || 
        !wp_verify_nonce($_POST['store_repeater_nonce'], 'store_repeater_metabox')) {
        return;
    }
    
    // Check user permissions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    
    if (isset($_POST['store_repeater']) && is_array($_POST['store_repeater'])) {
        $pairs = array_values(array_filter($_POST['store_repeater'], function($pair) {
            // Only keep pairs where at least one field has a value
            return !empty($pair['pr1']) || !empty($pair['pr2']) || !empty($pair['pr3']);
        }));
        update_post_meta($post_id, '_store_repeater', $pairs);
    } else {
        delete_post_meta($post_id, '_store_repeater');
    }
}

add_action('save_post_restaurants', 'save_store_repeater_metabox');
add_action('save_post_hotel-apart', 'save_store_repeater_metabox');
add_action('save_post_shop-golf-other', 'save_store_repeater_metabox');


// Enqueue jQuery for the admin area
function store_repeater_admin_scripts($hook) {
    global $post;
    
    if ($hook == 'post.php' || $hook == 'post-new.php') {
        if (isset($post) && 
                (   $post->post_type == 'restaurants' || 
                    $post->post_type == 'hotel-apart' || 
                    $post->post_type == 'shop-golf-other'   
                )
            ) 
        {
            wp_enqueue_script('jquery');
        }
    }
}
add_action('admin_enqueue_scripts', 'store_repeater_admin_scripts');



/*********************************
 * Custom query parameters
 *********************************/

/**
 * Register custom query parameters with WordPress
 */
function register_custom_query_vars($vars) {
    $vars[] = 'is_card';
    return $vars;
}
add_filter('query_vars', 'register_custom_query_vars');



/*********************************
 * Search card logic
 *********************************/

// Filter search results for card searches
/**
 * Modify search results after they've been retrieved
 * This function will run a secondary query to get posts from all languages
 * and merge them with the original results
 */
function jcci_card_modify_search_results($posts, $query) {
    // Only run on main search query for card searches
    if (!is_admin() && 
        $query->is_main_query() && 
        $query->is_search() && 
        $query->get('is_card') == '1') {
        
        // Get the search term
        $search_term = get_search_query();
        // break search term into array by <br> or new line character or space
        $search_term_array = explode('<br>', $search_term);
        $search_term_array = explode('\n', $search_term);
        $search_term_array = array_map('trim', $search_term_array); // trim each element
        $search_term_array = array_filter($search_term_array); // remove empty values

        //$args = array(
        //    '_meta_or_title' => $search_term_array,
        //    'post_type' => array('restaurants', 'hotel-apart', 'shop-golf-other'),
        //    'post_status' => 'publish',
        //    //'posts_per_page' => -1,         // Get all matching posts
        //    'suppress_filters' => true,     // Important: prevents Polylang from filtering
        //    'lang' => '',                   // Empty string means all languages
        //    'meta_query' => $meta_query,
        //    'paged' => $query->get('paged'),
        //    'orderby' => 'meta_value',
        //    'order' => 'ASC',
        //    'posts_per_page' => $query->get('posts_per_page')
        //);
        
        // Run the new query
        $posts_raw = jcci_card_query_posts_raw($search_term_array);

        // Replace the original posts with our new results
        $posts = $posts_raw['posts'];

        // Update the found_posts count in the main query
        $query->found_posts = $posts_raw['total_posts'];
        $query->max_num_pages = $posts_raw['total_pages'];
    }
    
    return $posts;
}
add_filter('the_posts', 'jcci_card_modify_search_results', 10, 2);

// Query posts raw
function jcci_card_query_posts_raw($search_term_array) {
    global $wpdb;

    // Get current page and posts per page
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $posts_per_page = get_query_var('posts_per_page') ? get_query_var('posts_per_page') : get_option('posts_per_page');
    $offset = ($paged - 1) * $posts_per_page;

    // Prepare search terms for LIKE conditions
    $search_conditions = array();
    $search_values = array();

    if (!empty($search_term_array)) {
        foreach ($search_term_array as $term) {
            if (empty(trim($term))) continue;
            
            // Create a condition group for each term that searches in both title and meta
            $search_conditions[] = "(pm.meta_value LIKE %s OR p.post_title LIKE %s)";
            $search_values[] = '%' . $wpdb->esc_like(trim($term)) . '%';
            $search_values[] = '%' . $wpdb->esc_like(trim($term)) . '%';
        }
    }
    
    // If no valid search terms, use a default condition
    if (empty($search_conditions)) {
        $search_conditions[] = "(pm.meta_value LIKE %s OR p.post_title LIKE %s)";
        $search_values[] = '%%'; // Match anything in meta
        $search_values[] = '%%'; // Match anything in title
    }

    // Build the query
    $sql = "
        SELECT DISTINCT p.ID 
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type IN ('restaurants', 'hotel-apart', 'shop-golf-other')
        AND p.post_status = 'publish'
        AND pm.meta_key = 'name_en'
        AND (" . implode(' OR ', $search_conditions) . ")
        ORDER BY pm.meta_value ASC
        LIMIT %d OFFSET %d
    ";

    // Add pagination parameters
    $search_values[] = $posts_per_page;
    $search_values[] = $offset;

    // Prepare and execute the query
    $prepared_sql = $wpdb->prepare($sql, $search_values);
    $results = $wpdb->get_results($prepared_sql);

    // Check for database errors
    if ($wpdb->last_error) {
        error_log('Database error in jcci_card_query_posts_raw: ' . $wpdb->last_error);
        return array(
            'posts' => array(),
            'total_posts' => 0,
            'total_pages' => 0
        );
    }

    // Get total for pagination
    $count_sql = "
        SELECT COUNT(DISTINCT p.ID)
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type IN ('restaurants', 'hotel-apart', 'shop-golf-other')
        AND p.post_status = 'publish'
        AND pm.meta_key = 'name_en'
        AND (" . implode(' OR ', $search_conditions) . ")
    ";

    // Remove pagination parameters (last 2 elements) from search values
    $count_search_values = array_slice($search_values, 0, -2);
    
    // Get total post count using prepared statement
    $total_posts = $wpdb->get_var($wpdb->prepare($count_sql, $count_search_values));

    // Check for database errors
    if ($wpdb->last_error) {
        error_log('Database error in jcci_card_query_posts_raw count query: ' . $wpdb->last_error);
        $total_posts = 0;
    }

    // Convert to proper WP_Post objects if needed
    $wp_posts = array();
    if (!empty($results)) {
        // Extract all post IDs
        $post_ids = wp_list_pluck($results, 'ID');
        
        // Use a single query to get all posts at once
        $posts_query = new WP_Query(array(
            'post__in' => $post_ids,
            'post_type' => array('restaurants', 'hotel-apart', 'shop-golf-other'),
            'posts_per_page' => -1,
            'orderby' => 'post__in', // Preserve the original order
            'no_found_rows' => true, // Skip counting for better performance
        ));
        
        if ($posts_query->have_posts()) {
            $wp_posts = $posts_query->posts;
        }
    }

    $total_pages = ceil($total_posts / $posts_per_page);

    return array(
        'posts' => $wp_posts,
        'total_posts' => $total_posts,
        'total_pages' => $total_pages
    );
}




/*********************************
 * Query
 *********************************/

// Custom query for Restaurant, Hotel/Apart, Shop/Golf/Other
function jcci_card_custom_query($query) {
    
    if (!is_admin() && (is_archive() || is_tax())) {
        $apply_sorting = false;
        
        // Check for taxonomy queries
        if (isset($query->tax_query->queries) && !empty($query->tax_query->queries)) {
            foreach ($query->tax_query->queries as $tax_query) {
                if (isset($tax_query['taxonomy']) && 
                    in_array($tax_query['taxonomy'], ['cuisine', 'place', 'store'])) {
                    $apply_sorting = true;
                    break;
                }
            }
        }
        
        // Check for post type archive queries
        $post_type = $query->get('post_type');
        if ($post_type && (
            (is_string($post_type) && in_array($post_type, ['restaurants', 'hotel-apart', 'shop-golf-other']))
        )) {
            $apply_sorting = true;
        }
        
        // Apply sorting if needed
        if ($apply_sorting) {
            $query->set('meta_key', 'name_en');
            $query->set('orderby', 'meta_value');
            $query->set('order', 'ASC');
        }
    }
}
add_action('pre_get_posts', 'jcci_card_custom_query');




/******************
 * Menu location
 ******************/

// Register card main menu
function register_card_main_menu() {
    register_nav_menu('card-main-menu', 'Card Main Menu');
}
add_action('init', 'register_card_main_menu');

// Add active class to current menu item
function special_nav_class ($classes, $item) {
  if (in_array('current-menu-item', $classes) ){
    $classes[] = 'active ';
  }
  return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);


/******************
 * Helper functions
 ******************/

function jcci_card_get_post_color() {
    // Default color
    $color = 'blue';
    
    if (is_archive() || is_tax()) {
        // For post type archives
        if (is_post_type_archive('restaurants')) {
            $color = 'blue';
        } else if (is_post_type_archive('hotel-apart')) {
            $color = 'brown';
        } else if (is_post_type_archive('shop-golf-other')) {
            $color = 'green';
        } 
        // For taxonomy pages
        else if (is_tax()) {
            $term = get_queried_object();
            if ($term && isset($term->taxonomy)) {
                if ($term->taxonomy == 'cuisine') {
                    $color = 'blue'; 
                } else if ($term->taxonomy == 'place') {
                    $color = 'brown';
                } else if ($term->taxonomy == 'store') {
                    $color = 'green';
                }
            }
        }
    } else {
        // For others
        global $post;
        $post_type = $post->post_type;
        
        if ($post_type == 'restaurants') {
            $color = 'blue';
        } else if ($post_type == 'hotel-apart') {
            $color = 'brown';
        } else if ($post_type == 'shop-golf-other') {
            $color = 'green';
        }
    }
    
    return $color;
}

// Condition check for Card page
function is_jcci_card_page() {
    $is_card_page = is_page_template('page-card.php');
    $is_taxonomy_page = is_tax('cuisine') || is_tax('place') || is_tax('store');
    $is_archive_page = is_post_type_archive('restaurants') || 
                      is_post_type_archive('hotel-apart') || 
                      is_post_type_archive('shop-golf-other');
    // check if is_search and have is_card parameter = '1'
    $is_card_search = false;
    if (is_search() && isset($_GET['is_card']) && $_GET['is_card'] == '1') {
        $is_card_search = true;
    }

    return $is_card_page || $is_taxonomy_page || $is_archive_page || $is_card_search;
}

/**
 * Get translation of a string in a specific language
 * 
 * @param string $string The string to translate
 * @param string $language The language code (e.g., 'en', 'ja')
 * @return string The translated string or the original if no translation exists
 */
function jcci_card_get_translation($string, $language = 'en') {
    if (function_exists('pll_translate_string')) {
        return pll_translate_string($string, $language);
    }
    return $string;
}

/**
 * Check if the file extension is an image
 * 
 * @param array $file The file array return by ACF
 * @return bool True if the file extension is an image, false otherwise
 */

function jcci_card_is_image_extension($file) {
    return $file['type'] === "image";
}



if (function_exists('pll_register_string')) {
    /*------------------------------------*\
        Polylang Translation
    \*------------------------------------*/

    function jcci_card_translation() {
        pll_register_string('Restaurant', 'Restaurant', 'jcci-card');
        pll_register_string('Hotel / Apart', 'Hotel / Apart', 'jcci-card');
        pll_register_string('Shop / Golf / Other', 'Shop / Golf / Other', 'jcci-card');
        pll_register_string('Cuisine', 'Cuisine', 'jcci-card');
        pll_register_string('Place', 'Place', 'jcci-card');
        pll_register_string('Store', 'Store', 'jcci-card');
    }
    add_action('init', 'jcci_card_translation');
}


/*------------------------------------*\
    Prevent Brute Force Login
\*------------------------------------*/

add_action('wp_login_failed', function($username) {
    $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient($transient_name) ?: 0;

    if ($attempts++ >= JCCI_CARD_LOGIN_MAX_ATTEMPTS) {
        set_transient($transient_name, $attempts, HOUR_IN_SECONDS);
        wp_die('Too many login attempts. Please try again later.');
    }

    set_transient($transient_name, $attempts, 15 * MINUTE_IN_SECONDS);
});

// Block login attempts after too many failures
add_action('login_init', function () {
    if (current_user_can('manage_options')) {
        return;
    }

    $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient($transient_name) ?: 0;

    if ($attempts >= JCCI_CARD_LOGIN_MAX_ATTEMPTS) {
        wp_die('Too many login attempts. Please try again later.', 'Login Blocked', ['response' => 403]);
    }
});

// Add protection for REST API authentication
add_filter('rest_authentication_errors', function($errors) {
    if (current_user_can('manage_options')) {
        return $errors;
    }
    
    $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient($transient_name) ?: 0;
    
    if ($attempts >= JCCI_CARD_LOGIN_MAX_ATTEMPTS) {
        return new WP_Error(
            'too_many_attempts',
            'Too many login attempts. Please try again later.',
            ['status' => 403]
        );
    }
    
    return $errors;
}, 10);

// Add protection for XML-RPC authentication
add_filter('xmlrpc_login_error', function($error) {
    $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient($transient_name) ?: 0;
    $attempts++;
    
    if ($attempts >= JCCI_CARD_LOGIN_MAX_ATTEMPTS) {
        set_transient($transient_name, $attempts, HOUR_IN_SECONDS);
    } else {
        set_transient($transient_name, $attempts, 15 * MINUTE_IN_SECONDS);
    }
    
    return $error;
});

// Track successful logins to reset the counter
add_action('wp_login', function($user_login, $user) {
    $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
    delete_transient($transient_name);
}, 10, 2);

// Add protection for WooCommerce login if applicable
add_action('woocommerce_login_failed', function() {
    $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient($transient_name) ?: 0;
    $attempts++;
    
    if ($attempts >= JCCI_CARD_LOGIN_MAX_ATTEMPTS) {
        set_transient($transient_name, $attempts, HOUR_IN_SECONDS);
    } else {
        set_transient($transient_name, $attempts, 15 * MINUTE_IN_SECONDS);
    }
});

// Improve the existing wp_login_failed handler to be more robust
add_action('wp_login_failed', function($username) {
    $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient($transient_name) ?: 0;
    $attempts++; // Increment first
    
    if ($attempts >= JCCI_CARD_LOGIN_MAX_ATTEMPTS) {
        set_transient($transient_name, $attempts, HOUR_IN_SECONDS);
        wp_die('Too many login attempts. Please try again later.', 'Login Blocked', ['response' => 403]);
    } else {
        set_transient($transient_name, $attempts, 15 * MINUTE_IN_SECONDS);
    }
}, 10);

// Add protection for custom login forms by hooking into authenticate filter
add_filter('authenticate', function($user, $username, $password) {
    if (!empty($username) && !empty($password)) {
        $transient_name = 'login_attempt_' . $_SERVER['REMOTE_ADDR'];
        $attempts = get_transient($transient_name) ?: 0;
        
        if ($attempts >= JCCI_CARD_LOGIN_MAX_ATTEMPTS) {
            return new WP_Error(
                'too_many_attempts',
                'Too many login attempts. Please try again later.'
            );
        }
    }
    
    return $user;
}, 30, 3); // Priority 30 to run after WordPress authentication
