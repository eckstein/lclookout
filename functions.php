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
    // Add default posts RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Register nav menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'lclookout'),
        'main-cat-menu' => esc_html__('Main Category Menu', 'lclookout'),
        'social-icons' => esc_html__('Social Icons', 'lclookout'),
        'footer' => esc_html__('Footer Menu', 'lclookout'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
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
        'name'          => esc_html__('Home Left Sidebar', 'lclookout'),
        'id'            => 'home-sidebar-left',
        'description'   => esc_html__('Add widgets here to appear on the left side of the home page.', 'lclookout'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Home Right Sidebar', 'lclookout'),
        'id'            => 'home-sidebar-right',
        'description'   => esc_html__('Add widgets here to appear on the right side of the home page.', 'lclookout'),
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

    // Add a more aggressive cache buster
    $style_version = defined('WP_DEBUG') && WP_DEBUG ? time() : LCLOOKOUT_VERSION . '.' . filemtime(get_stylesheet_directory() . '/style.css');
    wp_enqueue_style('lclookout-style', get_stylesheet_uri(), array('lclookout-fonts'), $style_version);

    // Navigation Script
    wp_enqueue_script('lclookout-navigation', get_template_directory_uri() . '/js/navigation.js', array(), filemtime(get_template_directory() . '/js/navigation.js'), true);

    // Enqueue header search script
    wp_enqueue_script(
        'lclookout-header-search',
        get_template_directory_uri() . '/js/header-search.js',
        array(),
        '1.0.0',
        true
    );
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

/**
 * Output CSS Variables
 */
function lclookout_output_css_variables() {
    ?>
    <style>
        :root {
            /* Color Variables */
            --primary-blue: #2B5797;
            --primary-blue-dark: #1a3459;
            --accent-red: #D64045;
            --forest-green: #2A4747;
            --light-gray: #F5F5F5;
            --medium-gray: #E0E0E0;
            --dark-gray: #4A4A4A;
            --text-dark: #333333;
            --text-light: #666666;
            --white: #FFFFFF;
            
            /* Typography */
            --body-font: 'Source Sans Pro', sans-serif;
            --heading-font: 'Merriweather', serif;
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 2rem;
            --spacing-xl: 4rem;

            /* Container Width */
            --container-width: 1200px;
            --container-padding: 2rem;
        }
    </style>
    <?php
}
add_action('wp_head', 'lclookout_output_css_variables', 1);
add_action('login_head', 'lclookout_output_css_variables', 1);

/**
 * Customize the excerpt "read more" string
 */
function lclookout_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'lclookout_excerpt_more');

/**
 * Customize the content "read more" link
 */
function lclookout_content_more($more_link_element) {
    return str_replace('more-link', 'more-link read-more', $more_link_element);
}
add_filter('the_content_more_link', 'lclookout_content_more');

/**
 * Add Main Home Page Category setting to Reading Settings
 */
function lclookout_reading_settings_init() {
    // Register the setting
    register_setting('reading', 'lclookout_main_category', array(
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'default' => 0
    ));

    // Add the settings field
    add_settings_field(
        'lclookout_main_category',
        __('Main Home Page Category', 'lclookout'),
        'lclookout_main_category_callback',
        'reading'
    );
}
add_action('admin_init', 'lclookout_reading_settings_init');

/**
 * Render the Main Home Page Category dropdown
 */
function lclookout_main_category_callback() {
    $selected_category = get_option('lclookout_main_category', 0);
    $categories = get_categories(array('hide_empty' => false));
    
    echo '<select name="lclookout_main_category" id="lclookout_main_category">';
    echo '<option value="0">' . esc_html__('— Select Category —', 'lclookout') . '</option>';
    
    foreach ($categories as $category) {
        printf(
            '<option value="%d" %s>%s</option>',
            $category->term_id,
            selected($selected_category, $category->term_id, false),
            esc_html($category->name)
        );
    }
    
    echo '</select>';
    echo '<p class="description">' . esc_html__('Select the main category for your news archive. The "Read More News" link on the home page will direct to this category.', 'lclookout') . '</p>';
}

/**
 * Get categories excluding the main home page category
 */
function lclookout_get_filtered_categories($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $main_category_id = get_option('lclookout_main_category', 0);
    $categories = get_the_category($post_id);
    
    if (!$categories || !$main_category_id) {
        return $categories;
    }
    
    // Filter out the main category
    $filtered_categories = array_filter($categories, function($category) use ($main_category_id) {
        return $category->term_id != $main_category_id;
    });
    
    return $filtered_categories;
}

/**
 * Display category links excluding the main home page category
 */
function lclookout_the_category($separator = ', ', $parents = '', $post_id = false) {
    $categories = lclookout_get_filtered_categories($post_id);
    
    if (empty($categories)) {
        return;
    }
    
    $links = array();
    foreach ($categories as $category) {
        $links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" rel="category tag">' . esc_html($category->name) . '</a>';
    }
    
    echo implode($separator, $links);
}
