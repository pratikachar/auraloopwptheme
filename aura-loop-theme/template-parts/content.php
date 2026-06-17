<?php
/**
 * Template part for displaying blog content in archive/card view
 */
?>

<article class="blog-card" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if (has_post_thumbnail()) : ?>
  <a href="<?php the_permalink(); ?>" class="blog-card-thumb">
    <?php the_post_thumbnail('aura-loop-card'); ?>
  </a>
  <?php endif; ?>
  <div class="blog-card-body">
    <?php
    $categories = get_the_category();
    if (! empty($categories)) :
    ?>
    <span class="blog-card-cat"><?php echo esc_html($categories[0]->name); ?></span>
    <?php endif; ?>
    <h3 class="blog-card-title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    <div class="blog-card-excerpt">
      <?php the_excerpt(); ?>
    </div>
    <div class="blog-card-meta">
      <span><em><?php the_author(); ?></em></span>
      <span><?php echo get_the_date(); ?></span>
    </div>
  </div>
</article>
