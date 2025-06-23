<?php get_header(); ?>


<main>
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();
            ?>
            <article>
                <!-- featured image (thumbnail) of the page -->

                <?php if(has_post_thumbnail()): ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                <?php endif; ?>
                <!-- title of the page -->
                <h1><?php the_title(); ?></h1>

                <!-- Content of the page -->
                <div>
                    <?php the_content(); ?>
                </div>
            </article>

            <?php
        endwhile;
    else:
        echo "<p>No Page found.</p>";

    endif;
    ?>

</main>


<?php
get_footer();
?>