<?php
/**
 * Template Name: Projects Page
 */

get_header(); ?>

<section>
    echo '<p style="color:red; text-align:center;">This is Projects Page Template</p>';
    <h1>Welcome to project page</h1>
    <section class="our-projects">
        <?php
        $projects_query = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => 3,
            'post_status' => 'publish'
        ));

        if ($projects_query->have_posts()):
            echo "<h2>Our Projects</h2>";
            echo '<div class="projects-list">';
            while ($projects_query->have_posts()):
                $projects_query->the_post(); ?>

                <div class="single-project">
                    <h3><?php the_title(); ?></h3>

                    <?php if (has_post_thumbnail()): ?>
                        <div class="projects-thumbnail">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="project-content">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>">Read More</a>
                </div>
            <?php endwhile;
            echo "</div>";
            wp_reset_postdata();
        else:
            echo '<p>No Projects Found ---</p>';
        endif;
        ?>
    </section>
</section>

<?php get_footer(); ?>