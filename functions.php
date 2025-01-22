<?php
/**
 * Lewis County Lookout functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme constants
define('LCLOOKOUT_VERSION', '1.0.0');
define('LCLOOKOUT_DIR', get_template_directory());
define('LCLOOKOUT_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function lclookout_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Register nav menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'lclookout'),
        'footer' => esc_html__('Footer Menu', 'lclookout'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'lclookout_setup');

/**
 * Register widget areas
 */
function lclookout_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Homepage Sidebar', 'lclookout'),
        'id'            => 'homepage-sidebar',
        'description'   => esc_html__('Add widgets to the homepage sidebar.', 'lclookout'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 1', 'lclookout'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'lclookout'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 2', 'lclookout'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here.', 'lclookout'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area 3', 'lclookout'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here.', 'lclookout'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'lclookout_widgets_init');

/**
 * Enqueue scripts and styles
 */
function lclookout_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('lclookout-fonts', 'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Source+Sans+Pro:wght@400;600&display=swap', array(), null);

    // Theme stylesheet
    wp_enqueue_style('lclookout-style', get_stylesheet_uri(), array('lclookout-fonts'), filemtime(get_stylesheet_directory() . '/style.css'));

    // Navigation Script
    wp_enqueue_script('lclookout-navigation', get_template_directory_uri() . '/js/navigation.js', array(), filemtime(get_template_directory() . '/js/navigation.js'), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'lclookout_scripts');

// Modify search query to only show published posts
function lclookout_search_filter($query) {
    if (!is_admin() && $query->is_search && $query->is_main_query()) {
        $query->set('post_type', 'post');
        $query->set('post_status', 'publish');
    }
    return $query;
}
add_filter('pre_get_posts', 'lclookout_search_filter');

// Include additional functionality
require_once LCLOOKOUT_DIR . '/inc/template-functions.php';
require_once LCLOOKOUT_DIR . '/inc/customizer.php';

/**
 * Custom Sticky Posts Widget
 */
class LCLOOKOUT_Sticky_Posts_Widget extends WP_Widget {
    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct(
            'lclookout_sticky_posts',
            esc_html__('LC Lookout Sticky Posts', 'lclookout'),
            array('description' => esc_html__('Displays sticky posts in a sidebar.', 'lclookout'))
        );
    }

    /**
     * Front-end display of widget
     *
     * @param array $args     Widget arguments
     * @param array $instance Saved values from database
     */
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Featured Posts', 'lclookout');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;

        $sticky = get_option('sticky_posts');
        
        if (!empty($sticky)) {
            $query = new WP_Query(array(
                'posts_per_page' => $number,
                'post__in' => $sticky,
                'ignore_sticky_posts' => 1
            ));

            if ($query->have_posts()) {
                echo $args['before_widget'];
                echo $args['before_title'] . esc_html($title) . $args['after_title'];
                
                echo '<ul class="sticky-posts-list">';
                while ($query->have_posts()) {
                    $query->the_post();
                    echo '<li class="sticky-post-item">';
                    if (has_post_thumbnail()) {
                        echo '<a href="' . esc_url(get_permalink()) . '" class="sticky-post-thumbnail">';
                        the_post_thumbnail('thumbnail');
                        echo '</a>';
                    }
                    echo '<div class="sticky-post-content">';
                    echo '<h3 class="sticky-post-title"><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h3>';
                    echo '<span class="sticky-post-date">' . get_the_date() . '</span>';
                    echo '</div>';
                    echo '</li>';
                }
                echo '</ul>';
                
                echo $args['after_widget'];
            }
            wp_reset_postdata();
        }
    }

    /**
     * Back-end widget form
     *
     * @param array $instance Previously saved values from database
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Featured Posts', 'lclookout');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'lclookout'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of posts to show:', 'lclookout'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved
     *
     * @param array $new_instance Values just sent to be saved
     * @param array $old_instance Previously saved values from database
     * @return array Updated safe values to be saved
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

// Register the sticky posts widget
function lclookout_register_sticky_posts_widget() {
    register_widget('LCLOOKOUT_Sticky_Posts_Widget');
}
add_action('widgets_init', 'lclookout_register_sticky_posts_widget');
