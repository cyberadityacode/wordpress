<?php get_header(); ?>

<main>
    <section class="hero">
        <h1>Welcome to my Website</h1>
        <p>This is custom homepage built with WordPress</p>
        <a href="/about" class="btn">Learn More</a>
    </section>

    <section class="features">
        <h2>What I do</h2>
        <div class="feature-boxes">
            <div class="box">
                <h3>Web Design</h3>
                <p>I create responsive and Modern Websites</p>
            </div>
            <div class="box">
                <h3>Blog</h3>
                <p>I write about Wordpress, tech and tutorials</p>
            </div>
        </div>
    </section>

    <section class="latest-posts">
        <h2>Latest Blog Posts</h2>

        <?php
        $latest_posts = new WP_Query(array(
            'posts_per_page' => 3
        ));

        if ($latest_posts->have_posts()):
            echo '<ul>';
            while ($latest_posts->have_posts()):
                $latest_posts->the_post();
                ?>
                <li>
                    <a href="<?php the_permalink() ?>"> <?php the_title(); ?></a>
                </li>

                <?php
            endwhile;
            echo "</ul>";
            wp_reset_postdata();
        else:
            echo "<p>No Recent posts found </p>";
        endif;
        ?>

        <p class="view-all-posts">
            <!-- <?php echo get_permalink( get_option('page_for_posts') ); ?> -->
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">
                View all Posts &raquo;
            </a>
        </p>
    </section>
</main>


<?php get_footer(); ?>