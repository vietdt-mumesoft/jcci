<?php 
$big_title = get_field('faq_big_title');
$description = get_field('faq_description');
$url = get_field('faq_url');
$bgUrl = get_field('faq_background');

$url = $url ? $url : '#';
$bgUrl = $bgUrl ? $bgUrl : get_template_directory_uri() . '/assets/img/bg-faq.jpg';
?>

<a class="d-block parallax-container" href="<?= $url ?>">
    <section id="faq" class="section">
        <div class="section--inner">
            <div class="container">
                <h3 class="section--title title--big-sm text-white"><?= $big_title ?></h3>
                <div class="col-md-8 col-xs-12 m-auto text-center">
                    <div class="section--subtitle"><?= $description ?></div>
                </div>
            </div>
            <div class="icon--explorer">
                <i class="zmdi zmdi-arrow-right"></i>
            </div>
        </div>
    </section>

    <div class="parallax">
        <img src="<?= $bgUrl ?>">
    </div>
</a>