<?php get_header(); ?>

<main id="primary" class="site-main container">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            <script type="application/ld+json">
                <?php echo lclookout_get_schema_article(); ?>
            </script>
            <header class="entry-header">
                <?php if (has_post_thumbnail()): ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-meta-top">
                    <?php
                    $categories = lclookout_get_filtered_categories();
                    if (!empty($categories)) {
                        echo '<div class="post-categories">';
                        foreach ($categories as $category) {
                            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>

                <h1 class="entry-title"><?php the_title(); ?></h1>

                <div class="entry-meta">
                    <span class="posted-on">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <?php echo get_the_date(); ?>
                    </span>
                    <span class="byline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <?php the_author_posts_link(); ?>
                    </span>
                </div>
            </header>

            <div class="entry-content">
                <?php 
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'lclookout'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                $tags = get_the_tags();
                if ($tags) {
                    echo '<div class="post-tags">';
                    foreach ($tags as $tag) {
                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a>';
                    }
                    echo '</div>';
                }
                ?>

                <div class="post-navigation">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ($prev_post): ?>
                        <div class="nav-previous">
                            <span class="nav-subtitle"><?php esc_html_e('Previous Post', 'lclookout'); ?></span>
                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                <?php echo esc_html($prev_post->post_title); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($next_post): ?>
                        <div class="nav-next">
                            <span class="nav-subtitle"><?php esc_html_e('Next Post', 'lclookout'); ?></span>
                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                <?php echo esc_html($next_post->post_title); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </footer>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?> 