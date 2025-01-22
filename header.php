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
        <div class="header-inner container">
            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'lclookout'); ?></span>
                    <span class="menu-icon"></span>
                </button>
                <div class="primary-menu-container">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ));
                    ?>
                </div>
            </nav>

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
        </div>
    </header>

    <div id="content" class="site-content"> 