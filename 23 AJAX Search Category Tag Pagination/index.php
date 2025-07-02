<?php get_header(); ?>

<header>
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>
</header>

<main>
    <div class="parent-container">
        <div class="posts-card">
            <!--  -->
            <div class="filters">

                <input type="text" id="search-input" placeholder="Search posts..." />

                <select id="category-filter">
                    <option value="">All Categories</option>
                    <?php
                    $categories = get_categories();
                    foreach ($categories as $cat) {
                        echo '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>';
                    }
                    ?>
                </select>

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