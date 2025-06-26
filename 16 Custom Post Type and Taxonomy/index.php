<?php get_header(); ?>

<main>

    <!-- (Optional) You can use this section later for filters -->
    <div class="project-types">
        <!-- You can list filter links here if needed in the future -->
    </div>

    <div class="our-projects">
        <?php
        // Create a custom query to get 'project' posts
        $projects_query = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => 3,
            'post_status' => 'publish',
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

                    <!-- ✅ Display assigned Project Types -->
                    <div class="project-types">
                        <?php
                        $types = get_the_terms(get_the_ID(), 'project_type');
                        if ($types && !is_wp_error($types)) {
                            echo '<ul class="project-type-list">';
                            foreach ($types as $type) {
                                echo '<li>' . esc_html($type->name) . '</li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>

                    <div class="project-content">
                        <?php the_excerpt(); ?>
                    </div>

                    <a href="<?php the_permalink(); ?>">Read More</a>
                </div>

            <?php endwhile;

            echo "</div>";
            wp_reset_postdata();

        else:
            echo '<p>No Projects Found index</p>';
        endif;
        ?>
    </div>

</main>

<?php get_footer(); ?>
