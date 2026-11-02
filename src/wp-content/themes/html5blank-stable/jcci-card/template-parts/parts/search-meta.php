<?php
/**
 * Template for Card search meta
 */

global $wp_query;
$post_count = $wp_query->found_posts;

// get search keyword
$search_keyword = isset($_GET['s']) ? $_GET['s'] : '';
?>

<div class="row">
    <div class="large-6 col pb-half">
        <div class="tax-name">
            <span class="title"><?php echo $search_keyword ?></span>
            <span>／</span>
            <span class="count"><?php echo $post_count; ?> 店舗</span>
        </div>
    </div>
</div>