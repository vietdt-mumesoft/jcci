<?php /* Template Name: Front Page Template */ ?>
<?php get_header(); ?>
<div class="page jcci-front-page">
    <?php 
    $page_id = get_the_ID();
    get_template_part( 'template-parts/front-sections/slider' );
    get_template_part( 'template-parts/front-sections/about-jcci' );
    get_template_part( 'template-parts/front-sections/groups' );
    $language = get_locale();
    if( $language == 'ja' ){
        set_query_var( 'page_id', $page_id);
        get_template_part( 'template-parts/front-sections/news');
	get_template_part( 'template-parts/front-sections/pickup' );
        get_template_part( 'template-parts/front-sections/actions' );
    }
    get_template_part( 'template-parts/front-sections/services' );
    get_template_part( 'template-parts/front-sections/event-calendar' );
    get_template_part( 'template-parts/front-sections/faq' );
    get_template_part( 'template-parts/front-sections/banner' );
    // get_template_part( 'template-parts/front-sections/contact' );
    ?>
</div>
<?php get_footer(); ?>
