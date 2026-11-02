<?php /* Template Name: JCCI Card - Golf Other */ ?>

<?php get_header('card'); ?>

<div class="page page-jcci-card">
    <?php 
    $page_id = get_the_ID();
    $language = get_locale();
    get_template_part( 'jcci-card/template-parts/archive-shop-golf-other' );
    ?>
</div>

<?php get_footer('card'); ?>