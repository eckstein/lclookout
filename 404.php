<?php get_header(); ?>

<main id="primary" class="site-main container">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e('Oops! Page Not Found', 'lclookout'); ?></h1>
        </header>

        <div class="page-content">
            <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'lclookout'); ?></p>

            <div class="error-search">
                <?php get_search_form(); ?>
            </div>

            <div class="error-help">
                <div class="recent-posts">
                    <h2><?php esc_html_e('Recent Posts', 'lclookout'); ?></h2>
                    <ul>
                        <?php
                        wp_get_archives(array(
                            'type'     => 'postbypost',
                            'limit'    => 5,
                            'format'   => 'html'
                        ));
                        ?>
                    </ul>
                </div>

                <div class="categories">
                    <h2><?php esc_html_e('Most Used Categories', 'lclookout'); ?></h2>
                    <ul>
                        <?php
                        wp_list_categories(array(
                            'orderby'    => 'count',
                            'order'      => 'DESC',
                            'show_count' => true,
                            'title_li'   => '',
                            'number'     => 5,
                        ));
                        ?>
                    </ul>
                </div>

                <div class="archives">
                    <h2><?php esc_html_e('Monthly Archives', 'lclookout'); ?></h2>
                    <ul>
                        <?php
                        wp_get_archives(array(
                            'type'      => 'monthly',
                            'limit'     => 5,
                            'show_post_count' => true,
                        ));
                        ?>
                    </ul>
                </div>
            </div>

            <div class="back-home">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
                    <?php esc_html_e('Back to Homepage', 'lclookout'); ?>
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?> 