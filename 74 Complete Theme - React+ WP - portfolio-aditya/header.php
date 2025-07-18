<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <h1><?php bloginfo('name'); ?></h1>
    <p style="margin-top: -15px; font-style:italic;"><?php bloginfo('description'); ?></p>

    <header>
     <!--    <nav>
            <a href="<?php echo home_url(); ?>">Home</a>
        </nav> -->
        <div id="react-root-nav"></div>
    </header>