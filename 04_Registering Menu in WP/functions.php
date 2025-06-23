<?php

function mytheme_enqueue_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . "/style.css"));

    wp_enqueue_script('main-js', get_template_directory_uri() . "/main.js", array(), filemtime(get_template_directory() . "/main.js"), true);
}

add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');

register_nav_menus(array(
    'primary' => __('Primary Menu')
));

