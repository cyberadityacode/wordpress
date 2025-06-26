<?php get_header(); ?>

<main id="main-content" style="padding: 40px 20px; max-width: 800px; margin: auto;">

  <h1>Search Results for: <em><?php echo get_search_query(); ?></em></h1>

  <?php if (have_posts()): ?>
    <ul class="search-results">
      <?php while (have_posts()): the_post(); ?>
        <li style="margin-bottom: 20px;">
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p><?php the_excerpt(); ?></p>
        </li>
      <?php endwhile; ?>
    </ul>

    <div class="pagination">
      <?php the_posts_pagination(); ?>
    </div>

  <?php else: ?>
    <p>No results found for your search. Try something else:</p>
    <?php get_search_form(); ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
