<?php
/**
 * Index / fallback template
 */
get_header();
?>

<section class="blog-header">
  <h1><?php _e('Blog', 'aura-loop'); ?></h1>
  <p><?php _e('Explore insights from the circular fashion ecosystem.', 'aura-loop'); ?></p>
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
