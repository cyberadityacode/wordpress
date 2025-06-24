<?php

function working_with_menu_widget_enqueue_scripts()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'), false);
}

add_action('wp_enqueue_scripts', 'working_with_menu_widget_enqueue_scripts');



function working_with_menu_widget_setup()
{
    add_theme_support('post-thumbnails'); //enable feature image support
    add_image_size('custom-thumb', 300, 300, true); //300x300 hard crop

    // add menu support 
    add_theme_support('menus');
    // Register a menu location
    register_nav_menus(array(
        'main-menu' => 'Main Menu',  //main-menu is the ID used in this code, Main Menu is the name shown in the admin dashboard
    ));
}

add_action('after_setup_theme', 'working_with_menu_widget_setup');


// Working with Sidebar

function working_menu_widgets_init()
{
    register_sidebar(array(
        'name' => 'Main Sidebar',
        'id' => 'main-sidebar',
        'description' => 'Sidebar shown in the blog pages',
        'before_widget' => '<div class="widget %2$s">', //before each widget
        'after_widget' => '</div>', //after each widget
        'before_title' => '<h3 class="widget-title">', //before widget title
        'after_title' => '</h3>', // after widget title
    ));
}

add_action('widgets_init', 'working_menu_widgets_init');