<?php

/*
Plugin Name: My React Hello Plugin
Description: A basic plugin with React integration.
Version: 1.0
Author: Aditya Dubey
*/

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'class-hello-react.php';

function run_hello_react()
{
    $plugin = new HelloReact();
    $plugin->run();
}

run_hello_react();