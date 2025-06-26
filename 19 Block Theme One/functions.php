<?php
// my-block-theme/functions.php

function my_block_theme_support() {
    add_theme_support('editor-styles');
}
add_action('after_setup_theme', 'my_block_theme_support');
