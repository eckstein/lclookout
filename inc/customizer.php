<?php
/**
 * Lewis County Lookout Theme Customizer
 */

function lclookout_customize_register($wp_customize) {
    // Add logo upload
    $wp_customize->add_setting('custom_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'custom_logo', array(
        'label'         => __('Site Logo', 'lclookout'),
        'section'       => 'title_tagline',
        'priority'      => 9,
        'height'        => 100,
        'width'         => 400,
        'flex_height'   => true,
        'flex_width'    => true,
    )));

    // Add Header Section
    $wp_customize->add_section('header_settings', array(
        'title'    => __('Header Settings', 'lclookout'),
        'priority' => 30,
    ));

    // Add Sticky Header Toggle
    $wp_customize->add_setting('sticky_header_enabled', array(
        'default'           => false,
        'sanitize_callback' => 'lclookout_sanitize_checkbox',
    ));

    $wp_customize->add_control('sticky_header_enabled', array(
        'label'    => __('Enable Sticky Header', 'lclookout'),
        'section'  => 'header_settings',
        'type'     => 'checkbox',
    ));

    // Add Scrolled Logo Height
    $wp_customize->add_setting('scrolled_logo_height', array(
        'default'           => '60',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('scrolled_logo_height', array(
        'label'       => __('Scrolled Logo Height (px)', 'lclookout'),
        'section'     => 'header_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 200,
            'step' => 1,
        ),
    ));

    // Add Header Background Color
    $wp_customize->add_setting('header_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_background_color', array(
        'label'    => __('Header Background Color', 'lclookout'),
        'section'  => 'colors',
        'settings' => 'header_background_color',
    )));

    // Add Footer Text
    $wp_customize->add_section('footer_settings', array(
        'title'    => __('Footer Settings', 'lclookout'),
        'priority' => 120,
    ));

    $wp_customize->add_setting('footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('footer_text', array(
        'label'    => __('Footer Text', 'lclookout'),
        'section'  => 'footer_settings',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'lclookout_customize_register');

/**
 * Sanitize checkbox values
 */
function lclookout_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Output Customizer CSS
 */
function lclookout_customizer_css() {
    $sticky_enabled = get_theme_mod('sticky_header_enabled', false);
    $scrolled_height = get_theme_mod('scrolled_logo_height', 60);
    ?>
    <style type="text/css">
        .site-header {
            background-color: <?php echo esc_attr(get_theme_mod('header_background_color', '#ffffff')); ?>;
        }

        <?php if ($sticky_enabled) : ?>
        .site-header.scrolled .custom-logo {
            max-height: <?php echo esc_attr($scrolled_height); ?>px;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'lclookout_customizer_css'); 