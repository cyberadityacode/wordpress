<?php

function filterA_enqueue_scripts()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'), false);
}

add_action('wp_enqueue_scripts', 'filterA_enqueue_scripts');


function modify_post_title($title_cyberaditya)
{

    if (is_page('about')) {
        return $title_cyberaditya;
    }
    return "🔥 " . $title_cyberaditya;
}

add_filter('the_title', 'modify_post_title');

function custom_excerpt_more($more)
{
    return "...👉Read More";
}

add_filter('excerpt_more', 'custom_excerpt_more');

function custom_excerpt_length($length)
{
    return 10;
}

add_filter('excerpt_length', 'custom_excerpt_length');

// adding signature to post content

function add_signature_to_content($content)
{
    if (is_single() && is_main_query()) {
        $content .= '<p><em>-Written by Aditya Dubey on ' . date('d-m-Y') . '</em></p>';
    }
    return $content;
}

add_filter('the_content', 'add_signature_to_content');

// Build in Filter - Body Class -> Add Dynamic Class

function add_custom_body_class($classes)
{
    if (is_home()) {
        $classes[] = 'home-post-layout';
    }
    if (is_single()) {
        $classes[] = 'single-post-layout';
    }
    if (is_page()) {
        $classes[] = 'about-hightlight';
    }
    return $classes;
}

add_filter('body_class', 'add_custom_body_class');


// Filter Comments

function censor_bad_words($comment_text)
{

    $bad_words = array(
        'badword',
        'uglyword',
        'nastyword',
        'stupid',
        'idiot',
        'dumb',
        'fool',
        'hate'
        // Add more as needed
    );

    $replacement = '****Jor se Bolo Jai Mata Di***';
    return str_ireplace($bad_words, $replacement, $comment_text);
}

add_filter('comment_text', 'censor_bad_words');


// adding number before all post title

function number_title($title)
{
    if (is_page('about')) {
        return $title;
    }

    static $count = 1;
    return '#' . $count++ . ' ' . $title;
}

add_filter('the_title', 'number_title');

// Add a custom promotion to blog home page

/* function home_page_banner($content)
{
    if (is_home() && is_main_query()) {
        $content = '<div class="promo">🎉 Welcome to our blog! Don\'t miss our latest updates... </div>' . $content;
    }
    return $content;
}

add_filter('the_content', 'home_page_banner'); */