<?php
/**
 * Plugin Name: BuddyPress User List
 * Description: A plugin to get BuddyPress users and friends as JSON.
 * Version: 1.1
 * Author: Your Name
 */

if (!defined('ABSPATH'))
    exit;

require_once plugin_dir_path(__FILE__) . 'includes/class-user-endpoints.php';
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Initialize the plugin
new BP_User_Endpoints();
