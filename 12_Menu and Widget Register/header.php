<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo(show: 'name'); ?></title>
    <?php wp_head(); ?>
</head>

<?php
// Displaying Menu Navigation
wp_nav_menu(array(
    'theme_location' => 'main-menu', //it must match the key used in register_nav_menus
    'container' => 'nav', //wraps the menu inside nav
    'menu_class' => 'main-nav' //css class for styling the menu
));
?>

<body>