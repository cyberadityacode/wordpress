<?php
$footer_text = get_theme_mod('ajax_theme_three_footer_text', '');
if (!empty($footer_text)) {
    echo '<p>' . esc_html($footer_text) . '</p>';
}

?>

<?php wp_footer(); ?>
</body>

</html>