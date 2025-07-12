<?php

namespace RIU;

defined('ABSPATH') || exit;

class Plugin
{
    private $page_hook = "";

    public function run()
    {
        add_action('admin_menu', [$this, 'add_admin_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);

        // Ajax for save image
        add_action('wp_ajax_riu_save_image', [$this, 'save_image']);

        // shortcode
        add_action('init', [$this, 'register_shortcodes']);
    }

    public function register_shortcodes()
    {
        add_shortcode('display_uploaded_image', [$this, 'display_uploaded_image_shortcode']);

    }


    public function display_uploaded_image_shortcode()
    {
        $image_url = get_option('riu_saved_image_url');

        if (!$image_url) {
            return "<p>No Image Uploaded Yet</p>";
        }

        return "<img src='" . esc_url($image_url) . "' style='max-width:300px; height:300px;' alt='Uploaded Image' />";
    }

    public function add_admin_page()
    {
        $this->page_hook = add_menu_page(
            'React Image Upload',
            'React Image Upload',
            'manage_options',
            'react-image-uploader',
            [$this, 'render_page'],
            'dashicons-format-image',
            26
        );
    }

    public function render_page()
    {
        echo '<div class="wrap"><h1>React Image Upload</h1>';
        echo '<div id="riu-root"></div></div>';
    }

    public function enqueue_assets($hook)
    {
        if ($hook !== $this->page_hook)
            return;

        // JS (From React Build)
        wp_enqueue_script(
            'riu-script',
            plugin_dir_url(__DIR__) . 'build/index.js',
            ['wp-element', 'wp-media-utils'],
            '1.0',
            true
        );

        // WordPress Media
        wp_enqueue_media();

        // Localize
        wp_localize_script('riu-script', 'riu_data', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('riu_image_upload')
        ]);

    }
    public function save_image()
    {
        check_ajax_referer('riu_image_upload', 'nonce');
        $image_url = esc_url_raw($_POST['image_url'] ?? '');

        if (!$image_url) {
            wp_send_json_error(['message' => 'No Image Provided']);
        }

        // save to DB if needed (we will implement it later)
        update_option('riu_saved_image_url', $image_url);

        wp_send_json_success(['message' => 'Image URL Received', 'url' => $image_url]);

    }
}

