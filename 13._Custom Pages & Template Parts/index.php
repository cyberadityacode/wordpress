<!-- This is the main file that loads blog posts using get_template_part(): -->

<?php get_header(); ?>

<main>
    <?php if (have_posts()): ?>
        <?php while (have_posts()):
            the_post(); ?>

            <?php get_template_part('template-parts/content'); ?>

        <?php endwhile ?>
            <!-- <h2>HELLOOOWWWW</h2> -->
        <!-- Pagination Link -->
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'prev_text' => '&laquo; Prev',
                'next_text' => 'Next &raquo;',
                'mid_size' => 2
            ));
            ?>
        </div>

    <?php else: ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>


</main>


<?php get_footer(); ?>