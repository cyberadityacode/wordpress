<?php
get_header();
?>

<main style="padding: 2rem;">
    <h1>All Projects</h1>

    <div class="project-grid" style="
        display: grid;
        gap: 2rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    ">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <div class="project-card" style="
                    border: 1px solid #ccc;
                    padding: 1rem;
                    border-radius: 8px;
                    background: #fff;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                ">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" style="
                            width: 100%;
                            height: auto;
                            border-radius: 8px;
                            margin-bottom: 1rem;
                        ">
                    <?php endif; ?>
                    <h2 style="font-size: 1.25rem; margin-bottom: 0.5rem;"><?php the_title(); ?></h2>
                    <p style="font-size: 1rem;"><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile;
        else:
            echo "<p>No Project Found</p>";
        endif;
        ?>
    </div>
</main>

<?php wp_footer(); ?>
