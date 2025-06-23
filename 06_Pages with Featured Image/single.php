<?php
get_header();
?>

<main>
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();
            ?>
            <article>
                <h1> <?php the_title(); ?> </h1>
                <p> <strong>Published on :</strong> <?php echo get_the_date() ?> </p>
                <div>
                    <?php the_content(); ?>
                </div>
            </article>
            <hr>

            <!-- post nagivation -->

            <div>
                <p><?php previous_post_link(); ?> | <?php next_post_link(); ?> </p>
            </div>

            <!-- Author Box -->

            <div>
                <h3>About the Author</h3>
                <p><?php the_author(); ?></p>
            </div>

            <!-- Comments Section -->

            <div>
                <?php comments_template(); ?>
            </div>

        <?php
        endwhile;
    else:
        echo "<p>No post found </p>";
    endif;
    ?>

</main>

<?php get_footer(); ?>