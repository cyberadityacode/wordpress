<?php get_header(); ?>

<main>
    <h1>Index.php Welcomes you</h1>

    <?php
    if (have_posts()): ?>
        <ul>
            <?php while (have_posts()):
                the_post(); ?>
                <li>
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_excerpt(); ?></p>
                    <small>
                        <?php the_content(); ?>
                    </small>
                </li>

                <?php
            endwhile;
            ?>
        </ul>
        <?php
    else:
        echo "<p>Ask your blogger to write something</p>";
    endif;
    ?>
</main>

<?php get_footer(); ?>