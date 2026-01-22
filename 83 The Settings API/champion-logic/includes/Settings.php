<?php //phpcs:ignoreFile

namespace CHAMPION_LOGIC;
class Settings{
    public function __construct()
    {
        error_log("Settings initialized" . $_SERVER['REQUEST_URI']);
        add_action('admin_init', [$this, 'register_custom_settings']);
    }
    public function register_custom_settings(){
        register_setting(
            'champion_logic_settings_group',
            'champion_logic_signature_text',
            [
                'sanitize_callback' => 'sanitize_text_field',
            ]
        );
        add_settings_section(
            'champion_logic_general_section',
            __('General Settings', 'champion-logic'),
            [$this, 'section_description'],
            'champion-logic'
        );

        add_settings_field(
            'signature_input_field',
            __('Signature Text', 'champion-logic'),
            [$this, 'callback_input_field'],
            'champion-logic',
            'champion_logic_general_section'
        );
    }

    public function section_description(){
        echo '<p>' . esc_html__('Configure the signature shown on posts', 'champion-logic') . '</p>'; 
    }

    public function callback_input_field(){
        $current_value = get_option( 'champion_logic_signature_text','' );
        ?>
        <input type="text" name="champion_logic_signature_text" value="<?php echo esc_attr($current_value); ?>" class="regular-text">
        <?php
    }
}