<?php /* Template Name: JCCI Card - Hotel Apart */ ?>

<?php get_header('card'); ?>

<div class="page page-jcci-card">
    <?php 
    $page_id = get_the_ID();
    $language = get_locale();
    get_template_part( 'jcci-card/template-parts/archive-hotel-apart' );
    ?>
</div>

<?php get_footer('card'); ?>