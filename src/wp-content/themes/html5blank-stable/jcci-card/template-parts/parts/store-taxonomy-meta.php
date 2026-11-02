<?php
/**
 * Template for Card taxonomy meta
 */

// Get post count
$term = get_queried_object();
$post_count = $term->count;

?>

<div class="row">
    <div class="large-6 col pb-half">
        <div class="tax-name">
            <span class="title"> <?php echo $term->name; ?> </span>
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