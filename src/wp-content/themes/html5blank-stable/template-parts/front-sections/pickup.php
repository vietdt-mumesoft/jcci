<?php
$content = get_field('list_pickup_links', get_query_var( 'page_id' ));
?>

<section id="pickup" class="section">
    <div class="section--inner">
        <div class="container">
            <h3 class="section--title">
                <?= jcci_translate_text('Pick Up 情報') ?>
            </h3>
            <div class="section--content">
                <div class="section--content-inner">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-10 col-xs-12">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>