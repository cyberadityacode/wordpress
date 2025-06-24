<?php

function working_with_loop_enqueue_scripts()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'), false);
}

add_action('wp_enqueue_scripts', 'working_with_loop_enqueue_scripts');



function working_with_loop_blog_post_setup()
{
    add_theme_support('post-thumbnails'); //enable feature image support
    add_image_size('custom-thumb', 300, 300, true); //300x300 hard crop
}

add_action('after_setup_theme', 'working_with_loop_blog_post_setup');