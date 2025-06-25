<?php

// Enabling Featured Image

add_theme_support('post-thumbnails');


// load css
function mytheme_enqueue_styles()
{
    wp_enqueue_style('main-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'), false);
}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');