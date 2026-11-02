<?php 
$banners = [];
$i = 1;
while(get_field('banner_'.$i)){
    $banner = get_field('banner_'.$i);
    $temp = [
        'title' => 'バナー'.$i,
        'desc' => '',
        'img' => '',
        'url' => '#'
    ];

    $url = $banner['url'] ? $banner['url'] : '#';
    $imageUrl = $banner['image'] ? $banner['image'] : '#';
    $temp['img'] = $imageUrl;
    $temp['url'] = $url;
    array_push($banners, $temp);
    $i++;
    
}
?>

<section id="banner" class="section">
    <div class="section--inner">
        <div class="section--content">
            <div class="section--content-inner">
                <div id="banner-slider" class="banner-slide owl-carousel owl-theme">
                    <?php foreach ($banners as $banner) { ?>
                    <div class="banner mb-2">
                        <a target="_blank" href="<?php echo $banner['url']; ?>" title="">
                            <img src="<?= $banner['img'] ?>" alt="<?= $banner['title'] ?>">
                            <?php if (0): ?>
                            <div class="banner--overlay d-none"></div>
                            <div class="banner--text d-none">
                                <div class="banner--text-title">
                                    <?php echo $banner['title']; ?>
                                </div>
                                <div class="banner--text-desc">
                                    <?php echo $banner['desc']; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>  
</section>