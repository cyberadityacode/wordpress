<?php

namespace MyAwesomePlugin\Core;
use MyAwesomePlugin\Admin;
use MyAwesomePlugin\Admin\SettingsPage;
use MyAwesomePlugin\Core;

class Init
{

    public static function run()
    {
        add_action('plugins_loaded', function () {
            $settings = new SettingsPage();
            $settings->register();

        });

        $core = new Core();



        // Optional: show a success notice
        add_action('admin_notices', function () {
            echo '<div class="notice notice-success"><p>🛠️ My Awesome Plugin is fully initialized!</p></div>';
            // echo plugin_dir_url(__FILE__) . 'admin/js/myawesomeplugin-admin.js';
        });
    }

}

