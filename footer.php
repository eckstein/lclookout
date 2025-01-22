    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-widgets container">
            <div class="footer-widget-area">
                <?php if (is_active_sidebar('footer-1')): ?>
                    <div class="footer-widget footer-1">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')): ?>
                    <div class="footer-widget footer-2">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')): ?>
                    <div class="footer-widget footer-3">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="site-info container">
            <div class="copyright">
                © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                <?php esc_html_e('All rights reserved.', 'lclookout'); ?>
            </div>

            <?php if (has_nav_menu('footer')): ?>
                <nav class="footer-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html> 