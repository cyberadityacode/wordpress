<?php get_header();

echo "This is home.php";

if (is_home())
    echo "Welcome to Home "; //blog page

?>
<!-- // Work with The Loop and display blog posts
// Add Loop in `home.php` to display posts (`have_posts()` and `the_post()`)
 -->
<?php
echo "<br> <h1> Blog Posts </h1>";

// Start the loop

if (have_posts()):
    while (have_posts()):
        the_post(); //get the current post data
        ?>

        <article class="blog-posts">
            <div class="blog-post-thumbnail">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('custom-thumb'); //alternative large, medium
                }
                ?>
            </div>
            <div class="blog-content">
                <h2><?php the_title(); ?></h2> <!-- Post Title -->
                <p><?php the_excerpt(); ?></p> <!-- Post Excerpt -->
                <a href="<?php the_permalink(); ?>">Read More...</a>
            </div>

        </article>

        <?php
    endwhile;
else:
    echo "<p>No blog post Available</p>";
endif;
?>

<?php
get_footer();
?>