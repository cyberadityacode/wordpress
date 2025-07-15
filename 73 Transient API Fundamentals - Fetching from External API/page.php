<?php get_header(); ?>

<main>
    <h1>Page.php</h1>
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post(); ?>
            <article>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php else:
        echo "<p>No Content Found</p>";
    endif;
    ?>
</main>

<?php get_footer(); ?>