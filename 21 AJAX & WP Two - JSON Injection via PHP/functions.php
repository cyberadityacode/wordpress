<?php

function ajax_theme_two_enqueue_scripts()
{
    wp_enqueue_style("style-css", get_stylesheet_uri(), array(), filemtime(get_template_directory() . "/style.css"));
    wp_enqueue_script('jquery');
    wp_enqueue_script('script-js', get_template_directory_uri() . '/script.js', array('jquery'), filemtime(get_template_directory() . "/script.js"), true);

    // Pass AJAX URL and nonce to script.js

    wp_localize_script('script-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax_nonce')
    ));

    // load react script

    wp_enqueue_script(
        'my-react-app',
        get_template_directory_uri() . '/reactajaxtheme/dist/assets/index-DP5d5weT.js',

        array(),
        null,
        true
    );

    // React
 /*    wp_localize_script('my-react-app', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    )); */
}


add_action("wp_enqueue_scripts", "ajax_theme_two_enqueue_scripts");

// handle ajax in php

function handle_my_custom_ajax_request()
{
    check_ajax_referer('ajax_nonce', 'nonce');

    $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : "No Message Received";

    // send a response
    wp_send_json_success("Received: " . $message);

}

// for logged in  user

add_action('wp_ajax_my_custom_action', 'handle_my_custom_ajax_request');


//for guests (non logged in users)

add_action('wp_ajax_nopriv_my_custom_action', 'handle_my_custom_ajax_request');