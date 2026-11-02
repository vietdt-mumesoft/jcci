<?php 
$big_title_1 = get_field('about_big_title');
$description_1 = get_field('about_description');
$background_1 = get_field('about_background_image');
$url_1 = get_field('about_url');

$big_title_2 = get_field('intro_register_big_title');
$description_2 = get_field('intro_register_description');
$background_2 = get_field('intro_register_background_image');
$url_2 = get_field('intro_register_url');

$big_title_1 = $big_title_1 ? $big_title_1 : 'JCCIとは';
$background_1 = $background_1 ? $background_1 : get_template_directory_uri() . '/assets/img/about-jcci.jpg';
$url_1 = $url_1 ? $url_1 : '#';

$big_title_2 = $big_title_2 ? $big_title_2 : jcci_translate_text('入会案内');
$background_2 = $background_2 ? $background_2 : get_template_directory_uri() . '/assets/img/join-jcci.jpg';
$url_2 = $url_2 ? $url_2 : '#';
?>
<section id="about-jcci" class="section">
    <div class="section--inner">
        <div class="container">
            <div class="section--content">
                <div class="section--content-inner">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a class="about--item" href="<?= $url_1 ?>" style="background-image: url(<?= $background_1 ?>);">
                                <div class="about--overlay"></div>
                                <div class="icon--explorer">
                                    <i class="zmdi zmdi-arrow-right"></i>
                                </div>
                                <div class="about--text">
                                    <div class="title--big title--big-sm about--text-title">
                                        <?= $big_title_1 ?>
                                    </div>
                                    <div class="about--text-desc">
                                        <?= $description_1 ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a class="about--item" href="<?= $url_2 ?>" style="background-image: url(<?= $background_2 ?>);">
                                <div class="about--overlay"></div>
                                <div class="icon--explorer">
                                    <i class="zmdi zmdi-arrow-right"></i>
                                </div>
                                <div class="about--text">
                                    <div class="title--big title--big-sm about--text-title">
                                        <?= $big_title_2 ?>
                                    </div>
                                    <div class="about--text-desc">
                                        <?= $description_2 ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>