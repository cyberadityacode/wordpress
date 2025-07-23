<?php

namespace MyAwesomePlugin;
use MyAwesomePlugin\Ajax;

class Core
{
    protected $plugin_name;
    protected $version;

    protected $settings_object;

    public $settings;

    public function __construct()
    {
        $this->version = defined('MYAWESOMEPLUGIN_VERSION') ? MYAWESOMEPLUGIN_VERSION : '1.0';
        $this->plugin_name = 'myawesomeplugin';
        $this->define_admin_hooks();

        Ajax::run();
        
    }

    public function getPluginName()
    {
        return $this->plugin_name;
    }

    public function getPluginVersion()
    {
        return $this->version;
    }

    public function define_admin_hooks()
    {
        $plugin_admin = new Admin($this->plugin_name, $this->version);
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));
    }

}