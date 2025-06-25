<article id="<?php the_ID(); ?>" <?php post_class(); ?>>

    <!-- display post title -->
    <header class="entry-header">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </header>

    <!-- display post summary(excerpt) -->
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
</article>