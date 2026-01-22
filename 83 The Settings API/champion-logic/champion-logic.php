<?php 
/** @var array $_SERVER */
//phpcs:ignoreFile
/**
 * Plugin Name: Champion Logic
 * Description: Logic test plugin.
 *
 * @package Champion_Logic
 * Author     : Aditya Dubey
 * Text-Domain: champion-logic
 * Version    : 1.0.0
 */

// Exit, if accessed directly.
if( !defined('ABSPATH')){
    exit;
}

class Champion_Logic {
    public function __construct()
    {
        add_action('wp', [$this, 'log_once']);
        // echo 'Hello';
        // exit;

        add_filter('the_content', [$this, 'add_signature_content']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    public function log_once(){
        error_log("Main Request only ". $_SERVER['REQUEST_URI']);
    }

    public function add_signature_content($content){
        if(is_singular('post')){
            $signature_text = get_option(
                'champion_logic_signature_text',
                __('This post is verified by Champion Logic', 'champion-logic')
            );

            if(!empty($signature_text)){
                $content = '<p><em>'. esc_html($signature_text). '</em></p>';
            }
        }
        return $content;
    }

    public function add_admin_menu(){
        add_menu_page('Champion Logic', 'Champion Menu Title', 'manage_options', 'champion-logic', [$this, 'create_admin_page'] );
    }
    //Must be static because it's called before the class is instantiated.
    public static function activate(){
        error_log('Champion Logic Plugin Activated');
    }

    public static function deactivate(){
        error_log('Champion Logic Plugin Deactivated');
    }

    public function create_admin_page(){
        ?>
            <div class="wrap">
                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                <p><?php esc_html_e('Welcome to the Settings Page!', 'champion-logic'); ?></p>

                <form method="post" action="options.php">
                    <?php
                        settings_fields('champion_logic_settings_group');
                        do_settings_sections('champion-logic');
                        submit_button();
                    ?>
                </form>
            </div>
        <?php
    }
}

new Champion_Logic();

register_activation_hook(__FILE__, ['Champion_Logic', 'activate']);
register_deactivation_hook(__FILE__, ['Champion_Logic', 'deactivate']);

require_once plugin_dir_path(__FILE__) . 'includes/Settings.php';
new CHAMPION_LOGIC\Settings();