<?php 
$slider_text = get_field('slider_text');
$items = get_field('front_slider');
$totalItems = 0;
?>

<div id="slider">
    <div class="slider--title">
        <?= $slider_text ?>
    </div>

    <div id="main-slider" class="owl-carousel owl-theme">
        <?php foreach ($items as $item) {
            $img = $item['image'];
            if (!$img) continue;
        ?>
        <div class="owl-slide main-slider--item" style="background-image: url(<?php echo $img;?>);">
            <div class="overlay"></div>
        </div>
        <?php
        $totalItems++;
        } ?>
    </div>
    <?php if ($totalItems > 1): ?>
    <div class="slider--pagination">
        <button class="slider--nav main-slider--nav slider--btn-prev" data-direction="prev"><i class="zmdi zmdi-arrow-left"></i></button>
        <span class="slider--counter-current">01</span>/<span class="slider--counter-total"><?php echo str_pad($totalItems, 2, '0', STR_PAD_LEFT); ?></span>
        <button class="slider--nav main-slider--nav slider--btn-next" data-direction="next"><i class="zmdi zmdi-arrow-right"></i></button>
    </div>
    <?php endif; ?>
</div>