<?php
/*
Plugin Name: Student Management System
Description: First Plugin using PHP OOPs to manage student data
Plugin URI: https://www.adityadubeytest.web.app/
Author: Aditya Dubey
Author URI: https://www.adityadubeytest.web.app/
Version: 1.0
Requires PHP: 7.4
Requires at least: 6.3.2
*/

defined('ABSPATH') || exit;

define('SMS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SMS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the class file
require_once SMS_PLUGIN_PATH . 'class/StudentManagement.php';

// Register activation hook with static method
register_activation_hook(__FILE__, ['StudentManagement', 'createStudentTable']);

// Register Deactivation hook with static method

register_deactivation_hook(__FILE__, ['StudentManagement', 'dropStudentTable']);

// Instantiate the class only after WordPress is fully loaded
add_action('plugins_loaded', function () {
    new StudentManagement();
});
