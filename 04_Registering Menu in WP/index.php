<?php

get_header();

if (have_posts()):
    while (have_posts()):
        the_post();
        the_title('<h2>', '</h2>');
        ?>

        <div class="post-content">
            <?php
            the_content();
            ?>
        </div>
        <?php
    endwhile;
else:
    echo "<p>No Content found</p>";
endif;


get_footer();
