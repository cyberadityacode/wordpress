<?php

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()): ?>
        <h2 class="comment-title">
            <?php
            echo get_comments_number() . ' Comment(s)';
            ?>
        </h2>

        <ol class="comment-list">
            <?php wp_list_comments(); ?>
        </ol>
    <?php endif; ?>

    <?php
    // comment form
    
    comment_form();
    ?>
</div>