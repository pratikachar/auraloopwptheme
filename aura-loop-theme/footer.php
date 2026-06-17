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
    <p class="footer-copy">&copy; <?php echo date('Y'); ?> Aura Loop. All rights reserved. Designed for the circular economy <em>&#10022;</em></p>
    <nav class="footer-legal" aria-label="Legal links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Cookie Policy</a>
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
