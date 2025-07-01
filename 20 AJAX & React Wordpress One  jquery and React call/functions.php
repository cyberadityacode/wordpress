<?php

function ajax_fundamentals_one_enqueue_scripts()
{
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . "/style.css"), "all");


    // load jquery
    wp_enqueue_script('jquery');
    // load js file
    wp_enqueue_script('my-ajax-js', get_template_directory_uri() . '/script.js', array('jquery'), filemtime(get_template_directory() . '/script.js'), true);

    // pass ajax url to JS
    wp_localize_script('my-ajax-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php') //important wp file that handles ajax
    ));


    // load react script

    wp_enqueue_script(
        'my-react-app',
        get_template_directory_uri() . '/react-ajaxone/dist/assets/index-BkSkrb1a.js',
        array(),
        null,
        true
    );

    wp_localize_script('my-react-app', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}


add_action('wp_enqueue_scripts', 'ajax_fundamentals_one_enqueue_scripts');


function my_handle_ajax_request()
{
    // get message from AJAX
    $msg = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : "No Message";

    // return a response
    echo "Message received: " . $msg . " " . date('Y');
    wp_die(); //important - end the ajax call properly
}


// for logged in user

add_action("wp_ajax_my_ajax_action", 'my_handle_ajax_request');

// for guests (non logged in user)

add_action("wp_ajax_nopriv_my_ajax_action", 'my_handle_ajax_request');