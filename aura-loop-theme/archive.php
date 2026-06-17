<?php
/**
 * Archive template (blog listing, categories, tags, dates)
 */
get_header();

$archive_title = '';
if (is_category()) {
  $archive_title = single_cat_title('', false);
} elseif (is_tag()) {
  $archive_title = single_tag_title('', false);
} elseif (is_author()) {
  $archive_title = get_the_author();
} elseif (is_date()) {
  $archive_title = get_the_date('F Y');
} else {
  $archive_title = __('Blog', 'aura-loop');
}
?>

<section class="blog-header">
  <h1><?php echo esc_html($archive_title); ?></h1>
  <?php if (is_category() || is_tag()) : ?>
    <p><?php echo category_description(); ?></p>
  <?php else : ?>
    <p><?php _e('Explore insights from the circular fashion ecosystem.', 'aura-loop'); ?></p>
  <?php endif; ?>
</section>

<div class="blog-grid">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/content', get_post_format()); ?>
  <?php endwhile; else : ?>
    <p style="grid-column:1/-1; text-align:center; color:var(--gray-40); padding:4rem 0;"><?php _e('No posts found.', 'aura-loop'); ?></p>
  <?php endif; ?>
</div>

<?php the_posts_pagination(array(
  'mid_size' => 2,
  'prev_text' => '&larr;',
  'next_text' => '&rarr;',
  'class' => 'pagination',
)); ?>

<?php get_footer(); ?>
