<?php

/*
Plugin Name: My React Plugin 2
Description: A basic plugin with React integration.
Version: 2.0
Author: Aditya Dubey
*/

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'class-react-plugin2.php';

function run_react_plugin2()
{
    $plugin = new ReactPlugin2();
    $plugin->run();
}

run_react_plugin2();

register_activation_hook(__FILE__, ['ReactPlugin2', 'activate']);
