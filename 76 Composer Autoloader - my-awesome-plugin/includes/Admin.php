<?php

namespace MyAwesomePlugin;

class Admin
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugins_url('admin/css/myawesomeplugin-admin.css', dirname(__FILE__)),
            array(),
            $this->version,
            'all'
        );
    }


    public function enqueue_scripts()
    {

        // error_log('Script URL: ' . plugin_dir_url(__FILE__) . '/admin/js/myawesomeplugin-admin.js');
        wp_enqueue_script(
            $this->plugin_name,
            plugins_url('admin/js/myawesomeplugin-admin.js', dirname(__FILE__)),
            array('jquery'),
            $this->version,
            true
        );
    }


}