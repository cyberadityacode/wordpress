<?php
defined('ABSPATH') || exit;

class ReactImageUploader
{
    private $page_hook = '';

    public function run()
    {
        // Admin area
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);

        // AJAX handlers (admin only)
        add_action('wp_ajax_save_gallery_images', [$this, 'handle_save_gallery']);
        add_action('wp_ajax_get_gallery_images', [$this, 'handle_get_gallery']);
        add_action('wp_ajax_nopriv_get_gallery_images', [$this, 'handle_get_gallery']);
        add_action('wp_ajax_delete_gallery_image', [$this, 'handle_delete_image']);

        // Frontend shortcode
        add_shortcode('riu_gallery', [$this, 'display_gallery_shortcode']);
    }

    public function add_menu()
    {
        $this->page_hook = add_menu_page(
            'React Multiple Images',
            'React Multiple Images',
            'manage_options',
            'react-multiple-image',
            [$this, 'render_page'],
            'dashicons-format-gallery',
            25
        );
    }

    public function render_page()
    {
        echo "<h1>📁 React Multiple Image Upload</h1>";
        echo "<div id='react-image-uploader'></div>";
    }

    public static function activate()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'riu_gallery';
        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image_url TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public function enqueue_assets($hook)
    {
        if ($hook !== $this->page_hook) return;

        $asset_url = plugin_dir_url(__FILE__) . 'build/index.js';

        wp_enqueue_media();
        wp_enqueue_script('react-image-uploader', $asset_url, [], '1.0', true);
        wp_localize_script('react-image-uploader', 'riuData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('riu_nonce')
        ]);
    }

    public function handle_save_gallery()
    {
        check_ajax_referer('riu_nonce', 'nonce');

        global $wpdb;
        $table = $wpdb->prefix . 'riu_gallery';
        $images = json_decode(stripslashes($_POST['images']), true);

        if (!is_array($images)) {
            wp_send_json_error(['message' => 'Invalid Data']);
        }

        foreach ($images as $url) {
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $wpdb->insert($table, ['image_url' => esc_url_raw($url)]);
            }
        }

        wp_send_json_success(['message' => 'Images Saved']);
    }

    public function handle_get_gallery()
    {
        // check_ajax_referer('riu_nonce', 'nonce');

        global $wpdb;
        $table = $wpdb->prefix . 'riu_gallery';

        $images = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC", ARRAY_A);
        wp_send_json_success($images);
    }

    public function handle_delete_image()
    {
        check_ajax_referer('riu_nonce', 'nonce');

        $id = intval($_POST['id']);
        if (!$id) {
            wp_send_json_error(['message' => 'Invalid ID']);
        }

        global $wpdb;
        $deleted = $wpdb->delete($wpdb->prefix . 'riu_gallery', ['id' => $id], ['%d']);

        if ($deleted) {
            wp_send_json_success(['message' => 'Image Deleted']);
        } else {
            wp_send_json_error(['message' => 'Failed to Delete']);
        }
    }

    public function display_gallery_shortcode()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'riu_gallery';
        $images = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");

        if (!$images) return "<p>No Images Found</p>";

        ob_start();
        echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>";
        foreach ($images as $img) {
            echo "<img src='" . esc_url($img->image_url) . "' width='150' />";
        }
        echo "</div>";
        return ob_get_clean();
    }
}
