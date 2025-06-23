<?php get_header(); ?>

<main>
    <h1>Blog</h1>

    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();

            ?>
            <article>
                <?php
                if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>

                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <div>
                    <?php the_excerpt(); ?>
                </div>

                <a href="<?php the_permalink(); ?>">
                    Read More &raquo;
                </a>
                <hr>
            </article>
            <?php
        endwhile;

        // add pagination
        the_posts_pagination();

    else:
        echo '<p>No Post Found </p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>