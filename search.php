<?php get_header(); ?>

<main id="primary" class="site-main container">
    <?php if (have_posts()) : ?>
        <header class="page-header search-header">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'lclookout'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            <div class="search-result-count">
                <?php
                global $wp_query;
                printf(
                    esc_html(_n(
                        'Found %d result',
                        'Found %d results',
                        $wp_query->found_posts,
                        'lclookout'
                    )),
                    $wp_query->found_posts
                );
                ?>
            </div>
            <?php get_search_form(); ?>
        </header>

        <div class="search-results-grid">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                    <header class="entry-header">
                        

                        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

                        <div class="entry-meta">
                            <span class="posted-on">
                                <?php echo get_the_date(); ?>
                            </span>
                            <span class="byline">
                                <?php the_author_posts_link(); ?>
                            </span>
                            <?php if (has_category()): ?>
                                <span class="categories">
                                    <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('Previous', 'lclookout'),
            'next_text' => __('Next', 'lclookout'),
        ));
        ?>

    <?php else : ?>
        <header class="page-header search-header">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'lclookout'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            <?php get_search_form(); ?>
        </header>

        <div class="no-results">
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'lclookout'); ?></p>
            
            <div class="search-suggestions">
                <h2><?php esc_html_e('Suggestions:', 'lclookout'); ?></h2>
                <ul>
                    <li><?php esc_html_e('Make sure all words are spelled correctly.', 'lclookout'); ?></li>
                    <li><?php esc_html_e('Try different keywords.', 'lclookout'); ?></li>
                    <li><?php esc_html_e('Try more general keywords.', 'lclookout'); ?></li>
                </ul>
            </div>

            <div class="browse-categories">
                <h2><?php esc_html_e('Browse Categories', 'lclookout'); ?></h2>
                <ul class="categories-list">
                    <?php
                    wp_list_categories(array(
                        'title_li' => '',
                        'show_count' => true,
                        'number' => 10
                    ));
                    ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?> 