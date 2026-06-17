<?php
/**
 * Search results template
 */
get_header();
?>

<section class="blog-header">
  <h1><?php printf(__('Search: %s', 'aura-loop'), get_search_query()); ?></h1>
  <p>
    <?php
    global $wp_query;
    printf(_n('%d result found', '%d results found', $wp_query->found_posts, 'aura-loop'), $wp_query->found_posts);
    ?>
  </p>
</section>

<?php get_search_form(); ?>

<div class="blog-grid">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/content', get_post_format()); ?>
  <?php endwhile; else : ?>
    <p style="grid-column:1/-1; text-align:center; color:var(--gray-40); padding:4rem 0;"><?php _e('No results found. Try a different search.', 'aura-loop'); ?></p>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
