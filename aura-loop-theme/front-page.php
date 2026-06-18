<?php
/**
 * Front page template — Aura Loop landing page
 * Author: colorgraphicz
 */
get_header();
?>

<section class="hero">
  <div class="hero-content">
    <div class="eyebrow">Circular Fashion Technology</div>
    <h1 class="hero-h1">
      The end of the<br>
      <span class="struck">temporary</span><br>
      wardrobe.<br>
      Own the <span class="hi">style.</span><br>
      Circulate the asset.
    </h1>
    <p class="hero-lead">
      Aura Loop is a premium circular fashion ecosystem for luxury streetwear and designer apparel. We repair, upcycle, authenticate, and trade high-end garments, transforming clothing from a depreciating purchase into an evolving lifestyle asset through sustainable fashion membership.
    </p>
    <div class="cta-row">
      <a href="#connect" class="btn-mint">Initiate Your First Loop</a>
      <a href="#system" class="btn-ghost">How the Ecosystem Works</a>
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
    <span class="ticker-item">Repair <span>&#10022;</span></span>
    <span class="ticker-item">Renew <span>&#10022;</span></span>
    <span class="ticker-item">Upcycle <span>&#10022;</span></span>
    <span class="ticker-item">Evolve <span>&#10022;</span></span>
    <span class="ticker-item">Trade <span>&#10022;</span></span>
    <span class="ticker-item">Circulate <span>&#10022;</span></span>
    <span class="ticker-item">Authenticate <span>&#10022;</span></span>
    <span class="ticker-item">Preserve <span>&#10022;</span></span>
    <span class="ticker-item">Elevate <span>&#10022;</span></span>
  </div>
</div>

<section class="problem" id="problem">
  <div class="problem-inner">
    <div class="eyebrow reveal">The Inconvenient Truth</div>
    <h2 class="problem-h2 reveal delay-1">The high cost of<br><em>disposable</em> luxury.</h2>
    <div class="problem-cols">
      <p class="problem-p reveal delay-2">Modern streetwear was built on exclusivity and structural integrity, yet the current fashion cycle forces premature obsolescence. Minor tears, natural fading, and changing personal tastes relegate thousands of dollars of premium, heavyweight cotton and technical outerwear to the back of closets or landfills.</p>
      <p class="problem-p reveal delay-3">True luxury is not disposable. The modern wardrobe requires an infrastructure that respects both the craft of design and the necessity of preservation. Buying new is a linear dead end. Buying for longevity is the new market standard.</p>
    </div>
    <div class="problem-ghost" aria-hidden="true">92%</div>
  </div>
</section>

<section class="system" id="system">
  <div class="system-header reveal">
    <div class="eyebrow">The Process</div>
    <h2 class="system-h2">A closed loop. Zero waste.</h2>
    <p class="system-lead">Three circular economy phases designed to keep premium designer garments in perpetual circulation — from restoration and upcycling to authenticated trade.</p>
  </div>
  <div class="system-grid">
    <div class="sys-col reveal">
      <span class="sys-num">01 / Repair &amp; Renew</span>
      <h3 class="sys-h3">The Restoration Phase</h3>
      <p class="sys-body">Send your worn, faded, or structurally compromised designer garments to our restoration studio. Our expert tailors and textile conservators fix seams, revive dyes, and restore structural integrity to original manufacturing specifications.</p>
      <a href="#connect?plan=archival" class="sys-arrow" aria-label="Request Archival Membership">
        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 10 L10 2 M4 2 H10 V8"/>
        </svg>
      </a>
    </div>
    <div class="sys-col reveal delay-1">
      <span class="sys-num">02 / Upcycle &amp; Evolve</span>
      <h3 class="sys-h3">The Adaptation Phase</h3>
      <p class="sys-body">When a garment no longer fits your personal aesthetic, it undergoes strategic modification. We collaborate with independent designers to reconstruct your pieces, creating limited-edition, custom variations that renew the item's market value.</p>
      <a href="#connect?plan=archival" class="sys-arrow" aria-label="Request Archival Membership">
        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 10 L10 2 M4 2 H10 V8"/>
        </svg>
      </a>
    </div>
    <div class="sys-col reveal delay-2">
      <span class="sys-num">03 / Trade &amp; Circulate</span>
      <h3 class="sys-h3">The Trade Ecosystem</h3>
      <p class="sys-body">Transition your pieces directly out of your digital wardrobe and into our verification ecosystem. Trade your authenticated clothing for credits to acquire curated, pre-circulated garments from other members of the Loop &amp; Layer platform.</p>
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
    <div class="eyebrow" style="justify-content:center;">Membership Tiers</div>
    <h2 class="pricing-h2">Choose your access level.</h2>
    <p class="pricing-sub">Two pathways into the circular economy. One direction.</p>
  </div>
  <div class="pricing-grid">
    <div class="tier-card reveal">
      <div class="tier-label">Entry Access</div>
      <h3 class="tier-name">The Archival Membership</h3>
      <div class="tier-price">$85 <span>/ month</span></div>
      <div class="tier-divider"></div>
      <ul class="tier-features">
        <li><span class="check" aria-hidden="true">&#10022;</span> Two professional garment restorations per quarter</li>
        <li><span class="check" aria-hidden="true">&#10022;</span> Direct access to the digital trading ecosystem with zero transaction fees</li>
        <li><span class="check" aria-hidden="true">&#10022;</span> Complimentary insured shipping on all inward and outward loops</li>
      </ul>
      <a href="#connect?plan=archival" class="btn-mint">Select Archival Tier</a>
    </div>
    <div class="tier-card featured reveal delay-1">
      <div class="tier-badge">Most Popular</div>
      <div class="tier-label">Full Access</div>
      <h3 class="tier-name">The Syndicate Membership</h3>
      <div class="tier-price">$150 <span>/ month</span></div>
      <div class="tier-divider"></div>
      <ul class="tier-features">
        <li><span class="check" aria-hidden="true">&#10022;</span> Unlimited structural repairs and monthly color revivals</li>
        <li><span class="check" aria-hidden="true">&#10022;</span> Priority access to limited-edition upcycled designer collaborations</li>
        <li><span class="check" aria-hidden="true">&#10022;</span> Direct personal closet management and white-glove courier pickup</li>
      </ul>
      <a href="#connect?plan=syndicate" class="btn-mint">Join the Syndicate</a>
    </div>
  </div>
</section>

<section class="verify" id="verify">
  <div class="verify-inner">
    <div class="verify-left">
      <div class="eyebrow reveal">Authentication Protocol</div>
      <h2 class="verify-h2 reveal delay-1">Verifiable authenticity.<br><span>Guaranteed</span> circularity.</h2>
      <p class="verify-body reveal delay-2">Every garment entering our ecosystem passes through a rigorous multi-point physical inspection and digital verification process. We verify stitching patterns, hardware weight, fabric density, and production codes. Our digital tracking system assigns a unique cryptographic ledger entry to each item, documenting its entire restoration history and ownership provenance. You receive a verified asset, every single time.</p>
      <div class="metrics reveal delay-3">
        <div>
          <div class="metric-num">12<sup>+</sup></div>
          <div class="metric-label">Inspection Checkpoints</div>
        </div>
        <div>
          <div class="metric-num">100<sup>%</sup></div>
          <div class="metric-label">Digital Provenance</div>
        </div>
        <div>
          <div class="metric-num">0<sup>%</sup></div>
          <div class="metric-label">Counterfeit Rate</div>
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
      <h3>Initiate your journey</h3>
      <p>Reserved access. Receive early invitations and circular insights.</p>
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
