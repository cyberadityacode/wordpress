<?php
/*Template Name: Contact Page */

get_header();
?>

<main style="padding: 2rem;">
    <h1>Contact</h1>
    <div>
        <?php
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>