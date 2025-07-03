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

define("PROJECT_PLUGIN_PATH", plugin_dir_path(__FILE__));

// another constant to include js file

define("PROJECT_PLUGIN_URL", plugin_dir_url(__FILE__));

// calling action hook to add menu
add_action('admin_menu', 'project_add_admin_menu');


// add menu
function project_add_admin_menu()
{
    add_menu_page("Project Portfolio", "Project System", "manage_options", "project-system", "project_system_handle_admin_menu", "dashicons-admin-home", 23);

    // add submenu page
    add_submenu_page("project-system", "Add Project", "Add Project", "manage_options", "project-system", "project_system_handle_admin_menu");

    // add another submenu page

    add_submenu_page("project-system", "List Projects", "List Projects", "manage_options", "project-list-project", "project_system_list_project");
}

// menu handle callback
function project_system_handle_admin_menu()
{
    // echo "<h2>Welcome to Project Plugin Menu</h2>";
    // echo PROJECT_PLUGIN_PATH;
    include_once PROJECT_PLUGIN_PATH . "/pages/add-project.php";

}

// submenu callback function

function project_system_list_project()
{
    // echo "<h2>Welcome to Project List</h2>";
    include_once PROJECT_PLUGIN_PATH . "/pages/list-project.php";
}


// Register Activation Hook

register_activation_hook(__FILE__, "project_system_create_table");

function project_system_create_table()
{
    global $wpdb;
    $table_prefix = $wpdb->prefix; //wp_

    $sql = "CREATE TABLE {$table_prefix}project_system_form_data (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(254) NOT NULL,
  `client_name` varchar(254) DEFAULT NULL,
  `tech_used` varchar(254) NOT NULL,
  `project_url` varchar(254) DEFAULT NULL,
  `project_excerpt` text DEFAULT NULL,
  `project_desc` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    include_once ABSPATH . "wp-admin/includes/upgrade.php";

    dbDelta($sql);
}