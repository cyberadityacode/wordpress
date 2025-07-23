<?php

namespace MyAwesomePlugin\Admin;

class SettingsPage
{
    public function register()
    {
        add_action('admin_menu', [$this, 'addPluginMenu']);
    }

    public function addPluginMenu()
    {
        add_menu_page(
            'Awesome Plugin Settings',
            'Awesome Plugin',
            'manage_options',
            'awesome-plugin',
            [$this, 'renderedSettingsPage'],
            'dashicons-admin-generic'
        );

    }

    public function renderedSettingsPage()
    {
        ?>
            <div class="wrap">
                <h1>My Awesome Plugin</h1>
                <p>This is where our plugin settings exist</p>
                <p>Here We can render our React Root</p>
                <input type="text" id="username" name="username" placeholder="Enter Username...">
                <button id="sendButton">Send</button>
            </div>
        <?php
    }
}