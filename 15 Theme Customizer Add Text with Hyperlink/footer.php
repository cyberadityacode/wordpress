<!-- <p><?php echo date('Y') ?> &copy; - <?php bloginfo('name'); ?></p> -->

<p><?php echo get_theme_mod('footer_text'); ?></p>
<p><?php echo get_theme_mod('custom_footer_link'); ?></p>


<?php
$link_text = get_theme_mod('footer_link_text', 'Gihub Profile');
$link_url = get_theme_mod('footer_link_url', 'https://www.github.com/cyberadityacode');
$open_newtab = get_theme_mod('footer_link_new_tab', true);

// only show the link if both are filled

if (!empty($link_text) && !empty($link_url)): ?>

    <!--  <div class="footer-custom-link">
        <a href="<?php echo esc_url($link_url); ?>" target="_blank">
            <?php echo esc_html($link_text); ?>

        </a>
    </div> -->


    <div class="footer-custom-link">
        <a href="<?php echo esc_url($link_url); ?>" <?php echo $open_newtab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
            <?php echo esc_html($link_text); ?>
        </a>
    </div>
<?php endif; ?>



<?php wp_footer(); ?>
</body>

</html>