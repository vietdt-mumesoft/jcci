<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php wp_title(''); ?></title>

        <link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/touch.png" rel="apple-touch-icon-precomposed">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php bloginfo('description'); ?>">

        <?php wp_head(); ?>
        <script>
            G_CURRENT_LANGUAGE = '<?php echo pll_current_language() ?>';
        </script>
        <?php $jcci_option = jcci_get_global_options(); ?>

    </head>
    <body <?php body_class(); ?>>
        <div class="wrapper">
            <header class="header site-header">
                <div class="header--top p-2">
                    <div class="container">
                        <div class="d-flex justify-content-between">
                            <div class="header--top-left">
                                <?php jcci_getLanguages(); ?>
                            </div>
                            <div class="py-2 header--top-right">
                                <span class="total--members">
                                <?php if (function_exists('pll_current_language')) {
                                    if (pll_current_language() == 'vi') { ?>
                                        Số hội viên hiện tại: <span class="total--users"><?= $jcci_option['jcci_total_member_input'] ?></span>
                                    <?php } else if (pll_current_language() == 'en') { ?>
                                        Total members: <span class="total--users"><?= $jcci_option['jcci_total_member_input'] ?></span>
                                    <?php } else { ?>
                                        <?= date('n') ?>月の会員数 <span class="total--users"><?= $jcci_option['jcci_total_member_input'] ?></span> 社
                                    <?php }
                                } else { ?>
                                    <?= date('n') ?>月の会員数 <span class="total--users"><?= $jcci_option['jcci_total_member_input'] ?></span> 社
                                <?php } ?>
                                </span>
                                <span class="hello-member">
                                <?php if (is_user_logged_in()) { ?>
                                     <span><?= jcci_translate_text('こんにちは') ?> <?= esc_html( wp_get_current_user()->display_name ) ?></span>
                                    <a class="btn btn-secondary" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php echo jcci_translate_text('ログアウト') ?></a>
                                <?php } ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header--logo text-center py-2 mb-5 d-none d-md-block">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-top.png" alt="JCCI Logo">
                    </a>
                </div>
                <div class="header--nav">
                    <nav class="p-0 navbar navbar-expand-md bg-dark navbar-dark">
                      <a class="navbar-brand" href="<?php echo home_url(); ?>">
                        <img width="220" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-top.png" alt="JCCI Logo">
                      </a>

                      <button class="navbar-toggler menu-trigger" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <!-- <span class="navbar-toggler-icon"></span> -->
                        <span></span><span></span><span></span>
                      </button>
                      <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
                        <?php jcci_custom_menu('header-menu'); ?>
                      </div>
                    </nav>
                </div>
            </header><!-- End .header -->
