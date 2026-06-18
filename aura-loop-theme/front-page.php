<?php
/**
 * Front page template — Aura Loop landing page
 * Author: colorgraphicz
 */
get_header();
?>

<section class="hero">
  <div class="hero-content">
    <div class="eyebrow"><?php echo wp_kses_post(aura_get_front_field('hero_eyebrow')); ?></div>
    <h1 class="hero-h1"><?php echo wp_kses_post(aura_get_front_field('hero_headline')); ?></h1>
    <p class="hero-lead"><?php echo wp_kses_post(aura_get_front_field('hero_lead')); ?></p>
    <div class="cta-row">
      <a href="<?php echo esc_url(aura_get_front_field('hero_cta_1_url')); ?>" class="btn-mint"><?php echo esc_html(aura_get_front_field('hero_cta_1')); ?></a>
      <a href="<?php echo esc_url(aura_get_front_field('hero_cta_2_url')); ?>" class="btn-ghost"><?php echo esc_html(aura_get_front_field('hero_cta_2')); ?></a>
    </div>
  </div>
  <div class="hero-visual" aria-hidden="true">
    <div class="loop-glow"></div>
    <div class="loop-stage">
      <div class="ring ring-1"></div>
      <div class="ring ring-2"></div>
      <div class="ring ring-3"></div>
      <div class="ring-center">
        <svg width="90" height="90" viewBox="0 0 90 90">
          <path d="M45 12 L22 72 H30 L37.5 52.5 H52.5 L60 72 H68 Z" fill="rgba(255,255,255,0.9)"/>
          <path d="M41 49 L45 16 L49 49 Z" fill="rgba(1,1,1,0.85)"/>
          <path d="M45 22 L47.5 32 L57 35 L47.5 38 L45 48 L42.5 38 L33 35 L42.5 32 Z" fill="white"/>
        </svg>
        <span class="ring-center-sub">Luxury Streetwear</span>
      </div>
      <div class="dot-marker"></div>
    </div>
  </div>

  <!-- Mobile loop rings -->
  <div class="hero-visual-mobile" aria-hidden="true">
    <div class="loop-stage-mobile">
      <div class="ring ring-1"></div>
      <div class="ring ring-2"></div>
      <div class="ring ring-3"></div>
      <div class="ring-center">
        <svg width="50" height="50" viewBox="0 0 90 90">
          <path d="M45 12 L22 72 H30 L37.5 52.5 H52.5 L60 72 H68 Z" fill="rgba(255,255,255,0.9)"/>
          <path d="M41 49 L45 16 L49 49 Z" fill="rgba(1,1,1,0.85)"/>
          <path d="M45 22 L47.5 32 L57 35 L47.5 38 L45 48 L42.5 38 L33 35 L42.5 32 Z" fill="white"/>
        </svg>
        <span class="ring-center-sub">Luxury Streetwear</span>
      </div>
      <div class="dot-marker"></div>
    </div>
  </div>

  <div class="hero-scroll">
    <div class="scroll-track"></div>
    Scroll to explore
  </div>
</section>

<div class="ticker" aria-hidden="true">
  <div class="ticker-track" id="tickerTrack">
    <?php $ticker_items = explode("\n", aura_get_front_field('ticker_items')); ?>
    <?php foreach ($ticker_items as $item) : ?>
      <?php $item = trim($item); if (!$item) continue; ?>
      <span class="ticker-item"><?php echo esc_html($item); ?> <span>&#10022;</span></span>
    <?php endforeach; ?>
  </div>
</div>

<section class="problem" id="problem">
  <div class="problem-inner">
    <div class="eyebrow reveal"><?php echo wp_kses_post(aura_get_front_field('problem_eyebrow')); ?></div>
    <h2 class="problem-h2 reveal delay-1"><?php echo wp_kses_post(aura_get_front_field('problem_heading')); ?></h2>
    <div class="problem-cols">
      <p class="problem-p reveal delay-2"><?php echo wp_kses_post(aura_get_front_field('problem_p1')); ?></p>
      <p class="problem-p reveal delay-3"><?php echo wp_kses_post(aura_get_front_field('problem_p2')); ?></p>
    </div>
    <div class="problem-ghost" aria-hidden="true">92%</div>
  </div>
</section>

<section class="system" id="system">
  <div class="system-header reveal">
    <div class="eyebrow"><?php echo wp_kses_post(aura_get_front_field('system_eyebrow')); ?></div>
    <h2 class="system-h2"><?php echo wp_kses_post(aura_get_front_field('system_heading')); ?></h2>
    <p class="system-lead"><?php echo wp_kses_post(aura_get_front_field('system_lead')); ?></p>
  </div>
  <div class="system-grid">
    <div class="sys-col reveal">
      <span class="sys-num"><?php echo esc_html(aura_get_front_field('system_1_num')); ?></span>
      <h3 class="sys-h3"><?php echo esc_html(aura_get_front_field('system_1_title')); ?></h3>
      <p class="sys-body"><?php echo wp_kses_post(aura_get_front_field('system_1_desc')); ?></p>
      <a href="#connect?plan=archival" class="sys-arrow" aria-label="Request Archival Membership">
        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 10 L10 2 M4 2 H10 V8"/>
        </svg>
      </a>
    </div>
    <div class="sys-col reveal delay-1">
      <span class="sys-num"><?php echo esc_html(aura_get_front_field('system_2_num')); ?></span>
      <h3 class="sys-h3"><?php echo esc_html(aura_get_front_field('system_2_title')); ?></h3>
      <p class="sys-body"><?php echo wp_kses_post(aura_get_front_field('system_2_desc')); ?></p>
      <a href="#connect?plan=archival" class="sys-arrow" aria-label="Request Archival Membership">
        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 10 L10 2 M4 2 H10 V8"/>
        </svg>
      </a>
    </div>
    <div class="sys-col reveal delay-2">
      <span class="sys-num"><?php echo esc_html(aura_get_front_field('system_3_num')); ?></span>
      <h3 class="sys-h3"><?php echo esc_html(aura_get_front_field('system_3_title')); ?></h3>
      <p class="sys-body"><?php echo wp_kses_post(aura_get_front_field('system_3_desc')); ?></p>
      <a href="#connect?plan=syndicate" class="sys-arrow" aria-label="Request Syndicate Membership">
        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 10 L10 2 M4 2 H10 V8"/>
        </svg>
      </a>
    </div>
  </div>
</section>

<section class="pricing" id="membership">
  <div class="pricing-head reveal">
    <div class="eyebrow" style="justify-content:center;"><?php echo wp_kses_post(aura_get_front_field('pricing_eyebrow')); ?></div>
    <h2 class="pricing-h2"><?php echo wp_kses_post(aura_get_front_field('pricing_heading')); ?></h2>
    <p class="pricing-sub"><?php echo wp_kses_post(aura_get_front_field('pricing_sub')); ?></p>
  </div>
  <div class="pricing-grid">
    <div class="tier-card reveal">
      <div class="tier-label"><?php echo esc_html(aura_get_front_field('tier1_label')); ?></div>
      <h3 class="tier-name"><?php echo esc_html(aura_get_front_field('tier1_name')); ?></h3>
      <div class="tier-price"><?php echo esc_html(aura_get_front_field('tier1_price')); ?> <span><?php echo esc_html(aura_get_front_field('tier1_price_label')); ?></span></div>
      <div class="tier-divider"></div>
      <ul class="tier-features">
        <?php $features = explode("\n", aura_get_front_field('tier1_features')); ?>
        <?php foreach ($features as $f) : ?>
          <?php $f = trim($f); if (!$f) continue; ?>
          <li><span class="check" aria-hidden="true">&#10022;</span> <?php echo esc_html($f); ?></li>
        <?php endforeach; ?>
      </ul>
      <a href="<?php echo esc_url(aura_get_front_field('tier1_cta_url')); ?>" class="btn-mint"><?php echo esc_html(aura_get_front_field('tier1_cta')); ?></a>
    </div>
    <div class="tier-card featured reveal delay-1">
      <?php $badge = aura_get_front_field('tier2_badge'); if ($badge) : ?>
      <div class="tier-badge"><?php echo esc_html($badge); ?></div>
      <?php endif; ?>
      <div class="tier-label"><?php echo esc_html(aura_get_front_field('tier2_label')); ?></div>
      <h3 class="tier-name"><?php echo esc_html(aura_get_front_field('tier2_name')); ?></h3>
      <div class="tier-price"><?php echo esc_html(aura_get_front_field('tier2_price')); ?> <span><?php echo esc_html(aura_get_front_field('tier2_price_label')); ?></span></div>
      <div class="tier-divider"></div>
      <ul class="tier-features">
        <?php $features = explode("\n", aura_get_front_field('tier2_features')); ?>
        <?php foreach ($features as $f) : ?>
          <?php $f = trim($f); if (!$f) continue; ?>
          <li><span class="check" aria-hidden="true">&#10022;</span> <?php echo esc_html($f); ?></li>
        <?php endforeach; ?>
      </ul>
      <a href="<?php echo esc_url(aura_get_front_field('tier2_cta_url')); ?>" class="btn-mint"><?php echo esc_html(aura_get_front_field('tier2_cta')); ?></a>
    </div>
  </div>
</section>

<section class="verify" id="verify">
  <div class="verify-inner">
    <div class="verify-left">
      <div class="eyebrow reveal"><?php echo wp_kses_post(aura_get_front_field('verify_eyebrow')); ?></div>
      <h2 class="verify-h2 reveal delay-1"><?php echo wp_kses_post(aura_get_front_field('verify_heading')); ?></h2>
      <p class="verify-body reveal delay-2"><?php echo wp_kses_post(aura_get_front_field('verify_body')); ?></p>
      <div class="metrics reveal delay-3">
        <div>
          <div class="metric-num"><?php echo wp_kses_post(aura_get_front_field('verify_metric_1_num')); ?></div>
          <div class="metric-label"><?php echo esc_html(aura_get_front_field('verify_metric_1_label')); ?></div>
        </div>
        <div>
          <div class="metric-num"><?php echo wp_kses_post(aura_get_front_field('verify_metric_2_num')); ?></div>
          <div class="metric-label"><?php echo esc_html(aura_get_front_field('verify_metric_2_label')); ?></div>
        </div>
        <div>
          <div class="metric-num"><?php echo wp_kses_post(aura_get_front_field('verify_metric_3_num')); ?></div>
          <div class="metric-label"><?php echo esc_html(aura_get_front_field('verify_metric_3_label')); ?></div>
        </div>
      </div>
    </div>
    <div class="verify-ring-wrap" aria-hidden="true">
      <div class="verify-stage">
        <div class="v-ring v-r1"></div>
        <div class="v-ring v-r2"></div>
        <div class="v-ring v-r3"></div>
        <div class="v-center">
          <svg width="54" height="54" viewBox="0 0 54 54">
            <path d="M27 6 L31.5 18.5 L44.5 18.5 L34.5 26.5 L38.5 39.5 L27 32 L15.5 39.5 L19.5 26.5 L9.5 18.5 L22.5 18.5 Z" stroke="#00FFA3" stroke-width="1.5" fill="none" stroke-linejoin="round"/>
          </svg>
          <div class="v-badge">Verified Asset</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="content-form-section" id="connect">
  <div class="form-container reveal">
    <div class="form-header">
      <h3><?php echo esc_html(aura_get_front_field('form_heading')); ?></h3>
      <p><?php echo esc_html(aura_get_front_field('form_text')); ?></p>
    </div>
    <?php
      $cap1 = rand(3, 12);
      $cap2 = rand(4, 15);
      $cap_answer = $cap1 + $cap2;
      $cap_token = wp_hash($cap_answer . '|aura-loop-captcha');
    ?>
    <form id="insightForm" method="post">
      <input type="hidden" name="action" value="aura_loop_contact">
      <input type="hidden" name="cap1" value="<?php echo esc_attr($cap1); ?>">
      <input type="hidden" name="cap2" value="<?php echo esc_attr($cap2); ?>">
      <input type="hidden" name="cap_token" value="<?php echo esc_attr($cap_token); ?>">
      <div id="formMessage" style="display:none; text-align:center; padding:1rem; margin-bottom:1.5rem; border-radius:16px; font-size:0.85rem;"></div>
      <div class="form-group">
        <input type="text" placeholder="Full name" required id="nameInput" name="name">
      </div>
      <div class="form-group">
        <input type="email" placeholder="Email address" required id="emailInput" name="email">
      </div>
      <div class="form-group">
        <select id="planSelect" name="plan" style="width:100%; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.12); border-radius:24px; padding:1rem 1.5rem; font-family:var(--font-b); font-size:0.9rem; color:var(--white); appearance:none; cursor:pointer;">
          <option value="">Select membership tier</option>
          <option value="None">None</option>
          <option value="archival">Archival Membership — $85/mo</option>
          <option value="syndicate">Syndicate Membership — $150/mo</option>
        </select>
      </div>
      <div class="form-group">
        <textarea placeholder="Tell us about your wardrobe vision (optional)" id="visionInput" name="vision"></textarea>
      </div>
      <div class="form-group">
        <div style="display:flex; align-items:center; gap:1rem; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.12); border-radius:24px; padding:0.5rem 1.5rem;">
          <label style="font-size:0.85rem; color:var(--gray-60); white-space:nowrap;">What is <?php echo $cap1; ?> + <?php echo $cap2; ?>?</label>
          <input type="text" placeholder="Answer" required id="captchaInput" name="captcha" style="flex:1; background:none; border:none; padding:0.5rem 0; font-family:var(--font-b); font-size:0.9rem; color:var(--white); outline:none;">
        </div>
      </div>
      <button type="submit" class="submit-btn">Request Invitation &#8594;</button>
      <p class="form-note">&#10022; No spam. Only circular luxury updates.</p>
    </form>
  </div>
</section>

<?php get_footer(); ?>
