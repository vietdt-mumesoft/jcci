            <footer class="page-footer font-small footer"　role="contentinfo">
                <div class="footer--contact">
                    <?php get_template_part( 'template-parts/footer-contact' ); ?>
                </div>
                <div class="footer--menu">
                    <div class="container">
                        <?php jcci_custom_footer_menu('footer-menu'); ?>
                    </div>
                    <div id="back-to-top">
                        <div class="back-to-top-inner">
                            <i class="zmdi zmdi-format-valign-top"></i>
                        </div>
                    </div>
                </div>

              <div class="footer-copyright text-center py-3">Copyright &copy; <?php echo date('Y'); ?>
                <strong><a href="http://jcci.vn">JCCI</a></strong>. All Rights Reserved.
              </div>
            </footer>
            <!-- Footer -->

        </div><!-- End .wrapper -->

        <?php wp_footer(); ?>

        <?php $jcci_option = jcci_get_global_options(); ?>
        <?php if ($jcci_option['jcci_google_analytic_input']) { ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $jcci_option['jcci_google_analytic_input']; ?>"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', '<?php echo $jcci_option['jcci_google_analytic_input']; ?>');
            </script>
        <?php } ?>

    </body>
</html>
