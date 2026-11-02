<?php

// Check if posttype is from restaurant, hotel-apart, shop-golf-other
$post_type = $_GET['post_type'];
$is_card_search = $_GET['is_card'];

if ($is_card_search == '1') {
    // Card search
    get_template_part('jcci-card/template-parts/search');
} else {
	// Normal search
	?>

	<?php get_header(); ?>

		<main role="main">
			<!-- section -->
			<section>

				<h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>

				<?php get_template_part('loop'); ?>

				<?php get_template_part('pagination'); ?>

			</section>
			<!-- /section -->
		</main>

	<?php get_sidebar(); ?>

	<?php get_footer(); ?>

<?php } ?>
