<?php

defined('ABSPATH') || exit;
class ReactPlugin2
{
    private $page_hook = '';
    public function run()
    {
        add_action('admin_menu', [$this, 'add_menu']);

        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);

        // register AJAX handler
        add_action('wp_ajax_save_student', [$this, 'handle_save_student']);
        add_action('wp_ajax_get_students', [$this, 'handle_get_students']);
    }

    // Enlist Students
    public function handle_get_students()
    {
        global $wpdb;
        $table_reactplugin2 = $wpdb->prefix . 'reactplugin2';

        $results = $wpdb->get_results("SELECT * FROM $table_reactplugin2;", ARRAY_A);

        wp_send_json_success($results);
    }

    // Save Student
    public function handle_save_student()
    {
        global $wpdb;

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);

        if (empty($name) || empty($email)) {
            wp_send_json_error(['message' => 'Name and Email are required']);
        }

        $wpdb->insert(
            $wpdb->prefix . 'reactplugin2',
            ['name' => $name, 'email' => $email],
            ['%s', '%s']
        );

        wp_send_json_success(['message' => "Student Saved Successfully"]);
    }

    // create table on plugin activation

    public static function activate()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'reactplugin2';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function add_menu()
    {
        $this->page_hook = add_menu_page(
            'React Plugin 2',
            'React Plugin 2',
            'manage_options',
            'react-plugin2',
            [$this, 'render_page'],
            'dashicons-smiley',
            22
        );

    }

    public function render_page()
    {
        echo "<h1>Hello React App from PHP</h1>";
        echo "<div id='my-react-app'></div>";
    }

    public function enqueue_assets($hook)
    {
        if ($hook !== $this->page_hook)
            return;

        $asset_url = plugin_dir_url(__FILE__) . 'build/index.js';
        wp_enqueue_script('my-react-script', $asset_url, [], '1.0', true);

        // localize script to pass ajax_url
        wp_localize_script('my-react-script', 'window', [
            'ajaxurl' => admin_url('admin-ajax.php')
        ]);
    }
}