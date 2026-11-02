<?php
/**
 * Template for term listing in store archive page
 */

$current_posttype = get_queried_object();

// Get taxonomy for current post type
if ($current_posttype instanceof WP_Post_Type) {
    $taxonomies = get_object_taxonomies($current_posttype->name);
    if (!empty($taxonomies)) {
        $taxonomy = $taxonomies[0]; 
    }
} elseif ($current_posttype instanceof WP_Term) {
    $taxonomy = $current_posttype->taxonomy;
}

// Get terms for current post type
$terms = get_terms([
    'taxonomy'   => $taxonomy,
    'hide_empty' => false,
]);
?>

<div class="row">
    <div class="large-12 col pb-half">
        <div class="tax-list">
            <ul>
                <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                    <?php foreach ($terms as $term) : ?>
                        <li>
                            <a href="<?php echo get_term_link($term); ?>" title="<?php echo $term->name; ?>" alt="<?php echo $term->name; ?>">
                                <?php echo $term->name; ?>
                            </a>
                            <span>／</span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>