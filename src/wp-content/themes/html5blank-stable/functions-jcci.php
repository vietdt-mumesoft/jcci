<?php

add_action('profile_update', 'jcci_trigger_profile_update', 10, 1);
/**
 * Create .htpasswd file in uploads/download directory while updating user password
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function jcci_trigger_profile_update( $userId ) {
    if (empty($userId) || empty($_POST['pass1'])) return;
    // field user_login
    $userLoginAllows = ['jcci', 'fuji_test']; // array user_login can generate .htpasswd
    $userLogin = get_user_by('id', $userId)->user_login;
    // check user_login can generate htpasswd
    if(!in_array($userLogin, $userLoginAllows)) return;
    // Print line to be added to .htpasswd file: username + [:] + encrypt password
    $content = $userLogin . ':' . crypt_apr1_md5($_POST['pass1']);
    // overide or create new file
    $upload_dir = wp_upload_dir();
    $upload_dir = trailingslashit($upload_dir['basedir']);
    $dir = $upload_dir . '/downloads'; // Fixed folder downloads
    $pathFile = $dir.'/.htpasswd';
    if( is_dir($dir) === false ) mkdir($dir, 0777, true);
    // if not exist return the first
    if(!is_file($pathFile)){     
        return file_put_contents($pathFile, $content);
    }
    //get each line from file
    if ($file = fopen($pathFile, "r")) {
        while(!feof($file)) {
            $contentFiles[] = fgets($file);
        }
        fclose($file);
    }
    $isExisted = false;
    foreach($contentFiles as $line){
        $userLoginOld = explode(':', $line)[0];
        if(!trim($line)) continue;
        if($userLoginOld == $userLogin){
            $contentFileNew[] = $content;
            $isExisted = true;
        }else{
            $contentFileNew[] = str_replace("\n", '', $line);
        }     
    }
    if(!$isExisted){
        $contentFileNew[] = $content;
    }
    $file = fOpen($pathFile, "w+");
    foreach($contentFileNew ?? [$content] as $ind => $line){
        if(($ind + 1) < count($contentFileNew)) $line .= "\n";
        fwrite($file, $line);
    }
    fclose($file);
}

/**
 * APR1-MD5 encryption method (windows compatible)
 * Generate encrypted password for .htpasswd
 * @param  [type] $plainpasswd [description]
 * @return [type]              [description]
 */
function crypt_apr1_md5( $plainpasswd )
{
    $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
    $len = strlen($plainpasswd);
    $text = $plainpasswd.'$apr1$'.$salt;
    $bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
    for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
    for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd[0]; }
    $bin = pack("H32", md5($text));
    for($i = 0; $i < 1000; $i++)
    {
        $new = ($i & 1) ? $plainpasswd : $bin;
        if ($i % 3) $new .= $salt;
        if ($i % 7) $new .= $plainpasswd;
        $new .= ($i & 1) ? $bin : $plainpasswd;
        $bin = pack("H32", md5($new));
    }
    for ($i = 0; $i < 5; $i++)
    {
        $k = $i + 6;
        $j = $i + 12;
        if ($j == 16) $j = 5;
        $tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
    }
    $tmp = chr(0).chr(0).$bin[11].$tmp;
    $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
    "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
 
    return "$"."apr1"."$".$salt."$".$tmp;
}

/**
 * Filter the upload size limit for administrators.
 *
 * @param string $size Upload size limit (in bytes).
 * @return int (maybe) Filtered size limit.
 */
function filter_site_upload_size_limit( $size ) {

    if ( current_user_can( 'manage_options' ) ) {
        // 15MB
        $size = 15 * 1024 * 1024;
    }
    return $size;
}
// add_filter( 'upload_size_limit', 'filter_site_upload_size_limit', 20 );

function jcci_date_diff($beginDate, $endDate){
    $datetime1 = new DateTime($beginDate);
    $datetime2 = new DateTime($endDate);
    $interval = $datetime1->diff($datetime2);

    return $interval->format('%d');
}

/**
 * [get posts which was displayed on front page]
 * @return WP_Post[]|int[] Array of post objects or post IDs.
 */
function jcci_get_main_service_member() {
    $args = array(
        'post_type' => 'services',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
           array(
               'key' => 'in_front_page',
               'value' => true,
               'compare' => '=',
           )
       ),
        'orderby' => 'date',
        'order' => 'ASC'
    );

    return get_posts($args);
}

/**
 * [jcci_get_date description]
 * @param  string $d    [format to display]
 * @param  [type] $post [description]
 * @return [type]       [description]
 */
function jcci_get_date( $d = 'Y/m/d', $post = null ) {
    if ( ! $post ) {
        return false;
    }

    if (function_exists('pll_current_language')) {
        if (pll_current_language() == 'ja') {
            return get_the_date( 'Y年m月d日', $post );
        } else {
            return get_the_date( $d, $post );
        }
    } else {
        return get_the_date( $d, $post );
    }
}

/**
 * Collects our theme options
 *
 * @return array
 */
function jcci_get_global_options() {
    $jcci_option = array();
    $jcci_option  = get_option('jcci_options');

    return $jcci_option;
}
// Global variable. Don't effect in some certain templates such as header.php, sidebar.php and footer.php
$jcci_option = jcci_get_global_options();

function jcci_right_menu( $list = [] ) {

    if (!$list) {
        return '';
    }

    $is_taxonomy = false;
    global $post;
    $term = get_queried_object();

    $id = $post->ID;
    if ($term && $term->term_id) {
        $id = $term->term_id;
        $is_taxonomy = true;
    }

    $html = '<ul class="p-0 list-unstyled right-menu">';
    foreach ($list as $item) {
        $link = $is_taxonomy ? esc_url(get_term_link($item, $item->taxonomy)) : esc_url( get_the_permalink( $item->ID ) );
        $title = $is_taxonomy ? $item->name : $item->post_title;
        $class_active = (( $is_taxonomy ? $item->term_id : $item->ID ) == $id ) ? 'active' : '';

        $html .= '<li><a class="' . $class_active . '" href="' . $link . '">' . $title . '</a></li>';
    }
    $html .= '</ul>';

    return $html;
}

function jcci_right_menu_organization( $list = [] ) {

    if (!$list) {
        return '';
    }

    $is_taxonomy = false;
    global $post;
    $term = get_queried_object();

    $id = $post->ID;
    if ($term && $term->term_id) {
        $id = $term->term_id;
        $is_taxonomy = true;
    }
    $menus = [];
    foreach ($list as $item) {
        $link = $is_taxonomy ? esc_url(get_term_link($item, $item->taxonomy)) : esc_url( get_the_permalink( $item->ID ) );
        $title = $is_taxonomy ? $item->name : $item->post_title;
        $class_active = (( $is_taxonomy ? $item->term_id : $item->ID ) == $id ) ? 'active' : '';
        $menus[$item->menu_order] = [
            'active' => $class_active,
            'link' => $link,
            'title' => $title,
        ];
    }

    ksort($menus);
    $html = '<ul class="p-0 list-unstyled right-menu">';
    foreach ($menus as $value) {
        $html .= '<li><a class="' . $value['active'] . '" href="' . $value['link'] . '">' . $value['title'] . '</a></li>';
    }

    $html .= '</ul>';

    return $html;
}

function jcci_get_main_visual_background() {
    global $post;

    $img_url = get_field('main_visual_background', $post->ID);

    if ($img_url) {
        return $img_url;
    }

    $jcci_option = jcci_get_global_options();
    $post_type = $post->post_type;
    switch ($post_type) {
        case 'post':
            $img_url = isset($jcci_option['jcci_bg_header_post_url_input'])
                ? $jcci_option['jcci_bg_header_post_url_input']
                : get_template_directory_uri() . '/assets/img/bg-sub-post.jpg';
            break;
        case 'post-news':
            $img_url = isset($jcci_option['jcci_bg_header_news_url_input'])
                ? $jcci_option['jcci_bg_header_news_url_input']
                : get_template_directory_uri() . '/assets/img/bg-sub-news.jpg';
            break;
        case 'post-faq':
            $img_url = isset($jcci_option['jcci_bg_header_faq_url_input'])
                ? $jcci_option['jcci_bg_header_faq_url_input']
                : get_template_directory_uri() . '/assets/img/bg-faq.jpg';
            break;
        case 'services':
            $img_url = isset($jcci_option['jcci_bg_header_services_url_input'])
                ? $jcci_option['jcci_bg_header_services_url_input']
                : get_template_directory_uri() . '/assets/img/bg-sub-services.jpg';
            break;
        case 'actions':
            $img_url = isset($jcci_option['jcci_bg_header_action_url_input'])
                ? $jcci_option['jcci_bg_header_action_url_input']
                : get_template_directory_uri() . '/assets/img/bg-sub-actions.jpg';
            break;
        default:
            $img_url = get_template_directory_uri() . '/assets/img/bg-header.jpg';
            break;
    }

    return $img_url;
}

/**
 * Return all tag which match a XML/HTML Tag
 * @param  [string] $tag [the tag you’d like to match]
 * @param  [xml|html] $xml [the variable containing the XML or HTML]
 * @return [array]
 */
function jcci_get_tag( $tag, $xml ) {
  $tag = preg_quote($tag);
  preg_match_all('{<'.$tag.'[^>]*>(.*?)</'.$tag.'>}',
                   $xml,
                   $matches,
                   PREG_PATTERN_ORDER);
  if ($matches && $matches[0]) {
      return $matches[0];
  }
  return [];
}

/**
 * Add custom css to login page
 * @return [type] [description]
 */
function custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/assets/css/custom-login-style.css" />';
}
add_action('login_head', 'custom_login');

/**
 * Change the default logo url to any url
 * @return [type] [description]
 */
function custom_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_login_logo_url' );

/**
 * Change the title of logo url
 * @return [type] [description]
 */
function custom_login_logo_url_title() {
    return 'Default Site Title';
}
add_filter( 'login_headertext', 'custom_login_logo_url_title' );

/**
 * Change error message
 * @return [type] [description]
 */
function custom_login_error_message() {
    return 'Please enter valid login credentials.';
}
add_filter('login_errors', 'custom_login_error_message');

/**
 * Remove the login form shakes when the user submits the wrong login credentials.
 * @return [type] [description]
 */
function custom_login_head() {
    remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'custom_login_head');

/**
 * redirect all to the homepage except administrator as follows
 * @param  [type] $redirect_to [description]
 * @param  [type] $request     [description]
 * @param  [type] $user        [description]
 * @return [type]              [description]
 */
function custom_login_redirect( $redirect_to, $request, $user ) {
    global $user;

    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array( "administrator", $user->roles ) ) {
            return $redirect_to;
        } else {
            if (is_admin()) {
                return home_url();
            } else {
                return $redirect_to;
            }
        }
    } else {
        return $redirect_to;
    }
}
add_filter("login_redirect", "custom_login_redirect", 10, 3);

/**
 * Remember Me box is checked by default
 * @return [type] [description]
 */
function default_rememberme_checked() {
    echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
function register_g_current_language(){
    echo "<script>var G_CURRENT_LANGUAGE = '<?php echo pll_current_language() ?>'</script>";
}
//add_action( 'init', 'default_checked_remember_me' );
add_filter( 'login_footer', 'default_rememberme_checked' );
add_filter( 'login_footer', 'register_g_current_language' );

/**
 * Require login with current url redirect
 * @return [type] [description]
 */
function jcci_force_login() {
    // Exceptions for AJAX, Cron, or WP-CLI requests
    if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
        return;
    }

    // Redirect unauthorized visitors
    if ( ! is_user_logged_in() ) {
        // Get visited URL
        $url  = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
        $url .= '://' . $_SERVER['HTTP_HOST'];
        // port is prepopulated here sometimes
        if ( strpos( $_SERVER['HTTP_HOST'], ':' ) === FALSE ) {
            $url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
        }
        $url .= $_SERVER['REQUEST_URI'];

        /**
         * Bypass filters.
         *
         * @since 3.0.0 The `$whitelist` filter was added.
         * @since 4.0.0 The `$bypass` filter was added.
         * @since 5.2.0 The `$url` parameter was added.
         */
        $bypass = apply_filters( 'v_forcelogin_bypass', false, $url );
        $whitelist = apply_filters( 'v_forcelogin_whitelist', array() );

        if ( preg_replace( '/\?.*/', '', $url ) !== preg_replace( '/\?.*/', '', wp_login_url() ) && ! $bypass && ! in_array( $url, $whitelist ) ) {
            // Determine redirect URL
            $redirect_url = apply_filters( 'v_forcelogin_redirect', $url );
            // Set the headers to prevent caching
            nocache_headers();
            // Redirect
            wp_safe_redirect( wp_login_url( $redirect_url ), 302 ); exit;
        }
    }
}

/**
 * display link file download by year, using shortcode: [jcci_board_meeting folder='rijikaishiryou' year='2009']
 * @param  [type] $atts [description]
 * @return [type]       [description]
 */
function jcci_board_meeting_shortcode($atts) {
    global $wpdb;
    $a = shortcode_atts( array(
        'folder' => '', //rijikaishiryou
        'year' => '' // 2019
    ), $atts );

    $folder = $a['folder'];
    $year = $a['year'];
    $html = '';

    if (empty($folder) || empty($year)) {
        return $html;
    }

    $result = array();
    $sql = $wpdb->prepare( "
        SELECT tbl1.ID, tbl1.post_title, tbl1.post_mime_type, tbl1.post_date, tbl2.fid, tbl3.`name` FROM {$wpdb->posts} tbl1 
        LEFT JOIN wp_realmedialibrary_posts tbl2 ON tbl1.ID=tbl2.attachment 
        LEFT JOIN wp_realmedialibrary tbl3 ON tbl2.fid=tbl3.id
        WHERE tbl1.post_type='attachment' 
            AND tbl3.name LIKE '%s'
            AND tbl3.parent = (SELECT id FROM wp_realmedialibrary WHERE name LIKE '%s')
        ORDER BY tbl1.post_date DESC;
    ", 
    $year, $folder );
    $result = $wpdb->get_results( $sql );

    if (!$result) {
        return '';
    }

    $jcci = $jcch = [];
    $zip_type = 'zip';

    foreach ($result as $k => $item) {
        $mine_type = explode('/', $item->post_mime_type);
        $result[$k]->post_mime_type = $mine_type[1];

        if ($mine_type[1] == $zip_type) {
            array_push($jcci, $result[$k]);
        } else {
            array_push($jcch, $result[$k]);
        }
    }

    $jcci_data = [];
    if ($jcci && count($jcci) > 0 ) {
        $jcci_data[] = [
            'title' => $year > 2017 ? 'JCCI' : 'JBAV',
            'data' => $jcci,
        ];
    }
    if ($jcch && count($jcch) > 0) {
        $jcci_data[] = [
            'title' => $year > 2017 ? 'JBAV' : 'JBAH',
            'data' => $jcch,
        ];
    }

    $table = '';
    if ($jcci_data && count($jcci_data) > 0) {
        foreach ($jcci_data as $value) {
            $table .= '<div class="row mb-5">';
            $jcci_title = $value['title'];
            $data = $value['data'];

            foreach ($data as $k => $item) {
                $post_id = $item->ID;
                $attachment_url = wp_get_attachment_url($post_id);
                $post_date = date('Y.m.d', strtotime($item->post_date));

                $table .= '<div class="col-md-12">';
                if ($k == 0) {
                    $table .= '<h5>' . $jcci_title . '</h5>';
                }
                $table .= '<div class="file-name">';
                $table .= '<a class="'.jcci_get_file_type_class($item->post_mime_type).'" href="'.$attachment_url.'">';
                $table .= get_the_title($post_id).'.'.jcci_get_file_ext($attachment_url);
                $table .= '</a>';
                $table .= '</div>';
                $table .= '<div class="file-meta">';
                $table .= '<span class="file-size"><i class="zmdi zmdi-memory"></i> '.jcci_get_file_size($post_id).'</span>&nbsp;';
                $table .= '<span class="file-date"> <i class="zmdi zmdi-calendar"></i> '.$post_date.'</span>';
                $table .= '</div>';

                $table .= '</div>'; // End .col-md-12
            }
            $table .= '</div>'; // End .row
        }
    }

    $is_expanded = $year == date('Y') ? 'true' : 'false';
    $is_collpase_show = $year == date('Y') ? 'show' : '';
    $html .= '<div class="accordion" id="accordion-tab-'.$year.'">';
    $html .= '<div class="card">
                <div class="card-header" id="accordion-tab-'.$year.'-heading-'.$year.'">
                    <h5 class="clearfix">
                        <div class="float-left faq-question">'.$year.'年度</div>
                        <button class="btn btn-link" type="button" 
                            data-toggle="collapse" 
                            data-target="#accordion-tab-'.$year.'-content-'.$year.'" 
                            aria-expanded="'.$is_expanded.'" 
                            aria-controls="accordion-tab-'.$year.'-content-'.$year.'">
                        </button>
                    </h5>
                </div>
                <div class="collapse '.$is_collpase_show.'" id="accordion-tab-'.$year.'-content-'.$year.'" 
                    aria-labelledby="accordion-tab-'.$year.'-heading-'.$year.'" 
                    data-parent="#accordion-tab-'.$year.'">
                    <div class="card-body">
                        '.$table.'
                    </div>
                </div>
            </div>';
    $html .= '</div>'; // End .accordion

    return $html;
}
add_shortcode('jcci_board_meeting', 'jcci_board_meeting_shortcode'); 

function jcci_get_file_size( $attachment_id ) {
    $fileName = get_attached_file($attachment_id);
    if(!file_exists($fileName)){
        return '';
    }
    $bytes = filesize( $fileName );
    $s = array('b', 'Kb', 'Mb', 'Gb');
    $e = floor(log($bytes)/log(1024));

    return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
}

function jcci_get_file_ext ($filename) {
    $filetype = wp_check_filetype($filename);
    return $filetype['ext'];
}

function jcci_get_file_type_class ($file_type = '') {
    if (!$file_type) {
        return '';
    }

    switch ($file_type) {
        case 'zip':
            return 'link-zip';
            break;
        case 'msword':
            return 'link-msword';
            break;
        case 'pdf':
            return 'link-pdf';
            break;
        default:
            // code...
            break;
    }
}

/**
 * shortcode to display service taxonomy in single post template
 * full shortcode [service_members name="jcci-proposal-to-government" link="https://toilamit.com" open_first="yes" no_collpase="1,2"]
 * @param  [type] $atts [description]
 * @return [type]       [description]
 */
function service_members_shortcode($atts) { 

    $a = shortcode_atts( array(
        'name' => 'vietnam_legislation_documents',
        'link' => '',
        'open_first' => 'no',
        'no_collapse' => ''
    ), $atts );

    $field = 'vietnam_legislation_documents';

    if ($a['name'] == 'members-vj-joint-initiative') {
        $field = 'members_vj_joint_initiative';
    }

    if ($a['name'] == 'jcci-proposal-to-government') {
        $field = 'proposal_to_government';
    }

    if ($a['name'] == 'jcci-vietnam_business_forum') {
        $field = 'vietnam_business_forum';
    }

    $term = get_field($field);
    $args = array( 'posts_per_page' => -1 );
    $post_type = 'services';

    $posts = jcci_get_posts_by_term_id ($term->term_id, $post_type, $term->taxonomy, $args);

    if (!$posts) {
        return '';
    }

    $html = '';

    if (!empty($a['link'])) {
        $html .= '<a href="'.$a['link'].'" class="btn btn-large btn-view-all">'.jcci_translate_text('詳しくはこちら').' <i class="zmdi zmdi-arrow-right"></i></a>';
    }

    // $html = '<h4>' . $term->name . '</h4>';
    

    $html .= '<div class="accordion" id="accordion-tab-'.$field.'">';

    $count = 1;
    $show_first = true;
    $no_collapse = $a['no_collapse'] ? explode(',', $a['no_collapse']) : [];
    foreach ($posts as $k => $item) {
        $count = $count < 10 ? '0' . $count : $count;
        $count .= $field;
        $edit_post_link = get_edit_post_link($item->ID)
                            ? '<a class="post-edit-link" href="' . esc_url( get_edit_post_link($item->ID) ) . '">Edit</a>'
                            : '';

        $aria_expanded = 'false';
        $collapse_show = '';

        if ( $show_first && $a['open_first'] == 'yes' ) {
            $show_first = false;
            $aria_expanded = 'true';
            $collapse_show = 'show';
        }

        if (in_array(($k + 1), $no_collapse)) {
            $a_link = jcci_get_tag('a', get_the_content(null, false, $item));
            $a_link = $a_link ? $a_link[0] : '#';

            $html .= '<div class="card">
                    <div class="card-header" id="accordion-tab-'.$count.'-heading-'.$count.'">
                        <h5 class="clearfix">' . $a_link . '</h5>
                    </div>
                </div>'; // End .card
        } else {
            $html .= '<div class="card">
                    <div class="card-header" id="accordion-tab-'.$count.'-heading-'.$count.'">
                        <h5 class="clearfix">
                            <div class="float-left faq-question">'.$item->post_title.'</div>
                            <button class="btn btn-link" type="button" 
                                    data-toggle="collapse" 
                                    data-target="#accordion-tab-'.$count.'-content-'.$count.'" 
                                    aria-expanded="' . $aria_expanded . '" 
                                    aria-controls="accordion-tab-'.$count.'-content-'.$count.'">
                                </button>
                        </h5>
                    </div>
                    <div class="collapse ' . $collapse_show . '" id="accordion-tab-'.$count.'-content-'.$count.'" 
                        aria-labelledby="accordion-tab-'.$count.'-heading-'.$count.'" 
                        data-parent="#accordion-tab-'.$field.'">
                        <div class="card-body">
                            <div class="clearfix">
                                '.apply_filters('the_content', $item->post_content).'
                                '.$edit_post_link.'
                            </div>
                        </div>
                    </div>
                </div>'; // End .card
        }

        $count++;
    }
    $html .= '</div>'; // End .accordion
 
    return $html;
} 
add_shortcode('service_members', 'service_members_shortcode'); 

/**
 * Vietnam business forum
 * @param  [type] $atts [description]
 * @return [type]       [description]
 */
function vbf_shortcode($atts) {
    $a = shortcode_atts( array(
        'name' => 'jcci-vietnam_business_forum',
        'num_post' => 4
    ), $atts );

    $field = 'vietnam_business_forum';

    $term = get_field($field);
    $args = array( 'posts_per_page' => $a['num_post'] );
    $post_type = 'services';

    $posts = jcci_get_posts_by_term_id ($term->term_id, $post_type, $term->taxonomy, $args);

    if (!$posts) {
        return '';
    }
    $html = '<div class="row vbf">';

    foreach ($posts as $item) {
        $thumb = get_template_directory_uri() . '/assets/img/vbf-thumb-default.jpg';
        if (get_the_post_thumbnail($item->ID)) {
            $thumb = get_the_post_thumbnail_url($item->ID, 'vbf-thumb');
        }
        $html .= '<div class="col-md-6 col-xs-12 vbf--item">
                    <a href="'.get_the_permalink($item->ID).'">
                        <div class="post--thumb">
                            <img src="'.$thumb.'" alt="'.$item->post_title.'">
                        </div>
                    </a>
                    <div class="post--info">
                        <a href="'.get_the_permalink($item->ID).'" class="post--title">'.$item->post_title.'</a>
                        <p class="post--excerpt">'.get_the_excerpt($item->ID).'</p>
                        <p>
                            <a href="'.get_the_permalink($item->ID).'" class="btn btn-large btn-view-all">
                                '.jcci_translate_text('詳細はこちらへ').' <i class="zmdi zmdi-arrow-right"></i>
                            </a>
                        </p>
                    </div>
                </div>';
    }

    $html .= '</div>'; // end .vbf

    return $html;
}
add_shortcode('vbf_service_members', 'vbf_shortcode'); 

function jcci_get_posts_years($post_type = 'post', $output = ARRAY_N) {
    global $wpdb;
    $result = array();
    $sql = $wpdb->prepare( "SELECT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type='%s' GROUP BY YEAR(post_date) DESC", $post_type );
    $years = $wpdb->get_results( $sql, ARRAY_N );
    
    if ( is_array( $years ) && count( $years ) > 0 ) {
        foreach ( $years as $year ) {
            $result[] = $year[0];
        }
    }
    return $result;
}

// Japanese financial year
function jcci_get_posts_financial_years($post_type = 'post', $output = ARRAY_N) {
    global $wpdb;
    $result = array();
    $sql = 
        "SELECT
        (CASE WHEN DATE_FORMAT(post_date, '%d') <= '31' && DATE_FORMAT(post_date, '%m') <= '03' THEN DATE_FORMAT(DATE_SUB(post_date, INTERVAL 1 YEAR), '%Y年度') ELSE DATE_FORMAT(post_date, '%Y年度') END) as year 
        FROM  wp_posts
        WHERE post_status = 'publish' 
        AND post_type='".$post_type."' 
        GROUP BY year DESC"; 

    $years = $wpdb->get_results( $sql, ARRAY_N );

    if ( is_array( $years ) && count( $years ) > 0 ) {
        foreach ( $years as $year ) {
            $result[] = $year[0];
        }
    }
    return $result;
}

function jcci_get_posts_year_months($post_type = 'post', $term_id, $field = 'year', $output = ARRAY_N) {
    global $wpdb;
    $result = array();
    
    if($field == 'year'){
        $sql = $wpdb->prepare( "SELECT DATE_FORMAT(p.post_date, '%Y年') as y, DATE_FORMAT(p.post_date, '%Y') as val FROM {$wpdb->posts} as p INNER JOIN {$wpdb->term_relationships} as tr ON p.ID = tr.object_id WHERE p.post_status = 'publish' AND p.post_type='%s' AND tr.term_taxonomy_id=%d GROUP BY y, val ORDER BY y DESC", $post_type, $term_id );
    }else{
        $sql = $wpdb->prepare( "SELECT DATE_FORMAT(p.post_date, '%Y年%m月') as y, DATE_FORMAT(p.post_date, '%Y-%m') as val FROM {$wpdb->posts} as p INNER JOIN {$wpdb->term_relationships} as tr ON p.ID = tr.object_id WHERE p.post_status = 'publish' AND p.post_type='%s' AND tr.term_taxonomy_id=%d GROUP BY y, val ORDER BY y DESC", $post_type, $term_id );
    }

    $year_months = $wpdb->get_results( $sql, ARRAY_N );
    if ( is_array( $year_months ) && count( $year_months ) > 0 ) {
        foreach ( $year_months as $year_month ) {
            $result[] = [
                'key'  => $year_month[0],
                'val'  => $year_month[1]
            ];
        }
    }
    return $result;
}

function jcci_get_current_url() {
    global $wp;
    
    $current_url =  home_url( $wp->request );

    $position = strpos( $current_url , '/page' );
    $nopaging_url = ( $position ) ? substr( $current_url, 0, $position ) : $current_url;

    return trailingslashit( $nopaging_url );
}

function jcci_translate_text($str) {
    return function_exists('pll__') ? pll__($str) : $str;
}

function jcci_render_breadcrumb( $breadcrumb = array() ) { ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= home_url(); ?>"><?= jcci_translate_text('ホーム') ?></a>
            </li>
            <?php foreach ($breadcrumb as $k => $item): ?>
                <?php if (empty($item['text'])) { continue; } ?>

                <?php if ($k == (count($breadcrumb) - 1)): ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $item['text']; ?>
                    </li>
                <?php else: ?>
                    <li class="breadcrumb-item">
                        <a href="<?= $item['url']; ?>"><?= $item['text']; ?></a>
                    </li>
                <?php endif ?>
            <?php endforeach ?>
          </ol>
    </nav>
<?php }

function jcci_innerXML($node) { 
    $doc = $node->ownerDocument; 
    $frag = $doc->createDocumentFragment(); 
    foreach ($node->childNodes as $child) { 
        $frag->appendChild($child->cloneNode(TRUE)); 
    } 
    return $doc->saveXML($frag); 
}

function jcci_get_children_page () {
    global $post;

    $parent_title = '';
    $parent_id = $post->post_parent;
    if ($parent_id) {
        $parent_title = get_the_title( $post->post_parent );
    }

    $args = array(
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'post_parent'    => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC'
     );

    $children = get_posts( $args );

    return [
        'parent_title' => $parent_title,
        'parent_id' => $parent_id,
        'children' => $children
    ];
}

function jcci_get_categories_by_post_type ($taxonomy = 'news_category', $args = array()) {
    // $cats=  get_categories(array( 'taxonomy' => $taxonomy ));
    $cats = get_terms( $taxonomy, $args );
    return $cats;
}

function jcci_get_posts_by_post_type ($post_type = 'post', $args = null) {
    $args_default = array(
        'post_type' => $post_type,
        'order' => 'DESC',
        'order_by' => 'date',
        'posts_per_page' => 5
    );
    if ($args) {
        $args_default = array_merge($args_default, $args);
    }
    $posts = get_posts($args_default);

    return $posts;
}

function jcci_get_posts_by_term_id ($term_id, $post_type = '', $taxonomy = '', $args = array(), $orderby = 'date') {
    $args_default = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => 5,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'terms' => $term_id,
                'field' => 'term_id',
            )
        ),
        'orderby' => $orderby,
        'order' => 'DESC'
    );
    if ($args) {
        $args_default = array_merge($args_default, $args);
    }
    $posts = get_posts( $args_default );

    return $posts;
}

if (function_exists('pll_register_string')) {
    add_action('init', 'jcci_translation');
    /*------------------------------------*\
        Polylang Translation
    \*------------------------------------*/
    function jcci_translation() {
        pll_register_string('home', 'ホーム', 'jcci');
        pll_register_string('pick-up', 'Pick Up 情報', 'jcci');
        pll_register_string('organization', '組織構成', 'jcci');
        pll_register_string('faq', 'よくある質問', 'jcci');
        pll_register_string('news', 'お知らせ', 'jcci');
        pll_register_string('latest-news', '最新情報', 'jcci');
        pll_register_string('activities', '活動報告', 'jcci');
        pll_register_string('member-services', '会員向けサービス', 'jcci');
        pll_register_string('event-calendar', 'イベントカレンダー', 'jcci');
        pll_register_string('contact', '組織概要', 'jcci');

        pll_register_string('address', '住所', 'jcci');
        pll_register_string('mobile', '電話番号', 'jcci');
        pll_register_string('mail', 'メール', 'jcci');
	pll_register_string('inquiry', 'お問合せ', 'jcci');

        pll_register_string('post-related', '同じカテゴリの記事一覧', 'jcci');
        pll_register_string('view-list', '一覧はこちら', 'jcci');
        pll_register_string('view-detail', '詳細はこちらへ', 'jcci');
        pll_register_string('view-detail-2', '詳しくはこちら', 'jcci');
        pll_register_string('register-guide', '入会案内', 'jcci');

        pll_register_string('joining-benefit', '入会のメリット＆入会のお手続き', 'jcci');
        pll_register_string('member-condition', '会費&会員条件', 'jcci');
        pll_register_string('greeting', 'こんにちは', 'jcci');
        pll_register_string('logout', 'ログアウト', 'jcci');
        pll_register_string('login', 'ログイン', 'jcci');
    }
}

/**
 * Hide the +Add new category link in post and post new
 * @return [type] [description]
 */
function jcci_custom_admin_style() {
  echo '<style>
    div[id*="category-adder"] {display: none !important;}
  </style>';
}
add_action('admin_head', 'jcci_custom_admin_style');

/**
    Returns an array containing each of the sub-strings from text that
    are between openingMarker and closingMarker. The text from
    openingMarker and closingMarker are not included in the result.
    This function does not support nesting of markers.
  */
  function returnSubstrings($text, $openingMarker, $closingMarker) {
    $openingMarkerLength = strlen($openingMarker);
    $closingMarkerLength = strlen($closingMarker);
 
    $result = array();
    $position = 0;
    while (($position = strpos($text, $openingMarker, $position)) !== false) {
      $position += $openingMarkerLength;
      if (($closingMarkerPosition = strpos($text, $closingMarker, $position)) !== false) {
        $result[] = substr($text, $position, $closingMarkerPosition - $position);
        $position = $closingMarkerPosition + $closingMarkerLength;
      }
    }
    return $result;
  }


//TODO: temp function, we will remove them later
function shortcode_button_script()
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
               
                //this function is used to retrieve the selected text from the text editor
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton(
                    "code_shortcode",
                    "Code",
                    callback
                );

                function callback()
                {
                    var selected_text = getSel();
                    QTags.insertContent("[code]" +  selected_text + "[/code]");
                }
            </script>
        <?php
    }
}
// add_action("admin_print_footer_scripts", "shortcode_button_script");


function taxonomy_slug_rewrite($wp_rewrite) {
    $rules = array();
    // get all custom taxonomies
    $taxonomies = get_taxonomies(array('_builtin' => false), 'objects');
    // get all custom post types
    $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');

    foreach ($post_types as $post_type) {
        foreach ($taxonomies as $taxonomy) {

            // go through all post types which this taxonomy is assigned to
            foreach ($taxonomy->object_type as $object_type) {

                // check if taxonomy is registered for this custom type
                if ($object_type == $post_type->rewrite['slug']) {

                    // get category objects
                    $terms = get_categories(array('type' => $object_type, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));

                    // make rules
                    foreach ($terms as $term) {
                        $rules[$object_type . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
                    }
                }
            }
        }
    }
    // merge with global rules
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
// add_filter('generate_rewrite_rules', 'taxonomy_slug_rewrite');

// $ids = [18,17,16,19,20,70,256,29,33,30,125,31,28,34,27,22,652,581,257,255,26];
// $ids_vi = [45,46,47,48,49,79,262,55,59,56,160,58,54,60,53,51,61,273,722,259,260];
// $ids_en = [435,436,437,438,439,440,441,443,444,445,446,447,449,450,451,452,454,139,458,457,720];
// foreach ( $ids as $k => $id ) {
//     $translations[] = array( 'ja' => $id, 'vi' => $ids_vi[$k], 'en' => $ids_en[$k] );
// }

// set_translation_in_mass( 'post', $translations );
// jcci_debug('');die('here');


/**
 * Used to create a translations groups in mass
 *
 * @since 1.6.3
 *
 * @param string $type         either 'post' or 'term'
 * @param array  $translations array of translations arrays
 */
function set_translation_in_mass( $type, $translations ) {
    global $wpdb;

    $taxonomy = $type . '_translations';

    foreach ( $translations as $t ) {
        $term = uniqid( 'pll_' ); // the term name
        $terms[] = $wpdb->prepare( '( %s, %s )', $term, $term );
        $slugs[] = $wpdb->prepare( '%s', $term );
        $description[ $term ] = maybe_serialize( $t );
        $count[ $term ] = count( $t );
    }

    // jcci_debug(implode( ',', $slugs ));
    // jcci_debug($terms);
    // jcci_debug($slugs);
    // jcci_debug($description);
    // jcci_debug($count);
    // jcci_debug($wpdb);

    // die('inner');

    // Insert terms
    if ( ! empty( $terms ) ) {
        // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared
        $wpdb->query( "INSERT INTO {$wpdb->terms} ( slug, name ) VALUES " . implode( ',', array_unique( $terms ) ) );
    }

    // Get all terms with their term_id
    // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared
    $terms = $wpdb->get_results( "SELECT term_id, slug FROM {$wpdb->terms} WHERE slug IN ( " . implode( ',', $slugs ) . ' )' );

    // Prepare terms taxonomy relationship
    foreach ( $terms as $term ) {
        $term_ids[] = $term->term_id;
        $tts[] = $wpdb->prepare( '( %d, %s, %s, %d )', $term->term_id, $taxonomy, $description[ $term->slug ], $count[ $term->slug ] );
    }

    // Insert term_taxonomy
    if ( ! empty( $tts ) ) {
        // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared
        $wpdb->query( "INSERT INTO {$wpdb->term_taxonomy} ( term_id, taxonomy, description, count ) VALUES " . implode( ',', array_unique( $tts ) ) );
    }

    // Get all terms with term_taxonomy_id
    $terms = get_terms( $taxonomy, array( 'hide_empty' => false ) );

    // Prepare objects relationships
    foreach ( $terms as $term ) {
        $t = maybe_unserialize( $term->description );
        if ( in_array( $t, $translations ) ) {
            foreach ( $t as $object_id ) {
                if ( ! empty( $object_id ) ) {
                    $trs[] = $wpdb->prepare( '( %d, %d )', $object_id, $term->term_taxonomy_id );
                }
            }
        }
    }

    // Insert term_relationships
    if ( ! empty( $trs ) ) {
        // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared
        $wpdb->query( "INSERT INTO {$wpdb->term_relationships} ( object_id, term_taxonomy_id ) VALUES " . implode( ',', $trs ) );
        $trs = array_unique( $trs );
    }

    clean_term_cache( $term_ids, $taxonomy );
    die('done');
}

// hide update notifications
function remove_core_updates(){
    global $wp_version;
    return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
add_filter('pre_site_transient_update_themes','remove_core_updates'); //hide updates for all themes
