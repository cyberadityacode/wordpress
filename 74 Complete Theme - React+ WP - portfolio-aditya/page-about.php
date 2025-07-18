<?php
/* Template Name: About Page */
get_header();
?>

<main style="padding: 2rem;">
    <h1>About Me</h1>
    <div>
        <?php
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
        ?>
    </div>

    <div id="react-root-about"></div>

</main>

<?php get_footer(); ?>