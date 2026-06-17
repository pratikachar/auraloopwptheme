<?php
/**
 * 404 template
 */
get_header();
?>

<section class="page-404">
  <h1>404</h1>
  <p><?php _e('The page you are looking for has been consumed by the circular economy.', 'aura-loop'); ?></p>
  <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-mint">Return Home</a>
</section>

<?php get_footer(); ?>
