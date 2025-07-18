<?php

class ChatPlugin_loader
{
    public function run()
    {
        add_shortcode('chatplugin', [$this, 'render_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_menu', [$this, 'add_admin_menu']);

        // Handle AJAX (Both Logged- in and guest)
        add_action('wp_ajax_chatplugin_submit_message', [$this, 'handle_message']);
        add_action('wp_ajax_nopriv_chatplugin_submit_message', [$this, 'handle_message']);

    }

    public function handle_message()
    {
        check_ajax_referer('chatplugin_nonce', 'nonce');

        global $wpdb;
        $table = $wpdb->prefix . 'chatplugin_messages';


        $message = sanitize_text_field($_POST['message'] ?? '');
        if (empty($message)) {
            wp_send_json_error(['error' => 'Empty Message']);
        }

        // inserting user message
        $wpdb->insert($table, [
            'message' => $message,
            'sender' => 'user'
        ]);
        // Simulate Bot Reply
        $botReply = "You Said: " . $message;

        // inserting bot reply
        $wpdb->insert($table, [
            'message' => $botReply,
            'sender' => 'bot'
        ]);

        wp_send_json_success(['reply' => $botReply]);
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'Chat Plugin',
            'Chat Plugin',
            'manage_options',
            'chatplugin-admin',
            [$this, 'render_admin_page'],
            'dashicons-format-chat'
        );
    }

    public function render_admin_page()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'chatplugin_messages';

        $messages = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('ChatPlugin Admin', 'chatplugin') . '</h1>';
        echo '<table class="widefat fixed striped">';
        echo '<thead><tr><th>Time</th><th>Sender</th><th>Message</th></tr></thead>';
        echo '<tbody>';

        foreach ($messages as $msg) {
            echo '<tr>';
            echo '<td>' . esc_html($msg->created_at) . '</td>';
            echo '<td>' . esc_html(ucfirst($msg->sender)) . '</td>';
            echo '<td>' . esc_html($msg->message) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';
    }

    public function enqueue_assets()
    {
        // only enqueue if shortcode is used
        $post = get_post();
        if (!is_singular() || !has_shortcode($post->post_content, 'chatplugin')) {
            return;
        }

        $build_path = plugin_dir_url(dirname(__FILE__)) . 'build/assets/';
        wp_enqueue_style(
            'chatplugin-style',
            $build_path . 'index.css',
            [],
            filemtime(plugin_dir_path(__DIR__) . 'build/assets/index.css')
        );

        wp_enqueue_script(
            'chatplugin-app',
            $build_path . 'index.js',
            [],
            filemtime(plugin_dir_path(__DIR__) . 'build/assets/index.js'),
            true
        );

        // pass data to react via localized script
        wp_localize_script('chatplugin-app', 'ChatPluginData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('chatplugin_nonce'),
        ]);
    }

    public function render_shortcode()
    {
        ob_start();
        echo '<div id="chatplugin-root"></div>';
        return ob_get_clean();
    }

}
