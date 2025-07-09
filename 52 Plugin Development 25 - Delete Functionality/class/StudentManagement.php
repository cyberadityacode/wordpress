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

    // List Students with Delete Handling
    public function listStudentCallback()
    {
        global $wpdb;

        // Handle delete action
        if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
            $student_id = intval($_GET['id']);
            $nonce_key = 'delete_student_' . $student_id;

            if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], $nonce_key)) {
                wp_die('Security check failed.');
            }

            $deleted = $wpdb->delete(
                $wpdb->prefix . 'student_system',
                ['id' => $student_id],
                ['%d']
            );

            if ($deleted !== false) {
                echo '<div class="notice notice-success is-dismissible"><p>Student deleted successfully.</p></div>';
            } else {
                echo '<div class="notice notice-error is-dismissible"><p>Failed to delete student.</p></div>';
            }
        }

        $students = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}student_system", ARRAY_A);
        include_once SMS_PLUGIN_PATH . 'pages/list-student.php';
    }

    // Return Student Data
    public function getStudentData($student_id)
    {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$wpdb->prefix}student_system WHERE id=%d", $student_id),
            ARRAY_A
        );
    }

    // Add / Edit / View Student
    public function addStudentCallback()
    {
        global $wpdb;

        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
        $student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $this->action = $action;

        $student = [];

        if (($action === 'edit' || $action === 'view') && $student_id > 0) {
            $student = $this->getStudentData($student_id);
        }

        // Save on POST if not view
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_submit']) && $action !== 'view') {
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
        $email = sanitize_email($_POST['email']);
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

            $this->message = $updated !== false ? "Student updated successfully." : "Failed to update student.";
            $this->status = $updated !== false ? 1 : 0;
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

            $this->message = $insert_id > 0 ? "Student added successfully." : "Error while saving data.";
            $this->status = $insert_id > 0 ? 1 : 0;
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
