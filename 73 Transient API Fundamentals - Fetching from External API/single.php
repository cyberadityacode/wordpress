<?php get_header(); ?>

<main id="main-content">
    <h1>Single Post</h1>
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-meta">
                    <span>By <?php the_author(); ?></span>
                    <span>On <?php the_date(); ?></span>
                </div>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                <?php comments_template(); ?>
            </article>
        <?php endwhile;
    else:
        echo "<p>Ask your blogger to write post </p>";
    endif;
    ?>

</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>