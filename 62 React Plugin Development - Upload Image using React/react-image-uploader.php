<?php

/**
 * Plugin Name: React Image Uploader
 * Description: React based image upload plugin with media uploader
 * Version: 1.0
 * Author: Aditya Dubey
 */

defined('ABSPATH') || exit;

// Load the main plugin class
require_once plugin_dir_path(__FILE__) . 'includes/Plugin.php';

// Optional activation hook
register_activation_hook(__FILE__, 'riu_activate_plugin');
function riu_activate_plugin()
{
    // Optional: create DB tables or set options
}

// Plugin initialization
add_action('plugins_loaded', 'riu_init_plugin');
function riu_init_plugin()
{
    $plugin = new \RIU\Plugin();
    $plugin->run();
}
