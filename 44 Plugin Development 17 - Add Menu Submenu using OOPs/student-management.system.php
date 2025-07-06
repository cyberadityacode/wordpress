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

define('SMS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SMS_PLUGIN_URL', plugin_dir_url(__FILE__));

include_once SMS_PLUGIN_PATH . 'class/StudentManagement.php';

$studentManageObj = new StudentManagement();