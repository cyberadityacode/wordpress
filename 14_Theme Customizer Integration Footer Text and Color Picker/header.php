<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <style>
        :root {
            --primary-color:
                <?php echo get_theme_mod('primary_color', '#0073aa'); ?>
        }
    </style>
    <?php wp_head(); ?>
</head>

<body>

    <div class="site-branding">
        <?php
        // If logo is uploaded, show it
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            // if no logo, show site title
            echo '<h1 class="site-title">' . get_bloginfo('name') . '</h1>';
        }

        // Show tagline Description
        echo '<p class="site-description">' . get_bloginfo('description') . '</p>';

        ?>
    </div>