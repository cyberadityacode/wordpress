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

// AJAX Handler to fetch Posts

function handle_ajax_fetch_posts()
{
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
            // echo '<h3>' . get_the_title() . '</h3>';
            echo '<h3><a href="#" class="post-link" data-id="' . get_the_ID() . '">' . get_the_title() . '</a></h3>';
            echo '<div>' . get_the_excerpt() . '</div>';
        endwhile;
        wp_reset_postdata();
    else:
        echo "NO Blog Post Found";
    endif;
    wp_die();
}

add_action('wp_ajax_fetch_posts', 'handle_ajax_fetch_posts');
add_action('wp_ajax_nopriv_fetch_posts', 'handle_ajax_fetch_posts');

// ajax fetch full post content

function handle_ajax_get_post_content()
{
    check_ajax_referer('ajax_nonce', 'nonce');

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if ($post_id) {
        $post = get_post($post_id);

        if ($post) {
            $content = apply_filters('the_content', $post->post_content);
            wp_send_json_success($content);
        }
    }

    wp_send_json_error("blog post not found");
}

add_action('wp_ajax_get_post_content', 'handle_ajax_get_post_content');
add_action('wp_ajax_nopriv_get_post_content', 'handle_ajax_get_post_content');

