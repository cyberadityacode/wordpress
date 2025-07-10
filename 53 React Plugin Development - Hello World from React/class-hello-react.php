<?php

defined('ABSPATH') || exit;
class HelloReact
{
    private $page_hook = "";
    public function run()
    {
        add_action('admin_menu', callback: [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        // add_action('admin_footer', [$this, 'inject_react_root']);
    }


    /*     public function inject_react_root()
        {
            echo '<div id="my-react-app" style="padding: 20px;"></div>';
        } */

    public function add_menu()
    {
        $this->page_hook = add_menu_page(
            'Hello React',
            'Hello React',
            'manage_options',
            'hello-react',
            [$this, 'render_page'],
            'dashicons-smiley',
            100
        );
    }

    public function enqueue_assets($hook)
    {
        // load only on our page

        if ($hook !== $this->page_hook) {
            return;
        }

        $asset_url = plugin_dir_url(__FILE__) . 'build/index.js';
        wp_enqueue_script('my-react-script', $asset_url, [], '1.0', true);
    }

    public function render_page()
    {
        echo "<div class='wrap'>";
        echo "<h1>Hello React App from PHP</h1>";
        echo "<div id='my-react-app'></div>";
        echo "</div>";
    }
}
