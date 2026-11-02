<?php
/**
 * Template for search form
 */

$search_keyword = isset($_GET['s']) ? $_GET['s'] : '';
?>

<div class="tax-search">
    <form method="get" class="searchform" action="<?php echo site_url(); ?>" role="search">
        <div class="flex-row relative">
            <div class="flex-col flex-grow">
                <input type="search" class="search-field mb-0" autocomplete="off" name="s" value="<?php echo $search_keyword; ?>" id="s" placeholder="検 索" wfd-id="id3">
                <input type="hidden" name="is_card" value="1">
            </div>
            <!-- .flex-col -->
            <div class="flex-col">
                <button type="submit" class="ux-search-submit submit-button secondary button icon mb-0">
                    <i class="icon-search"></i>
                </button>
            </div>
        </div>
        <!-- .flex-row -->
        <div class="live-search-results text-left z-top"></div>
    </form>
</div>