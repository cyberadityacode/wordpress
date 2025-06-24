<?php get_header(); ?>

<h1>This is home.php</h1>

<div class="blog-layout">
    <!--  Main Blog Posts -->
    <div class="blog-posts">
        <h2>Blog Posts</h2>
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article class="single-post">
                <?php if (has_post_thumbnail()): ?>
                    <div class="post-thumb">
                        <?php the_post_thumbnail('custom-thumb'); ?>
                    </div>
                <?php endif; ?>
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>">Read more...</a>
            </article>
        <?php endwhile; else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>

    <!--  Sidebar Widgets -->
    <aside class="blog-sidebar">
        <?php
        if (is_active_sidebar('main-sidebar')) {
            dynamic_sidebar('main-sidebar');
        }
        ?>
    </aside>
</div>

<?php get_footer(); ?>
