# Aura Loop — Project Progress

## Goal
Convert a static luxury streetwear circular-fashion landing page into a fully functional WordPress theme with AJAX form, random captcha, modal popups, blog support, multisite compatibility, admin submission panel, bulk email campaign system, and editable front page content via WordPress meta boxes.

## Owner / Author
- Theme author: **colorgraphicz**
- GitHub: `pratikachar/auraloopwptheme`

## Theme Structure
```
aura-loop-theme/
├── style.css                     # Theme header + all CSS (design tokens, hero, sections, blog, modal, hamburger, mobile menu, social icons, rings, responsive)
├── screenshot.png                # 1200×900 preview
├── functions.php                 # Setup, 6 nav menus, 5 widget areas, enqueue, random captcha, AJAX handler, CPT, DB tables, cron, Customizer (social), legal page auto-create, meta box system (50+ front page fields)
├── header.php                    # HTML head + OG + preconnect + primary nav + hamburger + mobile menu overlay with close button
├── footer.php                    # 4 footer columns (wp_nav_menu) + social icons (Customizer) + legal links (wp_nav_menu) + back-to-top
├── front-page.php                # Full landing page — all text pulled from `aura_get_front_field()` with fallbacks
├── index.php                     # Fallback / blog listing
├── page.php                      # Static pages
├── single.php                    # Single blog post
├── archive.php                   # Blog archive / category / tag
├── 404.php                       # 404 page
├── search.php                    # Search results
├── sidebar.php                   # Blog sidebar
├── comments.php                  # Comment display & form
├── inc/
│   └── admin.php                 # Submissions list (direct SQL), CSV export (BOM prefix), campaigns list, new campaign, cron batch sender
├── assets/
│   └── js/theme.js               # Sticky nav, scroll reveal, plan selection, modal popup, AJAX form (fetch + nonce), ticker, hamburger toggle, escape key close, custom smooth back-to-top, reduced-motion respect
└── template-parts/
    └── content.php               # Reusable blog card
```

## Completed Features

### Navigation & Menus
- [x] 6 menu locations registered: Primary, Mobile, Footer Legal, Footer Platform, Footer Membership, Footer Company
- [x] Primary nav with `wp_nav_menu` + fallback links
- [x] Mobile menu overlay with close button + escape-key close + link-click close
- [x] Hamburger button (z-index: 260) + mobile menu (z-index: 250) + visibility/opacity transition
- [x] Footer columns use `wp_nav_menu` with hardcoded fallbacks
- [x] Footer legal links use `wp_nav_menu` with hardcoded fallbacks

### Front Page Content (100% editable from WP Admin — no plugin needed)
- [x] Custom meta box "Home Page Content" on the front page editor
- [x] 7 section groups: Hero, Ticker, Truth/Problem, System/Process, Pricing (2 tiers), Verification (3 metrics), Form, Footer
- [x] ~50 fields: text inputs + textareas with built-in default fallbacks
- [x] All fields saved as post meta (`_aura_*`), retrieved via `aura_get_front_field()`
- [x] Safe HTML allowed via `wp_kses_post()`

### Contact Form
- [x] AJAX submission via `admin-ajax.php` + `fetch()` — no page redirect
- [x] Beautiful modal popup with close button (success / error)
- [x] Random math captcha (generated per page load, hashed via `wp_hash()`)
- [x] Nonce CSRF protection (graceful fallback for cached pages)
- [x] Submission saved as CPT `aura_submission` (name, email, plan, vision, IP, user agent)
- [x] Admin notification sent to `project.colorgraphicz@gmail.com`
- [x] Auto-reply to submitter ("Thanks for reaching out. Our loop agent will contact you soon!")
- [x] All emails From: `contact@auraloop.colorgraphicz.in`

### Admin Dashboard
- [x] Aura Loop admin menu with Submissions, Campaigns, New Campaign
- [x] Submissions list table (direct SQL — bypasses WP_Query/plugin conflicts)
- [x] CSV export with UTF-8 BOM (fixes Excel SYLK error), column "Entry" instead of "ID"
- [x] Bulk email campaign system with hourly WP Cron batch sending
- [x] Campaign actions: start / pause / resume / delete (with nonce verification)

### Email System
- [x] Hardcoded sender: `contact@auraloop.colorgraphicz.in`
- [x] Hardcoded admin to: `project.colorgraphicz@gmail.com`
- [x] Auto-reply to submitter
- [x] Campaign batch emails via hourly cron
- [x] `wp_mail_from` / `wp_mail_from_name` recommended for future sub-site themes

### Mobile
- [x] Hamburger menu toggle (z-index 260/250)
- [x] Close button inside menu + escape key + link-click close
- [x] Mobile loop ring animation (`hero-visual-mobile`, hidden on desktop)
- [x] Responsive breakpoints (900px, 600px)
- [x] Hero section `min-height: 130vh` on mobile to prevent scroll-text overlap

### Back-to-Top
- [x] Custom smooth scroll easing (cubic bezier, 900ms, `requestAnimationFrame`)

### SEO / Analytics
- [x] RankMath SEO plugin + sitemap + Google Search Console + GA4 + Meta Pixel + MS Clarity
- [x] Open Graph tags in header.php

### Caching
- [x] WP Fastest Cache (network activated)
- [x] EWWW Image Optimizer (WebP + lazy load)

### Legal Pages
- [x] Auto-created on theme activation: Privacy Policy, Terms of Service, Cookie Policy
- [x] Content includes brand-specific text (circular fashion, membership, restoration)

### Blog
- [x] Blog link uses `get_post_type_archive_link('post')`
- [x] archive.php + single.php with sidebar, pagination, featured images
- [x] Template parts for reusable blog cards

### Compatibility
- [x] Gutenberg / block editor support
- [x] Post thumbnails, custom logo, widgets, nav menus
- [x] Plugin compatible
- [x] Multisafe: Network Enable, activate only on primary site

### Git
- [x] GitHub: `pratikachar/auraloopwptheme`
- [x] `.gitignore` excludes zip files
- [x] All pushes include commit with descriptive messages

## Known Notes
- Email delivery depends on host SMTP — install **WP Mail SMTP** if emails don't arrive
- Blog link requires a "Posts page" set in Settings → Reading + at least one published post
- Captcha is hashed via `wp_hash($answer . '|aura-loop-captcha')` — tamper-proof
- To trigger DB table creation: switch to any other theme and back to Aura Loop
- Campaign batches rely on WP Cron — real server cron recommended:
  `*/5 * * * * wget -q -O- "https://auraloop.colorgraphicz.in/wp-cron.php?doing_wp_cron=1" >/dev/null 2>&1`
- Default content shows when meta box fields are left empty (graceful fallbacks in `aura_front_defaults()`)
- Menus with fallback: create menus in **Appearance > Menus**, assign to locations, and they override hardcoded links

## Next Steps
1. Create menus in Appearance > Menus (Primary, Mobile, Footer Legal, Footer Platform, Footer Membership, Footer Company)
2. Edit front page text via the "Home Page Content" meta box on the front page
3. Confirm campaign email delivery
4. Start first new sub-site project (Phase 1 → Phase 2 prompts)
