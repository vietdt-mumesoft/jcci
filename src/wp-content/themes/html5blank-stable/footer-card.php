</main>
<!-- #main -->
 
<footer id="footer" class="footer-wrapper">
  <section class="section" id="section_1980937753">
    <div class="bg section-bg fill bg-fill bg-loaded "></div>
    <!-- .section-bg -->
    <div class="section-content relative">
      <div class="row" id="row-1172634458">
        <div class="col pb-0 small-12 large-12">
          <div class="col-inner">
            <ul class="sidebar-wrapper ul-reset ">
              <div id="nav_menu-2" class="col pb-0 widget widget_nav_menu">
                <div class="menu-main-menu-container">
                  <ul id="menu-main-menu-1" class="menu">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-2 current_page_item menu-item-15">
                      <a href="<?php echo site_url('card'); ?>" aria-current="page">JCCIカードホーム</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17">
                      <a href="<?php echo site_url('restaurants'); ?>">レストラン</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18">
                      <a href="<?php echo site_url('hotel-apart'); ?>">ホテル／アパート</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19">
                      <a href="<?php echo site_url('shop-golf-other'); ?>">ショップ／ゴルフ／その他</a>
                    </li>
                  </ul>
                </div>
              </div>
            </ul>
            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1012874052">
              <div class="img-inner  dark">
                <img width="278" height="50" src="<?php echo JCCI_CARD_URL; ?>/assets/img/logo-ft.png" class="attachment-large size-large" alt="" decoding="async" loading="lazy">
              </div>
              <style scope="scope">
                #image_1012874052 {
                  width: 30%;
                }
              </style>
            </div>
            <ul class="ft-contact">
              <li>
                <span class="label">Address</span>
                <font color="red">／</font> Room605, Sun Red River Building, 23 Phan Chu Trinh St., Hanoi, VIETNAM
              </li>
              <li>
                <span class="label">TEL</span>
                <font color="red">／</font> +84-24-2220-9907/8 FAX +84-24-2220-9909
              </li>
              <li>
                <span class="label">Email</span>
                <font color="red">／</font> jcci-info@jcci.vn
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- .section-content -->
    <style scope="scope">
      #section_1980937753 {
        padding-top: 40px;
        padding-bottom: 40px;
      }

      #section_1980937753 .section-bg.bg-loaded {
        background-image: url(<?php echo JCCI_CARD_URL; ?>/assets/img/bg-footer.png);
      }
    </style>
  </section>
  <div class="absolute-footer dark medium-text-center text-center">
    <div class="container clearfix">
      <div class="footer-primary pull-left">
        <div class="menu-main-menu-container">
          <ul id="menu-main-menu-2" class="links footer-nav uppercase">
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-2 current_page_item menu-item-15">
              <a href="<?php echo site_url('card'); ?>" aria-current="page">JCCIカードホーム</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17">
              <a href="<?php echo site_url('restaurants'); ?>">レストラン</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18">
              <a href="<?php echo site_url('hotel-apart'); ?>">ホテル／アパート</a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19">
              <a href="<?php echo site_url('shop-golf-other'); ?>">ショップ／ゴルフ／その他</a>
            </li>
          </ul>
        </div>
        <div class="copyright-footer"> Copyright 2019 © <a href="<?php echo site_url('card'); ?>">JCCI</a>. Design by <strong>
            <a href="https://hvcg.vn/">HVCG Software</a>
          </strong>
        </div>
      </div>
      <!-- .left -->
    </div>
    <!-- .container -->
  </div>
  <!-- .absolute-footer -->
  <a href="#top" class="back-to-top button invert plain light hide-for-medium icon fixed bottom z-1" id="top-link">
    <i class="icon-angle-up"></i>
  </a>
</footer>
<!-- .footer-wrapper -->
</div>
<!-- #wrapper -->
<script type="text/javascript">
  jQuery(document).ready(function() {
    function toggleSidebar() {
      jQuery(".menu-icon").toggleClass("active");
      jQuery(".menu-item").toggleClass("active");
    }
    jQuery(".menu-icon").on("click tap", function() {
      toggleSidebar();
    });
    jQuery(document).keyup(function(e) {
      if (e.keyCode === 27) {
        toggleSidebar();
      }
    });
    jQuery("a[href='#top']").click(function() {
      jQuery("html, body").animate({
        scrollTop: 0
      }, "slow");
      return false;
    });
    jQuery(".block-menu .ul-parent .parent>a").click(function() {
      //jQuery(this).parents('li').find('.ul-child').toggleClass('active');
      jQuery(this).parents('li').toggleClass('active');
      jQuery(this).parents('li').find('.ul-child').toggleClass('active');
    });
  });
</script>
<!-- Mobile Sidebar -->
<div id="main-menu" class="mobile-sidebar no-scrollbar mfp-hide">
  <div class="sidebar-menu no-scrollbar ">
    <!-- Logo -->
    <div id="mobile-logo" class="flex-col logo">
      <a href="<?php echo site_url('card'); ?>" target="_bank" title="JCCI - " rel="home">
        <img src="<?php echo JCCI_CARD_URL; ?>/assets/img/logo-1.png" class="header_logo header-logo" alt="JCCI">
        <img src="<?php echo JCCI_CARD_URL; ?>/assets/img/logo-1.png" class="header-logo-dark" alt="JCCI">
      </a>
      <p class="logo-tagline"></p>
    </div>
    <ul class="nav nav-sidebar  nav-vertical nav-uppercase">
      <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-2 current_page_item menu-item-15">
        <a href="<?php echo site_url('card'); ?>" class="nav-top-link">JCCIカードホーム</a>
      </li>
      <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17">
        <a href="<?php echo site_url('restaurants'); ?>" class="nav-top-link">レストラン</a>
      </li>
      <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18">
        <a href="<?php echo site_url('hotel-apart'); ?>" class="nav-top-link">ホテル／アパート</a>
      </li>
      <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19">
        <a href="<?php echo site_url('shop-golf-other'); ?>" class="nav-top-link">ショップ／ゴルフ／その他</a>
      </li> 
      <!-- <li class="header-newsletter-item has-icon">
        <a href="#header-newsletter-signup" class="tooltip tooltipstered">
          <i class="icon-envelop"></i>
          <span class="header-newsletter-title"> Newsletter </span>
        </a>
      </li> -->
      <li class="html header-social-icons ml-0">
        <div class="social-icons follow-icons ">
          <a href="http://url" target="_blank" data-label="Facebook" style="border-radius:0px" rel="nofollow" class="icon plain facebook tooltip tooltipstered">
            <i class="icon-facebook"></i>
          </a>
          <a href="http://url" target="_blank" rel="nofollow" data-label="Instagram" style="border-radius:0px" class="icon plain instagram tooltip tooltipstered">
            <i class="icon-instagram"></i>
          </a>
          <a href="http://url" target="_blank" data-label="Twitter" style="border-radius:0px" rel="nofollow" class="icon plain twitter tooltip tooltipstered">
            <i class="icon-twitter"></i>
          </a>
          <a href="mailto:your@email" target="_blank" data-label="E-mail" style="border-radius:0px" rel="nofollow" class="icon plain email tooltip tooltipstered">
            <i class="icon-envelop"></i>
          </a>
        </div>
      </li>
    </ul>
  </div>
  <!-- inner -->
</div>
<!-- #mobile-menu -->
<script type="text/javascript">
  jQuery(document).ready(function($) {
    var listItems = $('.tax-list ul li').get();
    listItems.sort(function(a, b) {
      return $(a).text().localeCompare($(b).text());
    });
    $('.tax-list ul').empty().append(listItems);
  });
</script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    // Tìm phần tử chứa đoạn địa chỉ và thay đổi nội dung
    $('.block-items .detail ul li').each(function() {
      var label = $(this).find('.add');
      if (label.length && $(this).text().includes("1) 34T Hoang Dao Thuy St., Cau Giay Dist., Ha Noi")) {
        var newText = "1) 34T Hoang Dao Thuy St., Cau Giay Dist., Ha Noi < br > 2) 235 Hoang Sa St., Dist.1, Ho Chi Minh ";
      $(this).html(' < label class = "add" > Address: < /label>' + newText);
      }
    });
  });
</script>
<script type="text/javascript" id="jquery-fancybox-js-after">
  /* 
			<![CDATA[ */
  var fb_timeout, fb_opts = {
    'overlayShow': true,
    'hideOnOverlayClick': true,
    'showCloseButton': true,
    'margin': 20,
    'centerOnScroll': false,
    'enableEscapeButton': true,
    'autoScale': true,
    'scriptPriority': 10
  };
  if (typeof easy_fancybox_handler === 'undefined') {
    var easy_fancybox_handler = function() {
      jQuery('.nofancybox,a.pin-it-button,a[href*="pinterest.com/pin/create"]').addClass('nolightbox');
      /* IMG */
      var fb_IMG_select = 'a[href*=".jpg"]:not(.nolightbox,li.nolightbox>a),area[href*=".jpg"]:not(.nolightbox),a[href*=".jpeg"]:not(.nolightbox,li.nolightbox>a),area[href*=".jpeg"]:not(.nolightbox),a[href*=".png"]:not(.nolightbox,li.nolightbox>a),area[href*=".png"]:not(.nolightbox),a[href*=".webp"]:not(.nolightbox,li.nolightbox>a),area[href*=".webp"]:not(.nolightbox)';
      jQuery(fb_IMG_select).addClass('fancybox image');
      var fb_IMG_sections = jQuery('div.gallery,div.wp-block-gallery,div.tiled-gallery');
      fb_IMG_sections.each(function() {
        jQuery(this).find(fb_IMG_select).attr('rel', 'gallery-' + fb_IMG_sections.index(this));
      });
      jQuery('a.fancybox,area.fancybox,li.fancybox a').each(function() {
        jQuery(this).fancybox(jQuery.extend({}, fb_opts, {
          'transitionIn': 'elastic',
          'easingIn': 'easeOutBack',
          'transitionOut': 'elastic',
          'easingOut': 'easeInBack',
          'opacity': false,
          'hideOnContentClick': false,
          'titleShow': true,
          'titlePosition': 'over',
          'titleFromAlt': true,
          'showNavArrows': true,
          'enableKeyboardNav': true,
          'cyclic': false
        }))
      });
    };
    jQuery('a.fancybox-close').on('click', function(e) {
      e.preventDefault();
      jQuery.fancybox.close()
    });
  };
  var easy_fancybox_auto = function() {
    setTimeout(function() {
      jQuery('#fancybox-auto').trigger('click')
    }, 1000);
  };
  jQuery(easy_fancybox_handler);
  jQuery(document).on('post-load', easy_fancybox_handler);
  jQuery(easy_fancybox_auto);
  /* ]]> */
</script>
<script type="text/javascript" id="liathia-js-js-extra">
  /* 
			<![CDATA[ */
  var liathiaVars = {
    "ajaxurl": "https:\/\/jcci-card.vn\/wp-admin\/admin-ajax.php",
    "rtl": "",
    "sticky_height": "70"
  };
  /* ]]> */
</script>