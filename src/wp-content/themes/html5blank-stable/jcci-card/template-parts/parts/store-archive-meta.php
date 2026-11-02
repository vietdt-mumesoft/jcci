<?php
/**
 * Template for Card taxonomy meta
 */

$current_posttype = get_queried_object();

global $wp_query;
$post_count = $wp_query->found_posts;

?>

<div class="row">
    <div class="large-6 col pb-half">
        <div class="tax-name">
            <span class="title"> すべて </span>
            <span>／</span>
            <span class="count"><?php echo $post_count; ?> 店舗</span>
        </div>
    </div>
    <div class="large-6 col pb-half">
        <div class="tax-description">
            <span style="color: #ed1c24;">※割引等のサービスが受けられない場合は、その場で、</span>
            <p>
                <span style="color: #ed1c24;">各店舗の担当者に電話連絡ください。</span>
            </p>
            <p>
                <span style="color: #ed1c24;">※他割引・他サービスとの併用不可。</span>
            </p>
        </div>
    </div>
</div>