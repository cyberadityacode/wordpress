<?php get_header(); ?>

<main id="main-content" style="padding: 40px 20px; text-align: center; max-width: 600px; margin: auto;">

  <h1>404 - Page Not Found</h1>
  <p>Sorry, the page you are looking for doesn't exist or may have been moved.</p>

  <h3>Try Searching:</h3>
  <?php get_search_form(); ?>

  <p><a href="<?php echo home_url(); ?>">← Back to Home</a></p>

</main>

<?php get_footer(); ?>
