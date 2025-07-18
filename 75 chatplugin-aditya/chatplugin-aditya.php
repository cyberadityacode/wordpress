<?php
/**
 * Plugin Name: ChatPlugin Aditya
 * Text Domain: chatplugin
 * Description: React ChatPlugin for WordPress
 * Version: 1.0
 * Author: Aditya Dubey
 */

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'includes/class-chatplugin-loader.php';

function chatplugin_pro_run()
{
    $loader = new ChatPlugin_loader();
    $loader->run();
}

chatplugin_pro_run();

register_activation_hook(__FILE__, 'chatplugin_pro_install');

function chatplugin_pro_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'chatplugin_messages';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        message TEXT NOT NULL,
        sender ENUM('user', 'bot') NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

add_action('rest_api_init', function () {
    register_rest_route('chat/v1', '/messages', [
        'methods' => 'GET',
        'callback' => 'get_chat_messages',
        'permission_callback' => '__return_true'
    ]);
});

function get_chat_messages()
{
    global $wpdb;
    $table = $wpdb->prefix . 'chatplugin_messages';

    $results = $wpdb->get_results("SELECT message, sender FROM $table ORDER BY id ASC", ARRAY_A);

    return rest_ensure_response($results);
}