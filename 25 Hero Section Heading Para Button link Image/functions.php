<?php


function ajax_theme_three_wp_enqueue_scripts()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_script('jquery');
    wp_enqueue_script('script-js', get_template_directory_uri() . '/script.js', array('jquery'), filemtime(get_template_directory() . '/script.js'), true);

    // localize_script
    wp_localize_script('script-js', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fetch_posts_nonce')
    ]);
}

add_action('wp_enqueue_scripts', 'ajax_theme_three_wp_enqueue_scripts');


// Step 2: Add the AJAX Callback in functions.php

function fetch_posts_ajax_callback()
{
    check_ajax_referer('fetch_posts_nonce', 'security');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? intval($_POST['category']) : '';
    $tag = isset($_POST['tag']) ? intval($_POST['tag']) : '';

    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';


    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'paged' => $paged,
        'post_status' => 'publish'
    );

    // add category filter if set
    if (!empty($category)) {
        $args['cat'] = $category;
    }

    // add tag filter if set
    if (!empty($tag)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'post_tag',
            'field' => 'term_id',
            'terms' => $tag,
        );
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    $posts_data = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $posts_data[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'content' => get_the_content(),
                'date' => get_the_date(),
                'author' => get_the_author(),
                'category' => wp_list_pluck(get_the_category(), 'name'),
                'tag' => get_the_tags() ? wp_list_pluck(get_the_tags(), 'name') : [],
            );
        }
        wp_reset_postdata();
    }
    // wp_send_json($posts_data); //secure JSON response
    wp_send_json(array(
        'posts' => $posts_data,
        'max_pages' => $query->max_num_pages,
        'current_page' => $paged
    ));
}

// AJAX action hooks for logged in and guests

add_action('wp_ajax_fetch_posts_ajax', 'fetch_posts_ajax_callback');
add_action('wp_ajax_nopriv_fetch_posts_ajax', 'fetch_posts_ajax_callback');


/* 

this:

Checks nonce from JS (security)

Runs query

Sends JSON using wp_send_json()
*/


// Add Customizer in Theme for footer text

function ajax_theme_three_customize_register($wp_customize)
{
    // Add a section for the footer

    $wp_customize->add_section('ajax_theme_three_footer_section', array(
        'title' => __('Footer Settings', 'mytheme'),
        'priority' => 160,
    ));

    // Add Setting for footer text

    $wp_customize->add_setting('ajax_theme_three_footer_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add Control for the footer text

    $wp_customize->add_control('ajax_theme_three_footer_text_control', array(
        'label' => __('Footer Text', 'ajax_theme'),
        'section' => 'ajax_theme_three_footer_section',
        'settings' => 'ajax_theme_three_footer_text',
        'type' => 'text',
    ));

    //Hero Section customizer

    $wp_customize->add_section('ajax_theme_three_hero_section', array(
        'title' => __('Hero Section', 'mytheme'),
        'priority' => 100,
    ));

    // add setting for hero section heading

    $wp_customize->add_setting('ajax_theme_three_heading_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // add control for hero section heading

    $wp_customize->add_control('ajax_theme_three_hero_heading_text_control', array(
        'label' => __('Hero Heading Text', 'ajax_theme'),
        'section' => 'ajax_theme_three_hero_section',
        'settings' => 'ajax_theme_three_heading_text',
        'type' => 'text',
    ));

    // add setting for hero section paragraph

    $wp_customize->add_setting('ajax_theme_three_heading_paragraph_text', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post', // use sanitize_text_field if you want plain text only
    ));

    // add control for hero section heading paragraph

    $wp_customize->add_control('ajax_theme_three_heading_paragraph_text_control', array(
        'label' => __('Hero Paragraph Text', 'ajax_theme'),
        'section' => 'ajax_theme_three_hero_section',
        'settings' => 'ajax_theme_three_heading_paragraph_text',
        'type' => 'textarea',
    ));

    // hero section button text

    $wp_customize->add_setting('ajax_theme_three_heading_button_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // add control for hero section button

    $wp_customize->add_control('ajax_theme_three_heading_button_text_control', array(
        'label' => __('Hero Button Text', 'ajax_theme'),
        'section' => 'ajax_theme_three_hero_section',
        'settings' => 'ajax_theme_three_heading_button_text',
        'type' => 'text',
    ));

    // Setting for Hero Button URL
    $wp_customize->add_setting('ajax_theme_three_heading_button_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // control for button url

    $wp_customize->add_control('ajax_theme_three_heading_button_url_control', array(
        'label' => __('Hero Button Link URL', 'ajax_theme'),
        'section' => 'ajax_theme_three_hero_section',
        'settings' => 'ajax_theme_three_heading_button_url',
        'type' => 'url',
    ));



    // Image for Hero Section

    // settings
    $wp_customize->add_setting('ajax_theme_three_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));

    // control for image upload

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ajax_theme_three_hero_image_control', array(
        'label' => __('Hero Section Image', 'ajax_theme'),
        'section' => 'ajax_theme_three_hero_section',
        'settings' => 'ajax_theme_three_hero_image',
    )));

}

add_action('customize_register', 'ajax_theme_three_customize_register');

// enqueue customizer.js script

function ajax_theme_three_customize_preview_js()
{
    wp_enqueue_script('ajaz_theme_three_customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), null, true);
}

add_action('customize_preview_init', 'ajax_theme_three_customize_preview_js');


