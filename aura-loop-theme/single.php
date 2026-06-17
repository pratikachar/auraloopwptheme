<?php
/**
 * Single post template
 */
get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<div class="single-header">
  <?php
  $categories = get_the_category();
  if (! empty($categories)) :
  ?>
  <span class="cat-links">
    <?php foreach ($categories as $cat) : ?>
      <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
    <?php endforeach; ?>
  </span>
  <?php endif; ?>
  <h1><?php the_title(); ?></h1>
  <div class="single-meta">
    <span>By <em><?php the_author(); ?></em></span>
    <span><?php echo get_the_date(); ?></span>
  </div>
</div>

<?php if (has_post_thumbnail()) : ?>
<div class="single-feat-img">
  <?php the_post_thumbnail('full'); ?>
</div>
<?php endif; ?>

<div class="single-content">
  <?php the_content(); ?>
  <?php
  wp_link_pages(array(
    'before' => '<div class="page-links">' . esc_html__('Pages:', 'aura-loop'),
    'after'  => '</div>',
  ));
  ?>
</div>

<div class="single-nav">
  <span class="nav-prev"><?php previous_post_link('%link', '&larr; Previous Post'); ?></span>
  <span class="nav-next"><?php next_post_link('%link', 'Next Post &rarr;'); ?></span>
</div>

<?php
if (comments_open() || get_comments_number()) :
  comments_template();
endif;
?>

<?php endwhile; ?>

<?php get_footer(); ?>
