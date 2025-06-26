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
                $projects_query->the_post();

                // ACF Fields
                $client_name = get_field('client_name');
                $project_date = get_field('project_date');
                $features = get_field('project_features');
                ?>

                <div class="single-project">
                    <h3><?php the_title(); ?></h3>

                    <?php if (has_post_thumbnail()): ?>
                        <div class="projects-thumbnail">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>

                    <!--  Display assigned Project Types -->
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

                    <!--  Display ACF Fields -->
                    <div class="project-meta">
                        <?php if ($client_name): ?>
                            <p><strong>Client:</strong> <?php echo esc_html($client_name); ?></p>
                        <?php endif; ?>

                        <?php if ($project_date): ?>
                            <p><strong>Completed on:</strong> <?php echo esc_html($project_date); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="project-content">
                        <?php the_excerpt(); ?>
                    </div>

                    <div>
                        <?php
                        if ($features):
                            $features_array = explode("\n", $features); //split by new lines
                            echo "<h4>Project Features</h4>";
                            foreach ($features_array as $feature) {
                                echo '<li>' . esc_html(trim($feature)) . '</li>';
                            }
                            echo "</ul>";
                        endif;
                        ?>
                    </div>

                    <a href="<?php the_permalink(); ?>">Read More</a>
                </div>

            <?php endwhile;

            echo "</div>";
            wp_reset_postdata();

        else:
            echo '<p>No Projects Found</p>';
        endif;
        ?>
    </div>

</main>

<?php get_footer(); ?>