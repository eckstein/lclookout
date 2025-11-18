<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <script type="application/ld+json">
        <?php echo lclookout_get_schema_website(); ?>
    </script>
    <script type="application/ld+json">
        <?php echo lclookout_get_schema_organization(); ?>
    </script>
</head>

<body <?php body_class(); ?>> 
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e('Skip to content', 'lclookout'); ?>
    </a>

    <header id="masthead" class="site-header<?php echo get_theme_mod('sticky_header_enabled', false) ? ' sticky-enabled' : ''; ?>">
        <div id="site-header-ribbon">
            <div class="ribbon-inner container">
                <!-- Main Menu for Desktop -->
                <nav id="site-navigation" class="main-navigation desktop-only">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ));
                    ?>
                </nav>

                <!-- Social Icons for Desktop -->
                <nav class="social-icons-menu desktop-only">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'social-icons',
                        'menu_id'        => 'social-icons',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ));
                    ?>
                </nav>

                <!-- Mobile Hamburger Menu Toggle -->
                <button class="menu-toggle mobile-only" aria-controls="mobile-combined-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'lclookout'); ?></span>
                    <i class="fas fa-bars menu-icon-open"></i>
                    <i class="fas fa-times menu-icon-close"></i>
                </button>

                <!-- Combined Mobile Menu Container -->
                <div id="mobile-combined-menu" class="mobile-menu-container mobile-only">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </div>
        <div class="header-inner container">

            <div class="site-branding">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
                <?php if (get_bloginfo('description')): ?>
                    <p class="site-description"><?php bloginfo('description'); ?></p>
                <?php endif; ?>
            </div>

            <div class="header-search">
                <button type="button" class="search-toggle" aria-expanded="false" aria-controls="header-search-form">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span class="screen-reader-text"><?php esc_html_e('Toggle Search', 'lclookout'); ?></span>
                </button>
                <form role="search" method="get" class="search-form" id="header-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-form-inner">
                        <label>
                            <span class="screen-reader-text"><?php esc_html_e('Search for:', 'lclookout'); ?></span>
                            <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search...', 'lclookout'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                        </label>
                        <button type="submit" class="search-submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <span class="screen-reader-text"><?php esc_html_e('Search', 'lclookout'); ?></span>
                        </button>
                        <input type="hidden" name="post_type" value="post" />
                    </div>
                </form>
            </div>
            <div class="header-today-date">
                <?php echo date('F j, Y'); ?>
            </div>
            
        </div>
        <div class="main-cat-menu-wrapper desktop-only">
            <?php wp_nav_menu(array(
                'theme_location' => 'main-cat-menu',
                'menu_id'        => 'main-cat-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            )); ?>
        </div>

        <!-- Hidden menu sources for mobile JavaScript to clone from -->
        <div class="mobile-menu-sources" style="display: none;">
            <?php 
            // Category menu clone source
            wp_nav_menu(array(
                'theme_location' => 'main-cat-menu',
                'menu_id'        => 'mobile-cat-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            )); 
            
            // Primary menu clone source
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'mobile-primary-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ));
            
            // Social icons clone source
            wp_nav_menu(array(
                'theme_location' => 'social-icons',
                'menu_id'        => 'mobile-social-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ));
            ?>
        </div>
    </header>

    <div id="content" class="site-content"> 