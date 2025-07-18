<?php get_header(); ?>

<div class="container" style="max-width: 900px; margin: 0 auto; padding: 2rem;">

    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>

            <article>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()): ?>
                    <div style="margin-bottom: 1.5rem;">
                        <?php the_post_thumbnail('large', ['style' => 'width: 100%; height: auto; border-radius: 6px;']); ?>
                    </div>
                <?php endif; ?>

                <!-- Title -->
                <h1 style="font-size: 2rem; margin-bottom: 0.5rem;"><?php the_title(); ?></h1>

                <!-- Meta Info -->
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">
                    <?php the_time('F j, Y'); ?> · By <?php the_author(); ?>
                    <?php if (has_category()): ?>
                        · Filed under <?php the_category(', '); ?>
                    <?php endif; ?>
                </p>

                <!-- Content -->
                <div class="post-content" style="line-height: 1.7;">
                    <?php the_content(); ?>
                </div>

                <!-- Tags -->
                <div style="margin-top: 2rem;">
                    <?php the_tags('<strong>Tags:</strong> ', ', ', ''); ?>
                </div>

            </article>

            <!-- Post Navigation -->
            <div class="post-navigation"
                style="display: flex; justify-content: space-between; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #ddd;">

                <div class="prev-post">
                    <?php previous_post_link('%link', '← %title'); ?>
                </div>

                <div class="next-post" style="text-align: right;">
                    <?php next_post_link('%link', '%title →'); ?>
                </div>

            </div>


            <!-- Comments Section -->
            <div id="comments" style="margin-top: 3rem;">
                <?php
                // Load comments template if comments are open or we have at least one comment
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </div>

        <?php endwhile; else: ?>

        <p>Post not found.</p>

    <?php endif; ?>

</div>

<?php get_footer(); ?>