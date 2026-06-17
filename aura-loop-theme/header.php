<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="description" content="<?php bloginfo('description'); ?>">
<meta name="keywords" content="luxury streetwear, circular fashion, designer clothing restoration, sustainable fashion membership, premium streetwear trade, clothing upcycle, fashion authentication">
<meta name="robots" content="index, follow">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<link rel="icon" type="image/x-icon" href="<?php echo esc_url(get_template_directory_uri() . '/favicon.ico'); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Open Graph -->
<meta property="og:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>">
<meta property="og:description" content="<?php bloginfo('description'); ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta property="og:locale" content="<?php echo get_locale(); ?>">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="nav" id="mainNav">
  <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="Aura Loop">
    <?php if (has_custom_logo()) : ?>
      <?php the_custom_logo(); ?>
    <?php else : ?>
      <img src="<?php echo esc_url(get_template_directory_uri() . '/Aura-Loop-04.png'); ?>" alt="Aura Loop" style="height:80px; width:auto; display:block;">
    <?php endif; ?>
  </a>

  <?php
  if (has_nav_menu('primary')) :
    wp_nav_menu(array(
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => 'nav-links',
      'fallback_cb'    => false,
      'walker'         => new Aura_Loop_Walker_Nav_Menu(),
    ));
  else :
  ?>
  <ul class="nav-links">
    <li><a href="<?php echo esc_url(home_url('/#system')); ?>">The Ecosystem</a></li>
    <li><a href="<?php echo esc_url(home_url('/#membership')); ?>">Membership</a></li>
    <li><a href="<?php echo esc_url(home_url('/#verify')); ?>">Verification</a></li>
    <li><a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>">Blog</a></li>
  </ul>
  <?php endif; ?>

  <a href="<?php echo esc_url(home_url('/#connect')); ?>" class="nav-pill">Initiate Loop</a>
</nav>
