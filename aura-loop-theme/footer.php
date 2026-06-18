<footer class="footer">
  <div class="footer-top">
    <div>
      <img src="<?php echo esc_url(get_template_directory_uri() . '/Aura-Loop-02.png'); ?>" alt="Aura Loop" style="max-height:180px; width:auto; display:block; margin-bottom:1.25rem;">
      <p class="footer-desc">A premium circular fashion technology platform dedicated to luxury streetwear restoration, upcycling, authentication, and trade — preserving designer craftsmanship for generations through sustainable membership.</p>
    </div>

    <?php if (is_active_sidebar('footer-1')) : ?>
      <div><?php dynamic_sidebar('footer-1'); ?></div>
    <?php else : ?>
    <div>
      <div class="footer-col-title">Platform</div>
      <ul class="footer-col-links">
        <li><a href="<?php echo esc_url(home_url('/#system')); ?>">The Ecosystem</a></li>
        <li><a href="<?php echo esc_url(home_url('/#system')); ?>">Restoration Studio</a></li>
        <li><a href="<?php echo esc_url(home_url('/#system')); ?>">Trade Marketplace</a></li>
        <li><a href="<?php echo esc_url(home_url('/#verify')); ?>">Digital Verification</a></li>
        <li><a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>">Blog</a></li>
      </ul>
    </div>
    <?php endif; ?>

    <?php if (is_active_sidebar('footer-2')) : ?>
      <div><?php dynamic_sidebar('footer-2'); ?></div>
    <?php else : ?>
    <div>
      <div class="footer-col-title">Membership</div>
      <ul class="footer-col-links">
        <li><a href="<?php echo esc_url(home_url('/#connect?plan=archival')); ?>">Archival Tier — $85</a></li>
        <li><a href="<?php echo esc_url(home_url('/#connect?plan=syndicate')); ?>">Syndicate Tier — $150</a></li>
        <li><a href="<?php echo esc_url(home_url('/#system')); ?>">Designer Collaborations</a></li>
        <li><a href="<?php echo esc_url(home_url('/#connect')); ?>">Refer a Member</a></li>
      </ul>
    </div>
    <?php endif; ?>

    <?php if (is_active_sidebar('footer-3')) : ?>
      <div><?php dynamic_sidebar('footer-3'); ?></div>
    <?php else : ?>
    <div>
      <div class="footer-col-title">Company</div>
      <ul class="footer-col-links">
        <li><a href="<?php echo esc_url(home_url('/#problem')); ?>">About Aura Loop</a></li>
        <li><a href="<?php echo esc_url(home_url('/#system')); ?>">Studio Partners</a></li>
        <li><a href="<?php echo esc_url(home_url('/#connect')); ?>">Press &amp; Media</a></li>
        <li><a href="<?php echo esc_url(home_url('/#connect')); ?>">Contact</a></li>
      </ul>
    </div>
    <?php endif; ?>
  </div>

  <div class="footer-bottom">
    <div class="footer-bottom-left">
      <p class="footer-copy">&copy; <?php echo date('Y'); ?> Aura Loop. All rights reserved. Designed for the circular economy <em>&#10022;</em></p>
      <div class="footer-social">
        <?php $socials = array(
          'youtube'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.2c-.3-1-1-1.7-2-2-1.8-.5-9-.5-9-.5s-7.2 0-9 .5c-1 .3-1.7 1-2 2C1 8 1 12 1 12s0 4 .5 5.8c.3 1 1 1.7 2 2 1.8.5 9 .5 9 .5s7.2 0 9-.5c1-.3 1.7-1 2-2 .5-1.8.5-5.8.5-5.8s0-4-.5-5.8zM9.5 15V9l6.5 3-6.5 3z"/></svg>',
          'linkedin' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.4 20.4h-3.6v-5.6c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9v5.7H9.2V9h3.4v1.6h.1c.5-.9 1.6-1.8 3.3-1.8 3.5 0 4.2 2.3 4.2 5.3v6.3zM5.3 7.4c-1.2 0-2.1-1-2.1-2.1s.9-2.1 2.1-2.1 2.1 1 2.1 2.1-.9 2.1-2.1 2.1zM7.1 20.4H3.6V9h3.5v11.4z"/></svg>',
          'facebook' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.1C24 5.4 18.6 0 12 0S0 5.4 0 12.1c0 6 4.4 11 10.1 12V15.6H7.1v-3.5h3V9.7c0-3 1.8-4.6 4.5-4.6 1.3 0 2.7.2 2.7.2v3h-1.5c-1.5 0-2 .9-2 1.9v2.3h3.4l-.5 3.5h-2.9v8.5c5.7-1 10.2-6 10.2-12.1z"/></svg>',
          'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 3.3.1 4.8 1.7 4.9 4.9.1 1.3.1 1.7.1 4.8s0 3.6-.1 4.9c-.1 3.2-1.6 4.8-4.9 4.9-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-3.3-.1-4.8-1.7-4.9-4.9-.1-1.3-.1-1.7-.1-4.9s0-3.5.1-4.8c.1-3.2 1.6-4.8 4.9-4.9 1.3-.1 1.7-.1 4.9-.1zM12 0C8.7 0 8.3 0 7.1.1 3.1.3.3 3.1.1 7.1 0 8.3 0 8.7 0 12s0 3.7.1 4.9c.2 4 3 4.8 7 5 1.2.1 1.6.1 4.9.1s3.7 0 4.9-.1c4-.2 4.8-3 5-5 .1-1.2.1-1.6.1-4.9s0-3.7-.1-4.9c-.2-4-3-4.8-5-5C15.7 0 15.3 0 12 0zm0 5.8a6.2 6.2 0 100 12.4 6.2 6.2 0 000-12.4zM12 16a4 4 0 110-8 4 4 0 010 8zm6.4-10.2a1.4 1.4 0 100 2.8 1.4 1.4 0 000-2.8z"/></svg>',
        ); foreach ($socials as $key => $icon):
          $url = get_theme_mod("aura_social_$key");
          if ($url): ?>
          <a href="<?php echo esc_url($url); ?>" class="social-icon" target="_blank" rel="noopener noreferrer" aria-label="<?php echo ucfirst($key); ?>"><?php echo $icon; ?></a>
        <?php endif; endforeach; ?>
      </div>
    </div>
    <nav class="footer-legal" aria-label="Legal links">
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('privacy-policy'))); ?>">Privacy Policy</a>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms-of-service'))); ?>">Terms of Service</a>
      <a href="<?php echo esc_url(get_permalink(get_page_by_path('cookie-policy'))); ?>">Cookie Policy</a>
    </nav>
  </div>
</footer>

<div class="back-to-top" id="backToTopBtn" aria-label="Back to top">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 5v14M5 12l7-7 7 7"/>
  </svg>
</div>

<?php wp_footer(); ?>
</body>
</html>
