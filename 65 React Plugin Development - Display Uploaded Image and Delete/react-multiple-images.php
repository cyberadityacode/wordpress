<?php

/**
 * Plugin Name: React Multiple Image Upload
 * Description: Upload Images with React and Display as Gallery
 * Author: Aditya Dubey
 * Version: 1.0
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/ReactImageUploader.php';

register_activation_hook(__FILE__, ['ReactImageUploader', 'activate']);

$plugin = new ReactImageUploader();
$plugin->run();