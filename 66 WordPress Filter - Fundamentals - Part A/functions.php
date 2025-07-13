<?php

function filterA_enqueue_scripts()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'), false);
}

add_action('wp_enqueue_scripts', 'filterA_enqueue_scripts');


function modify_post_title($title_cyberaditya)
{
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
    if (is_main_query()) {
        $content .= '<p><em>-Written by Aditya Dubey</em></p>';
    }
    return $content;
}

add_filter('the_content', 'add_signature_to_content');