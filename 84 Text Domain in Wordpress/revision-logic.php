<?php //phpcs:ignoreFile
/**
 * Plugin Name: Revision Logic
 * Description: Revision Plugin ka Description
 * Author: Aditya Dubey
 * Version: 1.0.0
 * @package Revision_Logic
 * Text-Domain: revision-logic
 */

if(!defined('ABSPATH')){
    exit;
}

class Revision_Logic {
    private const MENU_SLUG = 'revision-logic';

    public function __construct()
    {
        // error_log("Revision Logic Loaded" . $_SERVER['REQUEST_URI']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    public function add_admin_menu(){
        add_menu_page(__('Revision','revision-logic'), __('Revision Menu', 'revision-logic'), 'manage_options', self::MENU_SLUG,[$this, 'create_admin_page']);
    }

    public function create_admin_page(){
        ?>
        <div class="wrap">
            <h1><?php echo esc_html_e('Revision Logic Page', 'revision-logic') ?></h1>
        </div>
        <?php
    }
    public static function activate_hoja(){
        error_log("Welcome bhai");
    }

    public static function deactivate_hoja(){
        error_log("Bye Bhai");
    }
}

new Revision_Logic();

register_activation_hook(__FILE__, ['Revision_Logic', 'activate_hoja'] );
register_deactivation_hook(__FILE__, ['Revision_Logic', 'deactivate_hoja'] );
