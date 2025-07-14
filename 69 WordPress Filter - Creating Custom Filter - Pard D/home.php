<?php get_header(); ?>

<main>
    <h1>home.php Welcomes you</h1>
    <!-- banner -->

    <?php
    if (is_home()): ?>
        <div class="promo">🎉 Welcome to our blog! Don’t miss our latest updates</div>
    <?php endif; ?>

    <!-- Custom Filter function -->

    <?php show_greeting(); ?>

    <!-- Custom Filter Function with Arguments -->

    <?php show_discounted_price(100, 'ADITYA10'); ?>
    <?php show_discounted_price(100, 'ADITYA07'); ?>


    <?php
    if (have_posts()): ?>
        <ul>
            <?php while (have_posts()):
                the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <h2><?php the_title(); ?></h2>
                    </a>

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