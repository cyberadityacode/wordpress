<?php get_header(); ?>



<main>
    <?php
    $hero_heading_text = get_theme_mod('ajax_theme_three_hero_heading_text_control', 'Aditya Dubey');
    ?>

    <section class="hero-section">
        <div class="hero-img">
            <?php
            $hero_image = get_theme_mod('ajax_theme_three_hero_image');
            ?>
            <?php if ($hero_image): ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="Hero Image">
            </div>
        <?php endif ?>
        <div class="hero-head-para">

            <?php echo "<h1>" . esc_html(get_theme_mod('ajax_theme_three_heading_text')) . "</h1>"; ?>

            <!-- ajax_theme_three_heading_paragraph_text -->
            <!-- <p>"Absolute Learner, Evolving in Consciousness from concept to clean delivery"</p> -->
            <?php echo "<p>" . wp_kses_post(get_theme_mod('ajax_theme_three_heading_paragraph_text')) . "</p>" ?>
            <a href="<?php echo esc_url(get_theme_mod('ajax_theme_three_heading_button_url')); ?>">
                <button><?php echo esc_html(get_theme_mod('ajax_theme_three_heading_button_text', 'Download CV')); ?></button>
            </a>
        </div>
    </section>

    <div class="parent-container">
        <div class="posts-card">
            <!--  -->
            <div class="filters">
                <label for="search-input">Search</label>
                <input type="text" id="search-input" placeholder="Search posts..." />
                <label for="category-filter">Category</label>
                <select id="category-filter">
                    <option value="">All Categories</option>
                    <?php
                    $categories = get_categories();
                    foreach ($categories as $cat) {
                        echo '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>';
                    }
                    ?>
                </select>

                <label for="tag-filter">Tags</label>
                <select id="tag-filter">
                    <option value="">All Tags</option>
                    <?php
                    $tags = get_tags();
                    foreach ($tags as $tag) {
                        echo '<option value="' . esc_attr($tag->term_id) . '">' . esc_html($tag->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <!--  -->

            <div class="post"></div> <!-- This will be filled with posts -->
            <div class="pagination"></div> <!-- This will be filled with buttons -->
        </div>
    </div>
</main>


<?php get_footer(); ?>