<?php


// Enqueue Style
function portfolio_react_enqueue_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_style('style-react', get_stylesheet_directory_uri() . '/dist/assets/main.css', [], "1.0");
    wp_enqueue_script(
        'react-app',
        get_template_directory_uri() . '/dist/assets/index.js',
        [],
        null,
        true
    );
}

add_action('wp_enqueue_scripts', 'portfolio_react_enqueue_scripts');

// basic theme setup

function portfolio_react_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('blog-thumb', 200, 120, true); // 200x120 hard crop
}

add_action('after_setup_theme', 'portfolio_react_theme_setup');

// Navigation Menu
register_nav_menus([
    'main-menu' => __('Main Navigation Menu'),
]);

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/menu', [
        'method' => 'GET',
        'callback' => 'get_custom_menu'
    ]);
});

function get_custom_menu()
{
    $menu_items = wp_get_nav_menu_items('Main Menu');
    $response = [];

    foreach ($menu_items as $item) {
        $response[] = [
            'id' => $item->ID,
            'title' => $item->title,
            'url' => $item->url,
        ];
    }
    return $response; ///wp-json/custom/v1/menu
    //http://localhost/wpaditya/wp-json/custom/v1/menu
}





// Allow Featured images in REST API response

function add_thumbnail_to_project_api()
{
    register_rest_field('project', 'featured_image_url', [
        'get_callback' => function ($post) {
            return get_the_post_thumbnail_url($post['id'], 'medium');
        },
        'schema' => null,
    ]);
}

add_action('init', 'add_thumbnail_to_project_api');


/* Register CPT for Projects */

function register_project_cpt()
{
    $labels = [
        'name' => 'Projects',
        'singular_name' => 'Project',
        'menu_name' => 'Projects',
        'name_admin_bar' => 'Project',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Project',
        'new_item' => 'New Project',
        'edit_item' => 'Edit Project',
        'view_item' => 'View Project',
        'all_items' => 'All Projects',
        'search_items' => 'Search Projects',
        'not_found' => 'No Project Found',
        'not_found_in_trash' => 'No Projects found in Trash'
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true, //important for REST API access
    ];

    register_post_type('project', $args);
}


add_action('init', 'register_project_cpt');

// Organise Projects by Tags and Categories
function register_project_taxonomy()
{
    register_taxonomy(
        'project_category',
        'project',
        [
            'label' => 'Project Categories',
            'rewrite' => ['slug' => 'project-category'],
            'hierarchical' => true,
            'show_in_rest' => true
        ]
    );
}

add_action('init', 'register_project_taxonomy');
/* 
API URL Project Categories: http://localhost/wpaditya/wp-json/wp/v2/project_category
Project: http://localhost/wpaditya/wp-json/wp/v2/project

*/

// Add Featured Image to Post REST API

function get_post_thumbnail_or_default($post_id, $size = 'blog-thumb')
{
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail_url($post_id, $size);
    } else {
        // Replace with your theme's actual default image path
        return get_template_directory_uri() . '/assets/default_image.png';
    }
}

function add_thumbnail_to_post_api()
{
    register_rest_field('post', 'featured_image_url', [
        'get_callback' => function ($post) {
            return get_post_thumbnail_or_default($post['id'], 'medium');
        },
        'schema' => null,
    ]);
}
add_action('rest_api_init', 'add_thumbnail_to_post_api');

function register_skills_post_type()
{
    register_post_type('skill', [
        'labels' => [
            'name' => __('Skills'),
            'singular_name' => __('Skill'),
            'menu_name' => __('Skills'),
            'name_admin_bar' => __('Skill'),
            'add_new' => __('Add New Skill'),
            'add_new_item' => __('Add New Skill'),
            'new_item' => __('New Skill'),
            'edit_item' => __('Edit Skill'),
            'view_item' => __('View Skill'),
            'all_items' => __('All Skills'),
            'search_items' => __('Search Skills'),
            'not_found' => __('No Skills found.'),
            'not_found_in_trash' => __('No Skills found in Trash.'),

        ],
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-chart-bar',
        'supports' => ['title'],
    ]);
}

add_action('init', 'register_skills_post_type');

function add_skill_level_meta_box()
{
    add_meta_box(
        'skill_level_box',
        'Skill Level (0-100)',
        'render_skill_level_box',
        'skill',
        'side',
        'default'
    );
}

add_action('add_meta_boxes', 'add_skill_level_meta_box');


function render_skill_level_box($post)
{
    $value = get_post_meta($post->ID, '_skill_level', true);
    ?>
    <label for="skill_level">Level:</label>
    <input type="number" id="skill_level" name="skill_level" value="<?php echo esc_attr($value); ?>" min="0" max="100"
        style="width: 100%;" />

    <?php

}

// save auto

function save_skill_level_meta($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (isset($_POST['skill_level'])) {
        update_post_meta($post_id, '_skill_level', intval($_POST['skill_level']));
    }
}

function register_skill_level_rest_field()
{
    register_rest_field('skill', 'level', [
        'get_callback' => function ($object) {
            return (int) get_post_meta($object['id'], '_skill_level', true);
        },
        'schema' => [
            'type' => 'integer',
            'context' => ['view', 'edit']
        ]
    ]);
}
add_action('rest_api_init', 'register_skill_level_rest_field');
// http://localhost/wpaditya/wp-json/wp/v2/skill


add_action('save_post_skill', 'save_skill_level_meta');

// taxonomy for skills

function register_skill_category_taxonomy()
{
    register_taxonomy(
        'skill_category',
        'skill',
        [
            'label' => 'Skill Categories',
            'rewrite' => ['slug' => 'skill-category'],
            'hierarchical' => true,
            'show_in_rest' => true
        ]
    );
}

add_action('init', 'register_skill_category_taxonomy');

//http://localhost/wpaditya/wp-json/wp/v2/skill

// Add Category name to skill API Output
function add_skill_category_name_to_api()
{
    register_rest_field('skill', 'skill_category_name', [
        'get_callback' => function ($object) {
            $terms = get_the_terms($object['id'], 'skill_category');
            return $terms ? wp_list_pluck($terms, 'name') : [];
        },
        'schema' => null
    ]);
}

add_action('rest_api_init', 'add_skill_category_name_to_api');


/* Theme Customizer for Name, About and Photo for Hero Section */

function theme_customizer_register($wp_customize)
{
    // section
    $wp_customize->add_section('hero_section', array(
        'title' => __("Hero Section", 'mytheme'),
        'priority' => 30,
    ));

    // Name Field

    $wp_customize->add_setting('hero_name', array(
        'default' => '',
        'transport' => 'refresh'
    ));

    $wp_customize->add_control('hero_name', array(
        'label' => __('Name', 'mytheme'),
        'section' => 'hero_section',
        'type' => 'text',
    ));

    // About Field
    $wp_customize->add_setting('hero_about', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('hero_about', array(
        'label' => __('About Text', 'mytheme'),
        'section' => 'hero_section',
        'type' => 'textarea',
    ));

    // Photo field

    $wp_customize->add_setting('hero_image', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label' => __('Hero Image', 'mytheme'),
        'section' => 'hero_section',
        'settings' => 'hero_image',
    )));

}
add_action('customize_register', 'theme_customizer_register');


// Footer Section Customizer


function theme_customize_footer($wp_customize)
{
    // Section
    $wp_customize->add_section('footer_section', array(
        'title' => __('Footer Settings', 'yourtheme'),
        'priority' => 130,
    ));

    // Footer Text
    $wp_customize->add_setting('footer_text', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('footer_text', array(
        'label' => __('Footer Text', 'yourtheme'),
        'section' => 'footer_section',
        'type' => 'text',
    ));

    // Social Media Links
    $socials = ['github', 'twitter', 'linkedin', 'instagram'];

    foreach ($socials as $social) {
        $wp_customize->add_setting("footer_{$social}_link", array(
            'default' => '',
            'transport' => 'refresh',
        ));

        $wp_customize->add_control("footer_{$social}_link", array(
            'label' => ucfirst($social) . ' URL',
            'section' => 'footer_section',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'theme_customize_footer');


// Limit excerpt length to 15 words
function custom_excerpt_length($length)
{
    return 15;
}
add_filter('excerpt_length', 'custom_excerpt_length');
