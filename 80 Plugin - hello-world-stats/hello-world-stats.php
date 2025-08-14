<?php
/**
 * Plugin Name: Hello World Stats
 * Description: Display System stats in Dashboard
 * Version: 1.0.0
 * Author: Aditya Dubey
 * Text Domain: hello-world-stats
 * PHP version 7.4
 * 
 * @category WordPress_Plugin
 * @package  HelloWorldStats
 * @author   Aditya Dubey <your-email@example.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @link     https://yourwebsite.example.com/hello-world-stats
 */

// Security Check
defined('ABSPATH') || exit;

/**
 * Main Plugin Class for Hello World Stats.
 *
 * Handles the core functionality of the Hello World Stats plugin.
 *
 * @category WordPress_Plugin
 * @package  HelloWorldStats
 * @author   Aditya Dubey <your-email@example.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @link     https://yourwebsite.example.com/hello-world-stats
 */
class Hello_World_Stats
{
    /**
     * Constructor for the Hello_World_Stats class.
     *
     * Hooks the dashboard widget setup action.
     */
    public function __construct()
    {
        // Dashboard Widget Hook
        add_action('wp_dashboard_setup', [$this, 'addDashboardWidget']);

        // Load Scripts
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    /**
     * Enqueue admin scripts for the Hello World Stats plugin.
     *
     * @return void
     */
    public function enqueueAssets()
    {
        wp_enqueue_script(
            'hello-world-stats-js',
            plugin_dir_url(__FILE__) . 'assets/js/admin.js',
            ['jquery'],
            '1.0.0',
            true
        );
    }

    /**
     * Adds the dashboard widget for server statistics.
     *
     * @return void
     */
    public function addDashboardWidget()
    {
        wp_add_dashboard_widget(
            'hello_world_stats_widget', 
            __('Server Statistics', 'hello-world-stats'),
            [$this, 'renderWidget']
        );
    }

    /**
     * Renders the server statistics widget content.
     *
     * @return void
     */
    public function renderWidget()
    {
        echo '<div id="hello-world-stats-container">';
        echo '<p>PHP Version: '. phpversion() . '</p>';
        echo '<p>Memory Usage: <span id="memory-usage">Calculating...</span></p>';
        echo '</div>';
    }
    
}

// Initialize plugin
new Hello_World_Stats();
