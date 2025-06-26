<?php

function mytheme_setup()
{
    // Allow Logo setup
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Allow WordPress to handle site title in browser tab

    add_theme_support('title-tag');

}

add_action('after_setup_theme', 'mytheme_setup');

// enqueue css style

function mytheme_enqueue_style()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));

}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_style');


// customize register

function mytheme_customize_register($wp_customize)
{
    // Add footer text section
    $wp_customize->add_section('footer_section', array(
        'title' => __('Footer Settings', 'mytheme'),
        'priority' => 30,
    ));

    // Add setting for Footer text
    $wp_customize->add_setting('footer_text', array(
        'default' => '&copy; 2025 My Website',
        'transport' => 'refresh',
    ));

    // Add control for footer text
    $wp_customize->add_control('footer_text_control', array(
        'label' => __('Footer Text', 'mytheme'),
        'section' => 'footer_section',
        'settings' => 'footer_text',
        'type' => 'text',
    ));

    // 2 Add Primary Color picker

    $wp_customize->add_setting('primary_color', array(
        'default' => '#0073aa',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
        'label' => __('Primary Color', 'mytheme'),
        'section' => 'colors', //you can also create your own section
        'settings' => 'primary_color'
    )));
}

add_action('customize_register', 'mytheme_customize_register');