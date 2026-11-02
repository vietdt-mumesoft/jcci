<?php $jcci_option = jcci_get_global_options(); ?>

<section id="jcci-contact" class="section">
    <div class="section--inner pb-0">
        <div class="section--content">
            <div class="section--content-inner">
                <div class="contact--info">
                    <div class="container">
                        <div class="row m-0">
                            <div class="col-md-5">
                                <div class="contact--info-inner">
                                    <p class="mb-4 contact--logo">
                                        <a href="<?php echo home_url() ?>">
                                            <img class="logo-bottom" src="<?php echo get_template_directory_uri() ?>/assets/img/logo-top.png" alt="Logo JCCI">
                                        </a>
                                    </p>
                                    <p class="contact--address contact--item">
                                        <strong class="contact--info-label">
                                            <?= jcci_translate_text('住所')  ?>
                                        </strong><br>
                                        Room605, Sun Red River Building, <br>23 Phan Chu Trinh St., Hanoi, <br>VIETNAM
                                    </p>
                                    <p class="contact--phone contact--item">
                                        <strong class="contact--info-label">
                                            <?= jcci_translate_text('電話番号') ?>
                                        </strong><br>
                                        <a href="tel:+84-24-2220-9907/8">+84-24-2220-9907/8</a>
                                    </p>
                                   
                                    <p class="contact--mail contact--item">
                                        <strong class="contact--info-label">
                                            <?= jcci_translate_text('お問合せ') ?>
                                        </strong><br>
                                        <?php if ( function_exists( 'pll_current_language' ) && pll_current_language() !== 'ja' ) : ?>
                                            <a href="https://forms.cloud.microsoft/r/sf0kcdpAeQ" target="_blank">https://forms.cloud.microsoft/r/sf0kcdpAeQ</a>
                                        <?php else : ?>
                                            <a href="https://forms.cloud.microsoft/r/sf0kcdpAeQ" target="_blank">https://forms.cloud.microsoft/r/sf0kcdpAeQ</a>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row m-0 w-100 contact--pos">
                    <div class="col-md-5 p-0 contact--info-bg" style="background-image: url(<?php echo $jcci_option['jcci_bg_contact_input'] ?>);"></div>
                    <div class="col-md-7 p-0 contact--map">
                        <a target="_blank" href="<?php echo $jcci_option['jcci_map_url_input'] ?>" title="JCCI Address in Map" class="d-block h-100"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>

