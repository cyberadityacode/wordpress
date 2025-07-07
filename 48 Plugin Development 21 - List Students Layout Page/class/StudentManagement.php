<?php
defined('ABSPATH') || exit;

class StudentManagement
{
    public function __construct()
    {
        add_action("admin_menu", array($this, "addAdminMenus"));
    }

    // Register Admin Menus and Submenus
    public function addAdminMenus()
    {
        // Main Menu
        add_menu_page(
            'Student System',
            'Student System',
            'manage_options',
            'student-system',
            [$this, 'listStudentCallback'],
            'dashicons-welcome-learn-more',
            25
        );

        // Submenu: List Students (same callback as main menu)
        add_submenu_page(
            'student-system',
            'List Student',
            'List Student',
            'manage_options',
            'student-system',
            [$this, 'listStudentCallback']
        );

        // Submenu: Add Student
        add_submenu_page(
            'student-system',
            'Add Student',
            'Add Student',
            'manage_options',
            'add-student',
            [$this, 'addStudentCallback']
        );
    }

    // Callback for listing students
    public function listStudentCallback()
    {
        // echo '<div class="wrap"><h1>List of Students</h1><p>This will display all student entries.</p></div>';
        include_once SMS_PLUGIN_PATH . 'pages/list-student.php';
    }

    // Callback for adding a student
    public function addStudentCallback()
    {
        // echo '<div class="wrap"><h1>Add New Student</h1><p>This will have a form to add a new student.</p></div>';
        include_once SMS_PLUGIN_PATH . 'pages/add-student.php';
    }

    // Static method to create the table during plugin activation
    public static function createStudentTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'student_system';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            gender ENUM('male','female','other') DEFAULT NULL,
            phone_no VARCHAR(25) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    // drop table
    public static function dropStudentTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'student_system';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($sql);
    }
}
