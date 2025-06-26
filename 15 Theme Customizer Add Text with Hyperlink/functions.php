<?php


// Function to enqueue scripts (style and scripts)
function mytheme_enqueue_scripts()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'), false);
}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');


// working with customizer

function mytheme_customize_register($wp_customize)
{
    // 1. Add a new section in the customizer

    $wp_customize->add_section('footer_section', array(
        'title' => __('Footer Settings', 'mytheme'),
        'priority' => 120,
    ));

    // 2. Add a new setting

    $wp_customize->add_setting('footer_text', array(
        'default' => '&copy; 2025 My Site Name',
        'transport' => 'refresh',
    ));

    // 3. Add control for the setting
    $wp_customize->add_control('footer_text_control', array(
        'label' => __('Footer Text', 'mytheme'),
        'section' => 'footer_section',
        'settings' => 'footer_text',
        'type' => 'text',
    ));


    // I want to use the existing session to add a text with hyperlink

    // 1. add settings (since, section is already available)

    $wp_customize->add_setting('custom_footer_link', array(
        'default' => 'Visit my <a href="https://www.github.com/cyberadityacode" target="_blank">GitHub</a>',
        'sanitize_callback' => 'wp_kses_post', //allow basic html link <a>
        'transport' => 'refresh',
    ));

    // 2. add control (textarea for html)

    $wp_customize->add_control('custom_footer_link_control', array(
        'label' => __('Footer Text with Link', 'mytheme'),
        'section' => 'footer_section',
        'settings' => 'custom_footer_link',
        'type' => 'textarea',
    ));


    // Now, I want to add 2 Text fields, one for text and another for hyperlink which binds together

    // 1 - Link Text

    $wp_customize->add_setting('footer_link_text', array(
        'default' => 'Github Profile',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    // control 1
    $wp_customize->add_control('footer_link_text_control', array(
        'label' => __('Link Text (what users sees)', 'mytheme'),
        'section' => 'footer_section',
        'settings' => 'footer_link_text',
        'type' => 'text',
    ));

    // setting 2 : link URL
    $wp_customize->add_setting('footer_link_url', array(
        'default' => 'https://www.github.com/cyberadityacode',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));

    // control 2
    $wp_customize->add_control('footer_link_url_control', array(
        'label' => __('Link URL (where it goes)', 'mytheme'),
        'section' => 'footer_section',
        'settings' => 'footer_link_url',
        'type' => 'url',
    ));

    // I want to add checkbox which enable user to open link in new tab in customizer
    // 3rd Setting: Open link in a new tab

    $wp_customize->add_setting('footer_link_new_tab', array(
        'default' => true, // default to opening in new tab
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));

    // control for checkbox

    $wp_customize->add_control('footer_link_new_tab_control', array(
        'label' => __('Open Link in new Tab', 'mytheme'),
        'section' => 'footer_section',
        'settings' => 'footer_link_new_tab',
        'type' => 'checkbox',
    ));


}

add_action('customize_register', 'mytheme_customize_register');