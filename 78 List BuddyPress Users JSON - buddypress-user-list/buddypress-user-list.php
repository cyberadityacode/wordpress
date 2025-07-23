<?php
/**
 * Plugin Name: BuddyPress User List
 * Description: A plugin to get BuddyPress users as JSON.
 * Version: 1.1
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

class BP_User_List_Plugin {
    public function __construct() {
        add_action('wp_ajax_get_bp_users', [$this, 'ajax_get_users']);
        add_action('wp_ajax_nopriv_get_bp_users', [$this, 'ajax_get_users']); // for non-logged-in users (optional)
    }

    public function ajax_get_users() {
        include plugin_dir_path(__FILE__) . 'includes/ajax-handler.php';
    }
}

new BP_User_List_Plugin();
