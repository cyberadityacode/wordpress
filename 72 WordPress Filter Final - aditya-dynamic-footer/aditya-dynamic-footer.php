<?php
/*
Plugin Name: Aditya Dynamic Footer
Description: Adds a customizable footer message on every page using WordPress filters.
Version: 1.0
Author: Aditya Dubey
*/

defined('ABSPATH') || exit;

// Step 1: Hook into footer via action
add_action('wp_footer', 'aditya_show_footer');

function aditya_show_footer() {
    // Step 2: Check if footer is enabled
    $enabled = apply_filters('aditya_footer_enable', true);
    if (!$enabled) return;

    // Step 3: Allow override for specific pages
    $override = apply_filters('aditya_footer_override', null);
    if ($override !== null) {
        $message = $override;
    } else {
        $message = apply_filters('aditya_footer_message', '🚀 Thank you for visiting Aditya’s website!');
    }

    // Step 4: Get style
    $style = apply_filters('aditya_footer_style', 'text-align:center;padding:10px;margin-top:30px;color:#555;font-size:0.95em;');

    echo "<div class='aditya-dynamic-footer' style='$style'>$message</div>";
}
