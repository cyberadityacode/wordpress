<?php get_header(); ?>

<main>
    <h1>All Projects (Archive Page)</h1>
    <?php if (have_posts()): ?>
        <div class="projects-list">
            <?php while (have_posts()): the_post(); ?>
                <div class="single-project">
                    <h2><?php the_title(); ?></h2>
                    <?php the_excerpt(); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else: ?>
        <p>No projects found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
