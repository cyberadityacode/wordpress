<?php
/*Template Name: Blog */
get_header();
?>

<main style="padding: 2rem;">
    <h1>All aadad Projects</h1>

    <div class="project-grid"
        style="display:grid, gap:2rem, grid-template-columns: repeat(autofit, minmax(300px, 1fr));">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <div class="project-card" style="border: 1px solid #ccc; padding: 1rem; border-radius:8px;">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>"
                            style="width:300px; border-radius:8px">
                    <?php endif; ?>
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile;
        else:
            echo "<p>No Project Found</p>";
        endif;
        ?>
    </div>
</main>

<?php wp_footer(); ?>