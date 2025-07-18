<?php
// If the post is password protected and the visitor hasn't entered the password
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            printf(
                _nx(
                    'One Comment',
                    '%1$s Comments',
                    get_comments_number(),
                    'comments title',
                    'your-text-domain'
                ),
                number_format_i18n(get_comments_number())
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 50
            ));
            ?>
        </ol>

        <?php
        // If comments are closed but there are comments, show "Comments are closed"
        if (!comments_open()) :
            ?>
            <p class="no-comments">Comments are closed.</p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    // Display the comment form
    comment_form();
    ?>

</div><!-- #comments -->
