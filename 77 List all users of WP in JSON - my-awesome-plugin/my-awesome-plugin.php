<?php

/**
 * Plugin Name:       My Awesome Plugin
 * Plugin URI:        https://ideawp.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version: 1.11.0
 * Author:            IdeaWP
 * Author URI:        https://ideawp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpchat
 * Domain Path:       /languages
 * Requires PHP:      8.0
 *
 * @package myAwesomePlugin
 */

// If this file is called directly, abort
if (!defined('WPINC')) {
    die;
}

// check PHP version
if (version_compare(PHP_VERSION, '8.0', '<')) {
    add_action('admin_notices', function () {
        ?>
        <div class="notice notice-error">
            <p><?php echo "my awesome plugin requires PHP version greater than 8.0, Please upgrade your version" ?></p>
        </div>
        <?php
    });

    return;
}


// Composer Autoload

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>Composer Autoload Not Found </p></div>';
    });
    return;
}

// call your class

if (class_exists(\MyAwesomePlugin\Core\Init::class)) {
    \MyAwesomePlugin\Core\Init::run();
}

define('MYAWESOMEPLUGIN_VERSION', '1.0');
define('MYAWESOMEPLUGIN_DIR', plugin_dir_path(__FILE__));
define('MYAWESOMEPLUGIN_URL', plugin_dir_url(__FILE__));

