<?php

class StudentManagement
{
    public function __construct()
    {
        add_action("admin_menu", array($this, "addAdminMenus"));
    }

    public function addAdminMenus()
    {
        //Plugin Menu
        add_menu_page('Student System', 'Student System', 'manage_options', 'student-system', '', 'dashicons-admin-home');

        // Plugin Submenu List Student
        add_submenu_page('student-system', 'List Student', 'List Student', 'manage_options', 'student-system', array($this, 'listStudentCallback'));

        // Plugin Submenu Add Student
        add_submenu_page('student-system', 'Add Student', 'Add Student', 'manage_options', 'add-student', array($this, 'addStudentCallback'));
    }

    // List Student Callback
    public function listStudentCallback()
    {
        echo '<h2>List Students</h2>';
    }

    // Add Student Callback
    public function addStudentCallback()
    {
        echo '<h2>Add Student</h2>';
    }
}