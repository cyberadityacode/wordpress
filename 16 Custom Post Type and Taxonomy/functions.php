<?php


function mytheme_cpt_enqueue_scripts()
{
    wp_enqueue_style("style-css", get_stylesheet_uri(), array(), filemtime(get_template_directory() . "/style.css"));
}

add_action('wp_enqueue_scripts', 'mytheme_cpt_enqueue_scripts');

/* 
I want to add new section in WP Admin called Projects Where we can add and manage different projects like posts
*/

function create_projects_cpt()
{
    register_post_type('project', array(
        'labels' => array(
            'name' => 'Projects',
            'singular_name' => 'Project',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Project',
            'edit_item' => 'Edit Project',
            'new_item' => 'New Project',
            'view_item' => 'View Project',
            'search_items' => 'Search Projects',
            'not_found' => 'No Projects found',
            'all_items' => 'All Projects',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'projects'), // URL like /projects/project-name
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-portfolio',
        'show_in_rest' => true,
    ));
}

add_action('init', 'create_projects_cpt');


/* add_action('admin_menu', function () {
    add_menu_page('Debug Post Types', 'Debug CPTs', 'manage_options', 'debug-cpts', function () {
        $args = array('post_type' => 'any', 'post_status' => 'publish');
        $posts = get_posts($args);
        echo '<pre>'; print_r($posts); echo '</pre>';
    });
}); */


function register_project_type_taxonomy()
{
    register_taxonomy('project_type', 'project', array(
        'labels' => array(
            'name' => 'Project Types',
            'singular_name' => 'Project Type',
            'add_new_item' => 'Add New Project Type',
            'menu_name' => 'Project Types',
        ),
        'hierarchical' => true, // like categories
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true, // for Gutenberg support
        'rewrite' => array('slug' => 'project-type'),
    ));
}
add_action('init', 'register_project_type_taxonomy');