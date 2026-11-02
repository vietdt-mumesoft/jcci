<?php
/**
 * Template for Card taxonomy head
 */

/**
 * @var string $en_label
 * @var string $jp_label
 */

$term = get_queried_object();

if ($term->taxonomy === 'cuisine') {
    $en_label = 'Restaurant';
    $jp_label = 'レストラン';
} elseif ($term->taxonomy === 'place') {
    $en_label = 'Hotel / Apart';
    $jp_label = 'ホテル、アパート';
} elseif ($term->taxonomy === 'store') {
    $en_label = 'Shop / Golf / Other';
    $jp_label = 'ショップ、ゴルフ、その他';
}

// get current post type label
$post_type_label = $en_label;
$translation_label = $jp_label;

?>

<div class="row">
    <div class="large-6 col pb-half">
        <div class="tax-title">
            <h3 class="title"><?php echo $post_type_label ?></h3>
            <span class="sub"><?php echo $translation_label; ?></span>
        </div>
    </div>
    <div class="large-6 col pb-half">
        <div class="pc-search-form">
            <?php get_template_part('jcci-card/template-parts/parts/search-form'); ?>
        </div>
    </div>
</div>