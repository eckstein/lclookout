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
        'name'          => esc_html__('Main Sidebar', 'lclookout'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'lclookout'),
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
 * Customize WordPress Login Page
 */
function lclookout_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

    if ($logo) {
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo esc_url($logo[0]); ?>);
                background-position: center;
                background-size: contain;
                background-repeat: no-repeat;
                width: 300px;
                height: 80px;
                padding-bottom: 0;
            }
            body.login {
                background: var(--light-gray);
            }
            body.login div#login {
                padding: 8% 0;
            }
            .login form {
                border-radius: 4px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            }
            .login form .input {
                border-radius: 4px;
                border-color: var(--medium-gray);
                padding: 10px 12px;
                font-size: 16px;
            }
            .login form .input:focus {
                border-color: var(--primary-blue);
                box-shadow: 0 0 0 1px var(--primary-blue);
            }
            .wp-core-ui .button-primary {
                background: var(--primary-blue);
                border-color: var(--primary-blue);
                color: var(--white);
                text-decoration: none;
                text-shadow: none;
                border-radius: 4px;
                padding: 0 24px;
                height: 40px;
                line-height: 38px;
                font-size: 14px;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .wp-core-ui .button-primary:hover,
            .wp-core-ui .button-primary:focus {
                background: var(--primary-blue-dark);
                border-color: var(--primary-blue-dark);
                color: var(--white);
            }
            .login #backtoblog a, 
            .login #nav a {
                color: var(--text-dark);
                transition: color 0.3s ease;
            }
            .login #backtoblog a:hover, 
            .login #nav a:hover {
                color: var(--primary-blue);
            }
            .login .message,
            .login .success {
                border-left-color: var(--primary-blue);
            }
            .login #login_error,
            .login .error {
                border-left-color: var(--accent-red);
            }
        </style>
        <?php
    }
}
add_action('login_enqueue_scripts', 'lclookout_login_logo');

function lclookout_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'lclookout_login_logo_url');

function lclookout_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'lclookout_login_logo_url_title');
