<?php
/**
 * Plugin Name: Aditya Greeting Banner
 * Description: Display a customizable greeting banner above the blog posts using filters
 * Version: 1.0
 * Author: Aditya Dubey
 */

defined('ABSPATH') || exit;


// Step 1 Display Banner

function agb_display_geeting($content)
{
    if (!is_single() || !is_main_query())
        return $content;


    // Allow devs to disable banner
    $show = apply_filters('agb_show_banner', true);
    if (!$show) return $content;

    // Step 2: Filter Greeting Message
    $greeting = apply_filters('agb_greeting_text', '🙏 Welcome, dear reader!');

    // Step 3: Filter Greeting Style
    $style = apply_filters('agb_greeting_style', 'padding:10px; background:#f0f8ff; border-left:4px solid #0073aa; font-size:1.1em; margin-bottom:15px;');

    $banner = "<div class='aditya-greeting-banner' style=\"$style\">$greeting</div>";

    return $banner . $content;
}

add_filter('the_content', 'agb_display_geeting');

// customize filter

add_filter('agb_greeting_text', function ($msg) {
    return "Namaste! You're reading something special";
});

add_filter('agb_greeting_text', function ($style) {
    return $style . ' color: #333; font-family: Georgia;';
});

/* add_filter('agb_show_banner', function() {
    return !is_user_logged_in(); // Only show to guests
}); */