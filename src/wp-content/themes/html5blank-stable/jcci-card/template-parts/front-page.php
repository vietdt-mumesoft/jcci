<div id="content" class="content-area page-wrapper" role="main">
  
  <!-- Search Form -->
  <div class="row">
    <div class="large-10 col mx-auto">
      <div class="pc-search-form">
        <?php get_template_part('jcci-card/template-parts/parts/search-form'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-10 col mx-auto">
      <div class="row" id="row-849381800">
        <div class="col small-12 large-12">
          <div class="col-inner">
            <div class="row" id="row-1763829757">
              <div class="col block-banner small-12 large-12">
                <div class="col-inner">
                  <div class="banner has-hover" id="banner-1015555545">
                    <div class="banner-inner fill">
                      <div class="banner-bg fill">
                        <div class="bg fill bg-fill bg-loaded"></div>
                      </div>
                      <!-- bg-layers -->
                      <div class="banner-layers container">
                        <div class="fill banner-link"></div>
                        <div id="text-box-1103539507" class="text-box banner-layer x95 md-x95 lg-x95 y20 md-y15 lg-y15 res-text">
                          <div class="text dark">
                            <div class="text-inner text-left">
                              <div class="banner-text-right">
                                <p class="line1">JCCIカード割引店 ご案内</p>
                                <p class="line2">
                                  <b>賢く</b>使って、 <b>おトク</b>に暮らそう!!
                                </p>
                              </div>
                            </div>
                          </div>
                          <!-- text-box-inner -->
                          <style scope="scope">
                            #text-box-1103539507 {
                              width: 55%;
                            }

                            #text-box-1103539507 .text {
                              font-size: 100%;
                            }

                            @media (min-width:550px) {
                              #text-box-1103539507 {
                                width: 55%;
                              }
                            }
                          </style>
                        </div>
                        <!-- text-box -->
                        <div class="img has-hover x5 md-x5 lg-x5 y20 md-y10 lg-y10" id="image_212180105">
                          <div class="img-inner  dark">
                            <img src="<?php echo JCCI_CARD_URL; ?>/assets/img/card-before.png" alt="">
                          </div>
                          <style scope="scope">
                            #image_212180105 {
                              width: 30%;
                            }
                          </style>
                        </div>
                      </div>
                      <!-- .banner-layers -->
                    </div>
                    <!-- .banner-inner -->
                    <style scope="scope">
                      #banner-1015555545 {
                        padding-top: 160px;
                      }

                      #banner-1015555545 .bg.bg-loaded {
                        background-image: url(<?php echo JCCI_CARD_URL; ?>/assets/img/banner.png);
                      }

                      @media (min-width:550px) {
                        #banner-1015555545 {
                          padding-top: 400px;
                        }
                      }
                    </style>
                  </div>
                  <!-- .banner -->
                  <div class="box has-hover has-hover box-overlay dark box-text-middle">
                    <div class="box-image">
                      <div class="">
                        <img decoding="async" width="1669" height="220" src="<?php echo JCCI_CARD_URL; ?>/assets/img/bg-banner.png" 
                        class="attachment-original size-original" 
                        alt="" 
                        srcset="<?php echo JCCI_CARD_URL; ?>/assets/img/bg-banner.png 1669w, <?php echo JCCI_CARD_URL; ?>/assets/img/bg-banner.png 300w, <?php echo JCCI_CARD_URL; ?>/assets/img/bg-banner.png 768w, <?php echo JCCI_CARD_URL; ?>/assets/img/bg-banner.png 1024w" sizes="(max-width: 1669px) 100vw, 1669px">
                        <div class="overlay" style="background-color:1"></div>
                      </div>
                    </div>
                    <!-- box-image -->
                    <div class="box-text text-center dark">
                      <div class="box-text-inner">
                        <p>割引店の検索はこちらから</p>
                      </div>
                      <!-- box-text-inner -->
                    </div>
                    <!-- box-text -->
                  </div>
                  <!-- .box  -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <style scope="scope"></style>
      </div>
      <p>
        <!-- /wp:shortcode -->
      </p>
      <p>
        <!-- wp:shortcode -->
      </p>
      <section class="section" id="section_330532135">
        <div class="bg section-bg fill bg-fill bg-loaded bg-loaded"></div>
        <!-- .section-bg -->
        <div class="section-content relative">
          <div class="row" id="row-1144763685">
            <div class="col medium-4 small-4 large-4">
              <div class="col-inner">
                <div class="block-service blue">
                  <div class="title">
                    <h3>レストラン</h3>
                  </div>
                  <div class="sub-title">
                    <span>ジャンルから探す</span>
                  </div>
                  <div class="list-service">
                    <span class="btn-arrow"></span>
                    <ul>
                      <?php
                        // Get all cuisine taxonomy terms
                        $cuisine_terms = get_terms(array(
                          'taxonomy' => 'cuisine',
                          'hide_empty' => false,
                          'meta_key' => 'display_order',
                          'orderby' => 'meta_value_num',
                          'order' => 'ASC',
                        ));
                        
                        // Loop through each cuisine term and display it
                        if (!empty($cuisine_terms) && !is_wp_error($cuisine_terms)) {
                          foreach ($cuisine_terms as $term) {
                            echo '<li>';
                            echo '<a href="' . esc_url(get_term_link($term)) . '" title="' . esc_attr($term->name) . '" alt="' . esc_attr($term->name) . '">' . esc_html($term->name) . '</a>';
                            echo '</li>';
                          }
                        } else {
                          echo '<li>No cuisine found</li>';
                        }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col medium-4 small-4 large-4">
              <div class="col-inner">
                <div class="block-service brown">
                  <div class="title">
                    <h3>ホテル <br> アパート </h3>
                  </div>
                  <div class="sub-title">
                    <span>エリアから探す</span>
                  </div>
                  <div class="list-service">
                    <span class="btn-arrow"></span>
                    <ul>
                      <?php
                        // Get all place taxonomy terms
                        $place_terms = get_terms(array(
                          'taxonomy' => 'place',
                          'hide_empty' => false,
                          'meta_key' => 'display_order',
                          'orderby' => 'meta_value_num',
                          'order' => 'ASC',
                        ));
                        
                        // Loop through each place term and display it
                        if (!empty($place_terms) && !is_wp_error($place_terms)) {
                          foreach ($place_terms as $term) {
                            echo '<li>';
                            echo '<a href="' . esc_url(get_term_link($term)) . '" title="' . esc_attr($term->name) . '" alt="' . esc_attr($term->name) . '">' . esc_html($term->name) . '</a>';
                            echo '</li>';
                          }
                        } else {
                          echo '<li>No locations found</li>';
                        }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col medium-4 small-4 large-4">
              <div class="col-inner">
                <div class="block-service green">
                  <div class="title">
                    <h3>ショップ <br> ゴルフ <br> その他 </h3>
                  </div>
                  <div class="sub-title">
                    <span>ジャンルから探す <br>
                    </span>
                  </div>
                  <div class="list-service">
                    <span class="btn-arrow"></span>
                    <ul>
                      <?php
                      // Get all store taxonomy terms
                      $store_terms = get_terms(array(
                        'taxonomy' => 'store',
                        'hide_empty' => false,
                        'meta_key' => 'display_order',
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                      ));
                      
                      // Loop through each store term and display it
                      if (!empty($store_terms) && !is_wp_error($store_terms)) {
                        foreach ($store_terms as $term) {
                          echo '<li>';
                          echo '<a href="' . esc_url(get_term_link($term)) . '" title="' . esc_attr($term->name) . '" alt="' . esc_attr($term->name) . '">' . esc_html($term->name) . '</a>';
                          echo '</li>';
                        }
                      } else {
                        echo '<li>No store categories found</li>';
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- .section-content -->
        <style scope="scope">
          #section_330532135 {
            padding-top: 30px;
            padding-bottom: 30px;
          }
        </style>
      </section>
      <p>
        <!-- /wp:shortcode -->
      </p>
      <p>
        <!-- wp:shortcode -->
      </p>
      <section class="section block-home-news" id="section_1141077922">
        <div class="bg section-bg fill bg-fill bg-loaded"></div>
        <!-- .section-bg -->
        <div class="section-content relative">
          <div class="row row-large" id="row-1992804994">
            <div class="col small-12 large-12">
              <div class="col-inner">
                <div class="container section-title-container">
                  <h3 class="section-title section-title-normal">
                    <b></b>
                    <span class="section-title-main">JCCI カードについて</span>
                    <b></b>
                  </h3>
                </div>
                <!-- .section-title -->
                <div class="row row-collapse align-middle" id="row-1682729431">
                  <div class="col hide-for-small medium-6 small-12 large-6">
                    <div class="col-inner text-left" style="padding:0px 10px 0px 50px;">
                      <p>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">JCCI 会員企業の従業員およびご家族の皆様への福利厚生のサポートとして、JCCI カードを発行し</span>
                        </strong>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">ております。このカードを加盟店で提示していただくと、各種割引や優待を受けることができます。 <br> 【申込対象者】JCCI会員企業の日本人社員とその配偶者。 </span>
                        </strong>
                      </p>
                      <p>Googleの申請フォームは <a class="btn-download fix-space-x" href="https://goo.gl/dMPdJ6">
                          <b>こちら</b>
                        </a>です。 </p>
                    </div>
                  </div>
                  <div class="col show-for-small medium-6 small-12 large-6">
                    <div class="col-inner">
                      <p>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">JCCI 会員企業の従業員およびご家族の皆様への福利厚生のサポートとして、JCCI カードを発行し</span>
                        </strong>
                        <br>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">ております。このカードを加盟店で提示していただくと、各種割引や優待を受けることができます。</span>
                        </strong>
                      </p>
                    </div>
                  </div>
                  <div class="col medium-6 small-12 large-6">
                    <div class="col-inner">
                      <div class="row row-small" id="row-1026737212">
                        <div class="col medium-6 small-6 large-6">
                          <div class="col-inner">
                            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_447396531">
                              <div class="img-inner  dark">
                                <img src="<?php echo JCCI_CARD_URL; ?>/assets/img/card-before.png" alt="">
                              </div>
                              <style scope="scope">
                                #image_447396531 {
                                  width: 100%;
                                }
                              </style>
                            </div>
                          </div>
                        </div>
                        <div class="col medium-6 small-6 large-6">
                          <div class="col-inner">
                            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_837315763">
                              <div class="img-inner  dark">
                                <img src="<?php echo JCCI_CARD_URL; ?>/assets/img/card-after.png" alt="">
                              </div>
                              <style scope="scope">
                                #image_837315763 {
                                  width: 100%;
                                }
                              </style>
                            </div>
                          </div>
                        </div>
                        <style scope="scope"></style>
                      </div>
                    </div>
                  </div>
                  <style scope="scope"></style>
                </div>
                <div class="row" id="row-1823004377">
                  <div class="col small-12 large-12">
                    <div class="col-inner">
                      <div class="row" id="row-361123490">
                        <div class="col medium-6 small-12 large-6">
                          <div class="col-inner">
                            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1734221634">
                              <div class="img-inner  dark" style="margin:30px 0px 0px 0px;">
                                <img loading="lazy" decoding="async" width="437" height="359" src="<?php echo JCCI_CARD_URL; ?>/assets/img/card-1-1.png" class="attachment-large size-large" alt="" srcset="<?php echo JCCI_CARD_URL; ?>/assets/img/card-1-1.png 437w, <?php echo JCCI_CARD_URL; ?>/assets/img/card-1-1-300x246.png 300w" sizes="(max-width: 437px) 100vw, 437px">
                              </div>
                              <style scope="scope">
                                #image_1734221634 {
                                  width: 100%;
                                }
                              </style>
                            </div>
                          </div>
                        </div>
                        <div class="col medium-6 small-12 large-6">
                          <div class="col-inner" style="margin:30px 0px 0px 0px;">
                            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_690734443">
                              <div class="img-inner  dark">
                                <img loading="lazy" decoding="async" width="502" height="412" src="<?php echo JCCI_CARD_URL; ?>/assets/img/card-2.png" class="attachment-large size-large" alt="" srcset="<?php echo JCCI_CARD_URL; ?>/assets/img/card-2.png 502w, <?php echo JCCI_CARD_URL; ?>/assets/img/card-2-300x246.png 300w" sizes="(max-width: 502px) 100vw, 502px">
                              </div>
                              <style scope="scope">
                                #image_690734443 {
                                  width: 100%;
                                }
                              </style>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col small-12 large-12">
              <div class="col-inner">
                <div class="container section-title-container">
                  <h3 class="section-title section-title-normal">
                    <b></b>
                    <span class="section-title-main">加盟店を紹介してください</span>
                    <b></b>
                  </h3>
                </div>
                <!-- .section-title -->
                <div class="row row-collapse" id="row-393293557">
                  <div class="col hide-for-small small-12 large-12">
                    <div class="col-inner" style="padding:0px 0 0px 60px;">
                      <p>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">JCCI では現在加盟店を募集しています。参加希望店舗の方はこちらの申込書にてお申し込みくださ</span>
                        </strong>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">い。会員の皆様におかれましては、お気に入りの未加盟店があれば、こちらのご案内をお渡しください。</span>
                        </strong>
                      </p>
                      <p>
                        <i class="fas fa-angle-double-right"></i>
                        <a href="<?php echo JCCI_CARD_URL; ?>/assets/file/20250610_JCCICard_Agreement.docx">
                          <b>加盟店申込書</b>
                        </a>
                      </p>
                    </div>
                  </div>
                  <div class="col show-for-small small-12 large-12">
                    <div class="col-inner">
                      <p>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">JCCI では現在加盟店を募集しています。参加希望店舗の方はこちらの申込書にてお申し込みくださ</span>
                        </strong>
                        <strong class="fix-space">
                          <span style="font-size: 95%;">い。会員の皆様におかれましては、お気に入りの未加盟店があれば、こちらのご案内をお渡しください。</span>
                        </strong>
                      </p>
                      <p>
                        <i class="fas fa-angle-double-right"></i>
                        <a class="fix-space-x" href="<?php echo JCCI_CARD_URL; ?>/assets/file/agreement_for_jcci_discount_card_EN-Ver2.docx">
                          <b>加盟店申込書</b>
                        </a>
                      </p>
                    </div>
                  </div>
                  <style scope="scope"></style>
                </div>
              </div>
            </div>
            <div class="col small-12 large-12">
              <div class="col-inner">
                <div class="container section-title-container">
                  <h3 class="section-title section-title-normal">
                    <b></b>
                    <span class="section-title-main">こんなときは・・・</span>
                    <b></b>
                  </h3>
                </div>
                <!-- .section-title -->
                <div class="row row-collapse" id="row-2031702994">
                  <div class="col show-for-small small-12 large-12">
                    <div class="col-inner">
                      <p>
                        <span style="font-size: 95%;">
                          <strong class="fix-space">
                            <span style="color: #ed1c24;">カードの紛失</span>
                          </strong>
                          <span style="color: #1f5994;">
                            <strong>→JCCI 会員企業のご担当者様より JCCI 事務局までご連絡ください。</strong>
                          </span>
                        </span>
                      </p>
                      <p>
                        <span style="font-size: 95%;">
                          <span style="color: #ed1c24;">
                            <strong>優待サービスを加盟店従業員が知らない、もしくは拒否された</strong>
                          </span>
                          <strong class="fix-space-x">
                            <span style="color: #1f5994;">→ 各店舗の担当者へ連絡してください。</span>
                          </strong>
                          <strong class="fix-space">
                            <span style="color: #1f5994;">担当者情報は、各店舗の情報欄に掲載しています。）</span>
                          </strong>
                        </span>
                      </p>
                      <p>
                        <span style="font-size: 95%;">
                          <strong>なお、閉店等により割引が予告なく終了する場合もありますので、悪しからずご了承ください。 <br>
                          </strong>
                        </span>
                      </p>
                      <div class="font-claude-messagepr-4md:pr-9relativeleading-[1.65rem][&amp;_pre>div]:bg-bg-300[&amp;_pre]:-mr-4md:[&amp;_pre]:-mr-9" style="box-sizing: border-box; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: hsl(var(--accent-secondary-100)/1); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; outline-color: hsl(var(--accent-main-100)); position: relative; padding-right: 2.25rem; line-height: 1.65rem; font-family: var(--font-claude-message); color: #29261b; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: -0.24px; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: #f0eee5; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; border: 0px solid hsl(var(--border-100));">
                        <div>
                          <div class="grid-col-1 grid gap-2.5 [&amp;_>_*]:min-w-0" style="box-sizing: border-box; border-image: initial; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: hsl(var(--accent-secondary-100)/1); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; outline-color: hsl(var(--accent-main-100)); display: grid; gap: 0.625rem; border: 0px solid hsl(var(--border-100));">
                            <p class="whitespace-pre-wrap break-words"></p>
                          </div>
                        </div>
                      </div>
                      <div class="absolute -bottom-0 -right-1.5 sm:right-2">
                        <div class="border-0.5 border-border-300 flex items-center translate-y-1/2 rounded-lg px-2 pb-1 pt-3 shadow-sm transition bg-bg-000">
                          <div class="text-text-400 -mx-1 -mt-2 flex items-stretch justify-between gap-0.5">
                            <div class="flex gap-0.5"></div>
                          </div>
                        </div>
                      </div>
                      <p>
                        <span style="font-size: 95%;">
                          <strong>&nbsp;</strong>
                        </span>
                      </p>
                    </div>
                  </div>
                  <div class="col hide-for-small small-12 large-12">
                    <div class="col-inner" style="padding:0px 0 0px 60px;">
                      <p>
                        <span style="font-size: 95%;">
                          <strong>
                            <span style="color: #ed1c24;">カードの紛失</span>
                          </strong>
                          <span style="color: #1f5994;">
                            <strong>→JCCI 会員企業のご担当者様より JCCI 事務局までご連絡ください。</strong>
                          </span>
                        </span>
                      </p>
                      <p>
                        <span style="font-size: 95%;">
                          <span style="color: #ed1c24;">
                            <strong>優待サービスを加盟店従業員が知らない、もしくは拒否された</strong>
                          </span>
                          <strong class="fix-space">
                            <span style="color: #1f5994;">→ Webサイトで店舗の担当者を確認の上、まずは、直接担当者にご連絡ください。</span>
                          </strong>
                          <strong>
                            <span style="color: #1f5994;">(担当者情報は、各店舗の情報欄に掲載しています。）</span>
                          </strong>
                        </span>
                      </p>
                      <p>
                        <span style="font-size: 95%;">
                          <strong>なお、閉店等により割引が予告なく終了する場合もありますので、悪しからずご了承ください。</strong>
                        </span>
                      </p>
                    </div>
                  </div>
                  <style scope="scope"></style>
                </div>
              </div>
            </div>
            <style scope="scope"></style>
          </div>
        </div>
        <!-- .section-content -->
        <style scope="scope">
          #section_1141077922 {
            padding-top: 30px;
            padding-bottom: 30px;
          }

          #section_1141077922 .section-bg.bg-loaded {
            background-image: url(<?php echo JCCI_CARD_URL; ?>/assets/img/bg-home.png);
          }
        </style>
      </section>
      <p>
        <!-- /wp:shortcode -->
      </p>
    </div>
    <!-- .large-12 -->
  </div>
  <!-- .row -->
</div>
