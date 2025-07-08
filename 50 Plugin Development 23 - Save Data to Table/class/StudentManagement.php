<?php
defined('ABSPATH') || exit;

class StudentManagement
{
    private $message = '';
    private $status = '';
    public function __construct()
    {
        add_action("admin_menu", array($this, "addAdminMenus"));

        // add scripts
        add_action("admin_enqueue_scripts", [$this, "addStudentPluginFiles"]);
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
        // form submission code
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['btn_submit'])) {
            /*   echo "<pre>";
            print_r($_POST); */
            $this->saveStudentFormData();
        }

        $displayMessage =  $this->message;
        $displayStatus =  $this->status;

        // echo '<div class="wrap"><h1>Add New Student</h1><p>This will have a form to add a new student.</p></div>';
        include_once SMS_PLUGIN_PATH . 'pages/add-student.php';
    }

    // Save Student Form Data
    private function saveStudentFormData()
    {
        global $wpdb;
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_text_field($_POST['email']);
        $gender = sanitize_text_field($_POST['gender']);
        $phone = sanitize_text_field($_POST['phone']);

        $wpdb->insert($wpdb->prefix . 'student_system', array(
            'name' => $name,
            'email' => $email,
            'gender' => $gender,
            'phone_no' => $phone,
        ));

        $student_id = $wpdb->insert_id;

        if ($student_id > 0) {
            // data saved
            $this->message = "Student Data Saved Successfully";
            $this->status = 1;
        } else {
            //data not saved
            $this->message = "Error while saving data";
            $this->status = 0;
        }
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

    // add plugin files
    public function addStudentPluginFiles()
    {
        // add styles
        wp_enqueue_style('datatable-css', SMS_PLUGIN_URL . 'assets/css/dataTables.dataTables.min.css', array(), '1.0', 'all');
        wp_enqueue_style('custom-css', SMS_PLUGIN_URL . 'assets/css/custom.css', array(), filemtime(SMS_PLUGIN_URL . 'assets/css/custom.css'), 'all');
        // add script
        wp_enqueue_script('datatable-script', SMS_PLUGIN_URL . 'assets/js/dataTables.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('custom-script', SMS_PLUGIN_URL . 'assets/js/script.js', array('jquery'), '1.0', true);
    }
}
