<?php get_header(); ?>

<main id="primary" class="site-main container has-sidebar">
    <?php if (have_posts()): ?>
        <div class="content-area">
            <?php
            while (have_posts()): the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>

                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

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
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php esc_html_e('Read More', 'lclookout'); ?>
                        </a>
                    </div>
                </article>
            <?php endwhile;

            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Previous', 'lclookout'),
                'next_text' => __('Next', 'lclookout'),
            ));
        ?>
        </div><!-- .content-area -->

        <?php get_sidebar(); ?>

    <?php else: ?>
        <p><?php esc_html_e('No posts found.', 'lclookout'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?> 