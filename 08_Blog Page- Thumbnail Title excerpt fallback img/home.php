<?php get_header(); ?>

<main>
    <h1>Latest Blog Posts</h1>

    <div class="post-grid">
        <?php
        if (have_posts()):
            while (have_posts()): the_post();
                ?>
                <article class="post-card">
                    <!-- Thumbnail -->
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('thumbnail');
                        } else {
                            echo '<img src="' . get_template_directory_uri() . '/assets/images/default.jpg" alt="Default Image" />';
                        }
                        ?>
                    </a>

                    <!-- Title -->
                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <!-- Excerpt -->
                    <div class="excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                    <!-- Read more -->
                    <p>
                        <a href="<?php the_permalink(); ?>">
                            Read more &raquo;
                        </a>
                    </p>
                </article>
                <?php
            endwhile;

            // Pagination
            the_posts_pagination();

        else:
            echo '<p>No posts found.</p>';
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
