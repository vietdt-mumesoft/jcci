<?php 
$default_calendar_id = get_option('ecwd_default_calendar');
$default_calendar_id = intval($default_calendar_id);
$content = get_the_content(null, false, $default_calendar_id);
$content = strip_tags($content);
?>

<section id="jcci-calendar" class="section">
    <div class="section--inner">
        <div class="container">
            <h3 class="section--title">
            <?= jcci_translate_text('イベントカレンダー') ?>
            </h3>
            <div class="section--content">
                <div class="section--content-inner">
                    <div class="calendar--current text-center d-none">
                        <div class="calendar--current-date">2019年10月3日</div>
                        <div class="calendar--current-time">9:00 AM - 6:00 PM</div>
                    </div>
                    <div class="calendar--table">
                        <?php if ($content) {
                            echo do_shortcode($content);
                        } else {
                            echo '<p class="text-center">No calendar</p>';
                        } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>