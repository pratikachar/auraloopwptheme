<?php
/**
 * Comments template
 */
if (post_password_required()) {
  return;
}
?>

<div id="comments" class="comments-area">
  <?php if (have_comments()) : ?>
    <h3 class="comments-title">
      <?php
      printf(_n('1 Comment', '%1$s Comments', get_comments_number(), 'aura-loop'), number_format_i18n(get_comments_number()));
      ?>
    </h3>
    <ol class="comment-list">
      <?php
      wp_list_comments(array(
        'style'       => 'ol',
        'short_ping'  => true,
        'avatar_size' => 48,
        'callback'    => 'aura_loop_comment',
      ));
      ?>
    </ol>
    <?php the_comments_navigation(); ?>
  <?php endif; ?>

  <?php if (! comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="no-comments"><?php esc_html_e('Comments are closed.', 'aura-loop'); ?></p>
  <?php endif; ?>

  <?php comment_form(array(
    'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
    'title_reply_after'  => '</h4>',
    'class_submit'       => 'submit',
  )); ?>
</div>
