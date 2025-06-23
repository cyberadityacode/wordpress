<?php

get_header();

if (have_posts()):
    while (have_posts()):
        the_post();

        ?>

        <article>

            <?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                </a>
            <?php endif; ?>

            <h2>
                <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
            </h2>
            <div>
                <?php the_excerpt(); ?>
            </div>
            <p>
                <a href="<?php the_permalink(); ?>">Read More &raquo;</a>
            </p>
        </article>


        <?php
        /*  the_title('<h2>', '</h2>'); */
        ?>

        <!--  <div class="post-content">
            <?php
            /*  the_content(); */
            ?>
        </div> -->
        <?php
    endwhile;
else:
    echo "<p>No Content found</p>";
endif;


get_footer();
