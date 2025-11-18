<?php
/**
 * Template for displaying the home page
 * Professional newspaper layout with featured post and sidebars
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
        <?php
        // Check if main category is set
        $main_category_id = get_option('lclookout_main_category', 0);
        
        if (!$main_category_id) {
            // Display warning if no category is set
            ?>
            <div class="home-category-warning">
                <h2><?php esc_html_e('Home Page Not Configured', 'lclookout'); ?></h2>
                <p><?php esc_html_e('Please select a Main Home Page Category in Settings → Reading to display posts on the home page.', 'lclookout'); ?></p>
                <?php if (current_user_can('manage_options')): ?>
                    <a href="<?php echo esc_url(admin_url('options-reading.php')); ?>" class="button-link">
                        <?php esc_html_e('Go to Reading Settings', 'lclookout'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php
        } else {
            // Get sticky posts first
            $sticky = get_option('sticky_posts');
            $featured_args = array(
                'posts_per_page'      => 1,
                'post__in'            => $sticky,
                'ignore_sticky_posts' => 1,
                'cat'                 => $main_category_id,
            );
            
            // If there are no sticky posts, just get the latest post
            if (empty($sticky)) {
                $featured_args = array(
                    'posts_per_page' => 1,
                    'cat'            => $main_category_id,
                );
            }
            
            $featured_query = new WP_Query($featured_args);
        
        if ($featured_query->have_posts()): ?>
            <div class="featured-post-section">
                
                <?php while ($featured_query->have_posts()): $featured_query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('featured-post'); ?>>
                        <?php if (has_post_thumbnail()): ?>
                            <div class="featured-post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="featured-post-content">
                            <?php 
                            $filtered_categories = lclookout_get_filtered_categories();
                            if (!empty($filtered_categories)): ?>
                                <div class="featured-post-category">
                                    <?php lclookout_the_category(' '); ?>
                                </div>
                            <?php endif; ?>
                            
                            <h2 class="featured-post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="featured-post-meta">
                                <span class="posted-on">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <span class="byline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <?php the_author_posts_link(); ?>
                                </span>
                            </div>
                            
                            <div class="featured-post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
        
        <!-- Latest Posts Feed -->
        <div class="latest-posts-section">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e('Latest News', 'lclookout'); ?></h2>
            </div>
            
            <?php
            // Get posts excluding the featured one
            $posts_args = array(
                'posts_per_page' => get_option('posts_per_page'),
                'cat'            => $main_category_id,
                // No pagination on home page - only show first page
            );
            
            // Exclude the featured post if it exists
            if ($featured_query->have_posts()) {
                $featured_query->rewind_posts();
                $featured_query->the_post();
                $posts_args['post__not_in'] = array(get_the_ID());
                wp_reset_postdata();
            }
            
            $posts_query = new WP_Query($posts_args);
            
            if ($posts_query->have_posts()): ?>
                <div class="posts-grid">
                    <?php while ($posts_query->have_posts()): $posts_query->the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                            <a href="<?php the_permalink(); ?>" class="post-item-link">
                                <div class="post-item-thumbnail">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="post-item-title">
                                    <?php the_title(); ?>
                                </h3>
                                
                                <div class="post-item-meta">
                                    By <?php the_author(); ?> on <?php echo get_the_date(); ?>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
                
            <?php else: ?>
                <p><?php esc_html_e('No posts found.', 'lclookout'); ?></p>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        </div>
        <?php } // End else - category is set ?>
    </main>

    <?php if (is_active_sidebar('home-sidebar-right')): ?>
        <aside id="home-right-sidebar" class="home-sidebar home-sidebar-right widget-area" role="complementary">
            <?php dynamic_sidebar('home-sidebar-right'); ?>
        </aside>
    <?php endif; ?>

</div><!-- .home-layout -->

<?php get_footer(); ?>
