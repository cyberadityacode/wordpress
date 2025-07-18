<footer class="site-footer">
    <div class="footer-content">
        <p><?php echo esc_html(get_theme_mod('footer_text')); ?></p>

        <ul class="footer-socials">
            <?php foreach (['github', 'twitter', 'linkedin', 'instagram'] as $social):
                $link = get_theme_mod("footer_{$social}_link");
                if ($link): ?>
                    <li>
                        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">
                            <?php echo ucfirst($social); ?>
                        </a>
                    </li>
                <?php endif;
            endforeach; ?>
        </ul>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>