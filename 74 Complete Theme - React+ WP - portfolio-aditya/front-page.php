<?php get_header(); ?>

<main>
    <section class="hero-section" style="text-align: center; padding: 3rem 1rem; background: #f9f9f9;">
        <div class="hero-image">
            <?php if (get_theme_mod('hero_image')): ?>
                <img src="<?php echo esc_url(get_theme_mod('hero_image')); ?>" alt="Hero Image"
                    style="max-width:200px; border-radius:50%;">
            <?php endif; ?>
        </div>

        <h1 style="font-size:2.5rem; margin-top:1rem;">
            <?php echo esc_html(get_theme_mod('hero_name', 'Your Name')); ?>
        </h1>

        <p style="font-size:1.2rem; max-width: 600px; margin: 1rem auto;">
            <?php echo esc_html(get_theme_mod('hero_about', 'About info goes here...')); ?>
        </p>
    </section>

    <div id="react-root"></div>
    <!-- <div id="react-root-about"></div> -->
</main>

<?php get_footer() ?>