<?php

/*
Plugin Name: Custom Plugin
Description: Sample Plugin to learn plugin development
Plugin URI: https://www.adityadubeytest.web.app
Author: Aditya Dubey
Author URI: https://www.adityadubeytest.web.app
Version: 1.0
Requires at least: 6.3.2
Requires PHP: 7.4

*/

// calling action hook to add menu
add_action('admin_menu', 'cp_add_admin_menu');


// add menu
function cp_add_admin_menu()
{
    add_menu_page("Custom Plugin Menu", "Custom Plugin", "manage_options", "cp-plugin", "cp_handle_admin_menu", "dashicons-admin-home", 23);
}

// menu handle callback
function cp_handle_admin_menu()
{
    echo "<h2>Welcome to Custom Plugin Menu</h2>";
}