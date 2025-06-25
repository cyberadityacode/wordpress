<?php
/**
 *Template Name: About Us Page
 *  

*/
?>
<?php get_header(); ?>

<main class="about-page">
    
<!-- <h1>About Us</h1>
<p>Welcome to our About Us page. This is a custom template!</p>
 -->
<!-- I will customize and add HTML/PHP furthermore -->
<!-- 
<section>
    <h2>Our Mission</h2>
    <p>To create awesome website using WordPress</p>
</section> -->


<!-- ----------------------------------- -->

<!-- show content added via the WordPress editor -->

<h1><?php the_title(); ?></h1>

<?php
while(have_posts()): the_post();
    the_content();
endwhile;
?>

</main>

<?php get_footer(); ?>

<!-- 

 The special comment Template Name: About Us Page is required. It tells WordPress this file is a selectable page template.

-->