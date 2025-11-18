<?php
/**
 * Template for displaying archive pages
 * Uses the same 3-column layout as the home page with sidebars
 */

get_header();
?>

<div id="primary" class="site-main home-layout container <?php 
    $has_left = is_active_sidebar('home-sidebar-left');
    $has_right = is_active_sidebar('home-sidebar-right');
    if ($has_left && $has_right) {
        echo 'has-both-sidebars';
    } elseif ($has_left) {
        echo 'has-left-sidebar';
    } elseif ($has_right) {
        echo 'has-right-sidebar';
    } else {
        echo 'no-sidebars';
    }
?>">
    
    <?php if (is_active_sidebar('home-sidebar-left')): ?>
        <aside id="home-left-sidebar" class="home-sidebar home-sidebar-left widget-area" role="complementary">
            <?php dynamic_sidebar('home-sidebar-left'); ?>
        </aside>
    <?php endif; ?>

    <main class="home-main-content">
        <?php if (have_posts()) : ?>
            <header class="archive-header">
                <?php
                the_archive_title('<h1 class="archive-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header>

            <div class="archive-posts-list">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('archive-post-item'); ?>>
                        <?php if (has_post_thumbnail()): ?>
                            <div class="archive-post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="archive-post-content">
                            <h2 class="archive-post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <div class="archive-post-meta">
                                <span class="posted-on">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <span class="byline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <?php the_author_posts_link(); ?>
                                </span>
                            </div>

                            <div class="archive-post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('&larr; Previous', 'lclookout'),
                'next_text' => __('Next &rarr;', 'lclookout'),
            ));
            ?>

        <?php else : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php esc_html_e('Nothing Found', 'lclookout'); ?></h1>
            </header>

            <div class="no-results">
                <p><?php esc_html_e('It seems we can\'t find what you\'re looking for.', 'lclookout'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </main>

    <?php if (is_active_sidebar('home-sidebar-right')): ?>
        <aside id="home-right-sidebar" class="home-sidebar home-sidebar-right widget-area" role="complementary">
            <?php dynamic_sidebar('home-sidebar-right'); ?>
        </aside>
    <?php endif; ?>

</div><!-- .home-layout -->

<?php get_footer(); ?> 