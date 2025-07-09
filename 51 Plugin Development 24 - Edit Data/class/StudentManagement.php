<?php
defined('ABSPATH') || exit;

class StudentManagement
{
    private $message = '';
    private $status = '';
    private $action = "";

    public function __construct()
    {
        add_action("admin_menu", array($this, "addAdminMenus"));
        add_action("admin_enqueue_scripts", [$this, "addStudentPluginFiles"]);
    }

    // Register Admin Menus and Submenus
    public function addAdminMenus()
    {
        add_menu_page(
            'Student System',
            'Student System',
            'manage_options',
            'student-system',
            [$this, 'listStudentCallback'],
            'dashicons-welcome-learn-more',
            25
        );

        add_submenu_page(
            'student-system',
            'List Student',
            'List Student',
            'manage_options',
            'student-system',
            [$this, 'listStudentCallback']
        );

        add_submenu_page(
            'student-system',
            'Add Student',
            'Add Student',
            'manage_options',
            'add-student',
            [$this, 'addStudentCallback']
        );
    }

    // List Students (you can implement as needed)
    public function listStudentCallback()
    {
        global $wpdb;
        $students = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student_system", ARRAY_A);
        include_once SMS_PLUGIN_PATH . 'pages/list-student.php';
    }

    // Add or Edit Student
    public function addStudentCallback()
    {
        global $wpdb;

        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
        $student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $student = [];
        $this->action = $action;

        // Fetch student data for edit
        if ($action === 'edit' && $student_id > 0) {
            $student = $wpdb->get_row(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}student_system WHERE id = %d", $student_id),
                ARRAY_A
            );
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_submit'])) {
            if (
                isset($_POST['student_nonce']) &&
                wp_verify_nonce($_POST['student_nonce'], 'save_student_data')
            ) {
                $this->saveStudentFormData();
            }
        }

        $displayMessage = $this->message;
        $displayStatus = $this->status;

        include_once SMS_PLUGIN_PATH . 'pages/add-student.php';
    }

    // Save or Update Student Data
    private function saveStudentFormData()
    {
        global $wpdb;

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_text_field($_POST['email']);
        $gender = sanitize_text_field($_POST['gender']);
        $phone = sanitize_text_field($_POST['phone']);
        $student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;

        if ($student_id > 0) {
            // Update
            $updated = $wpdb->update(
                $wpdb->prefix . 'student_system',
                [
                    'name' => $name,
                    'email' => $email,
                    'gender' => $gender,
                    'phone_no' => $phone,
                ],
                ['id' => $student_id],
                ['%s', '%s', '%s', '%s'],
                ['%d']
            );

            if ($updated !== false) {
                $this->message = "Student updated successfully.";
                $this->status = 1;
            } else {
                $this->message = "Failed to update student.";
                $this->status = 0;
            }
        } else {
            // Insert
            $wpdb->insert(
                $wpdb->prefix . 'student_system',
                [
                    'name' => $name,
                    'email' => $email,
                    'gender' => $gender,
                    'phone_no' => $phone,
                ],
                ['%s', '%s', '%s', '%s']
            );

            $insert_id = $wpdb->insert_id;

            if ($insert_id > 0) {
                $this->message = "Student added successfully.";
                $this->status = 1;
            } else {
                $this->message = "Error while saving data.";
                $this->status = 0;
            }
        }
    }

    // Create student table on activation
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

    // Drop student table on uninstall (optional)
    public static function dropStudentTable()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'student_system';
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    // Load CSS/JS files
    public function addStudentPluginFiles()
    {
        wp_enqueue_style('datatable-css', SMS_PLUGIN_URL . 'assets/css/dataTables.dataTables.min.css', [], '1.0');
        wp_enqueue_style('custom-css', SMS_PLUGIN_URL . 'assets/css/custom.css', [], '1.0');
        wp_enqueue_script('datatable-script', SMS_PLUGIN_URL . 'assets/js/dataTables.min.js', ['jquery'], '1.0', true);
        wp_enqueue_script('custom-script', SMS_PLUGIN_URL . 'assets/js/script.js', ['jquery'], '1.0', true);
    }
}
