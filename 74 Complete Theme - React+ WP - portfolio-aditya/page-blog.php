<?php
/*Template Name: Blog */
get_header();

$current_cat = isset($_GET['category']) ? intval($_GET['category']) : 0;
?>

<div class="container" style="max-width: 900px;margin: 0 auto; padding: 2rem;">
    <h1>Latest Blog Posts</h1>

    <!--  Category Filter Dropdown -->
    <form method="GET" action="<?php echo esc_url(get_permalink()); ?>" style="margin-bottom: 2rem;">
        <label for="category">Filter by Category:</label>
        <select name="category" id="category" onchange="this.form.submit()" style="margin-left: 10px; padding: 5px;">
            <option value="0">All Categories</option>
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
                echo '<option value="' . esc_attr($category->term_id) . '"' . selected($current_cat, $category->term_id, false) . '>' . esc_html($category->name) . '</option>';
            }
            ?>
        </select>
    </form>

    <?php
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    );

    // Filter by category if selected
    if ($current_cat) {
        $args['cat'] = $current_cat;
    }

    $blog_query = new WP_Query($args);

    if ($blog_query->have_posts()):
        while ($blog_query->have_posts()):
            $blog_query->the_post(); ?>
            <article
                style="display: flex; gap: 20px; margin-bottom: 2rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem; align-items: flex-start;">
                <?php if (has_post_thumbnail()): ?>
                    <div style="flex: 0 0 200px;">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('thumbnail', ['style' => 'width: 100%; height: 200px; border-radius: 4px;']); ?>
                        </a>
                    </div>
                    <?php
                else:
                    ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/default_image.png" alt="Default thumbnail"
                            style="width: 200px; height: 200px; border-radius: 4px;">
                    </a>
                <?php endif; ?>

                <div style="flex: 1;">
                    <h2 style="margin-top: 0;">
                        <a href="<?php the_permalink(); ?>"
                            style="text-decoration: none; color: #111;"><?php the_title(); ?></a>
                    </h2>

                    <p style="color: #666; font-size: 14px; margin: 0 0 10px;">
                        <?php the_time('F j, Y'); ?> · By <?php the_author(); ?>
                    </p>

                    <div style="margin-bottom: 10px;">
                        <?php the_excerpt(); ?>
                    </div>

                    <a href="<?php the_permalink(); ?>" style="color: #4f46e5; text-decoration: none; font-weight: bold;">Read
                        More →</a>
                </div>
            </article>

        <?php endwhile; ?>

        <!-- pagination -->
        <div class="pagination" style="text-align: center;">
            <?php
            echo paginate_links(array(
                'total' => $blog_query->max_num_pages,
            ));
            ?>
        </div>

    <?php else: ?>
        <p>No Blog Posts Found</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

</div>

<?php
get_footer();
?>