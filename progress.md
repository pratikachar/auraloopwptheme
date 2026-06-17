# Aura Loop — Project Progress

## File Architecture

```
aura loop/
├── index.html                    # Static landing page (original)
├── Aura-Loop-02.png              # Vertical logo (footer)
├── Aura-Loop-04.png              # Horizontal logo (header)
├── favicon.ico                   # Site favicon
├── submit.php                    # PHP mail handler (fallback)
├── progress.md                   # This file
│
└── aura-loop-theme/              # WordPress theme (zip & install)
    ├── style.css                 # Theme header (Author: colorgraphicz) + all CSS
    ├── screenshot.png            # 1200×900 theme preview
    ├── functions.php             # Setup, menus, widgets, scripts, AJAX form handler
    ├── header.php                # HTML head + primary nav (wp_nav_menu)
    ├── footer.php                # Footer with widget areas + footer nav
    ├── front-page.php            # Full landing page (hero, ticker, sections, form)
    ├── index.php                 # Fallback / blog listing template
    ├── page.php                  # Static pages
    ├── single.php                # Single blog post
    ├── archive.php               # Blog archive / category / tag pages
    ├── 404.php                   # 404 page
    ├── search.php                # Search results
    ├── sidebar.php               # Blog sidebar widget area
    ├── comments.php              # Comment display & form
    ├── submit.php                # Fallback PHP mail handler
    ├── assets/
    │   └── js/theme.js           # All JS (AJAX form, modal, scroll reveal, etc.)
    └── template-parts/
        └── content.php           # Reusable blog card
```

## Completed Features

- [x] Horizontal logo (Aura-Loop-04.png) in header nav
- [x] Vertical logo (Aura-Loop-02.png) in footer
- [x] SEO meta tags (description, keywords, OG, robots) + favicon + preconnect
- [x] Process section arrows link to form with plan=archival/syndicate
- [x] Membership tier buttons link to form with plan preselected
- [x] Contact form dropdown (None / Archival / Syndicate) with auto-selection
- [x] Random math captcha (generated + hashed via wp_hash)
- [x] AJAX form submission with success/error modal popup + nonce CSRF
- [x] Auto-reply email to submitter ("Thanks for reaching out...")
- [x] Submissions saved as CPT `aura_submission` with name, email, plan, vision, IP
- [x] Admin menu (Aura Loop) in WP dashboard with Submissions, Campaigns, New Campaign
- [x] Submissions list table (WP_List_Table) with search, pagination, view, delete
- [x] CSV export of all submissions
- [x] Bulk email campaign system with hourly batch sending (WP Cron)
- [x] Campaign dashboard: start / pause / resume / delete campaigns
- [x] Configurable emails per hour (default 50) per campaign
- [x] Custom DB tables: `aura_campaigns`, `aura_campaign_recipients`
- [x] RankMath SEO plugin setup + sitemap + GSC + GA4 + Meta Pixel + MS Clarity
- [x] Caching: WP Fastest Cache (network), EWWW Image Optimizer (WebP + lazy load)
- [x] Email sent to admin via wp_mail() (From: contact@auraloop.colorgraphicz.in)
- [x] Primary nav menu (header) + footer menu registered
- [x] 5 widget areas (1 sidebar + 4 footer columns)
- [x] Blog archive listing with pagination (archive.php/index.php)
- [x] Single post view (single.php)
- [x] Blog link in header & footer fallback menus
- [x] Full Gutenberg / block editor support
- [x] Plugin compatible (widgets, menus, custom logo, post thumbnails)
- [x] Author: colorgraphicz in theme header

## File Architecture (updated)

```
aura loop/
├── index.html                         # Static landing page (original)
├── Aura-Loop-02.png                   # Vertical logo (footer)
├── Aura-Loop-04.png                   # Horizontal logo (header)
├── favicon.ico                        # Site favicon
├── submit.php                         # PHP mail handler (fallback)
├── progress.md                        # This file
│
└── aura-loop-theme/                   # WordPress theme (zip & install)
    ├── style.css                      # Theme header (Author: colorgraphicz) + all CSS
    ├── screenshot.png                 # 1200×900 theme preview
    ├── functions.php                  # Setup, menus, widgets, scripts, AJAX, CPT, DB, cron
    ├── header.php                     # HTML head + OG + preconnect + primary nav
    ├── footer.php                     # Footer with widget areas + footer nav
    ├── front-page.php                 # Full landing page (hero, ticker, sections, form)
    ├── index.php                      # Fallback / blog listing template
    ├── page.php                       # Static pages
    ├── single.php                     # Single blog post
    ├── archive.php                    # Blog archive / category / tag pages
    ├── 404.php                        # 404 page
    ├── search.php                     # Search results
    ├── sidebar.php                    # Blog sidebar widget area
    ├── comments.php                   # Comment display & form
    ├── submit.php                     # Fallback PHP mail handler
    ├── inc/
    │   └── admin.php                  # Submissions list, CSV export, campaign system
    ├── assets/
    │   └── js/theme.js                # All JS (AJAX, modal, scroll reveal, nonce)
    └── template-parts/
        └── content.php                # Reusable blog card
```

## Known Notes

- Email delivery depends on host SMTP — install **WP Mail SMTP** plugin if emails don't arrive
- Blog link uses `get_post_type_archive_link('post')` — set a "Posts page" in Settings → Reading
- Captcha is hashed with `wp_hash()` to prevent tampering
- Theme is multisafe — Network Enable, then Activate only on primary site
- To see Aura Loop admin menu: refresh WP dashboard after re-saving functions.php (re-activate theme or visit any admin page)
- Campaigns rely on WP Cron — set up a real server cron (see below) for reliable batch sending
