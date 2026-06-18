<?php
/**
 * Aura Loop Theme Functions
 * Author: colorgraphicz
 */

// ==============================
// THEME SETUP
// ==============================
function aura_loop_setup() {
    // Theme supports
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 120,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets',
    ));
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('automatic-feed-links');

    // Register navigation menus
    register_nav_menus(array(
        'primary'           => esc_html__('Primary Menu (Header)', 'aura-loop'),
        'footer'            => esc_html__('Footer Legal Links', 'aura-loop'),
        'mobile'            => esc_html__('Mobile Menu', 'aura-loop'),
        'footer-platform'   => esc_html__('Footer Column — Platform', 'aura-loop'),
        'footer-membership' => esc_html__('Footer Column — Membership', 'aura-loop'),
        'footer-company'    => esc_html__('Footer Column — Company', 'aura-loop'),
    ));

    // Set thumbnail size
    set_post_thumbnail_size(640, 400, true);
    add_image_size('aura-loop-card', 640, 400, true);
}
add_action('after_setup_theme', 'aura_loop_setup');

// ==============================
// ENQUEUE SCRIPTS & STYLES
// ==============================
function aura_loop_scripts() {
    // Google Fonts
    wp_enqueue_style('aura-loop-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Inter:wght@300;400;500&display=swap', array(), null);

    // Theme stylesheet
    wp_enqueue_style('aura-loop-style', get_stylesheet_uri(), array('aura-loop-fonts'), wp_get_theme()->get('Version'));

    // Theme JavaScript
    wp_enqueue_script('aura-loop-theme', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_localize_script('aura-loop-theme', 'auraml_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('aura_contact_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'aura_loop_scripts');

// ==============================
// REGISTER WIDGET AREAS
// ==============================
function aura_loop_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Blog Sidebar', 'aura-loop'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets for the blog sidebar.', 'aura-loop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Column 1', 'aura-loop'),
        'id'            => 'footer-1',
        'description'   => esc_html__('First footer widget column.', 'aura-loop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="footer-col-title">',
        'after_title'   => '</div>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Column 2', 'aura-loop'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Second footer widget column.', 'aura-loop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="footer-col-title">',
        'after_title'   => '</div>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Column 3', 'aura-loop'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Third footer widget column.', 'aura-loop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="footer-col-title">',
        'after_title'   => '</div>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Column 4', 'aura-loop'),
        'id'            => 'footer-4',
        'description'   => esc_html__('Fourth footer widget column.', 'aura-loop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="footer-col-title">',
        'after_title'   => '</div>',
    ));
}
add_action('widgets_init', 'aura_loop_widgets_init');

// ==============================
// CUSTOM WALKER FOR PRIMARY NAV
// ==============================
class Aura_Loop_Walker_Nav_Menu extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent  = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
}

// ==============================
// CUSTOM BODY CLASSES
// ==============================
function aura_loop_body_classes($classes) {
    if (is_singular()) {
        $classes[] = 'singular';
    }
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }
    return $classes;
}
add_filter('body_class', 'aura_loop_body_classes');

// ==============================
// EXCERPT LENGTH
// ==============================
function aura_loop_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'aura_loop_excerpt_length');

function aura_loop_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'aura_loop_excerpt_more');

// ==============================
// CUSTOM COMMENT CALLBACK
// ==============================
function aura_loop_comment($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('comment', $comment); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-meta">
                <?php printf('<span class="fn">%s</span>', get_comment_author_link($comment)); ?>
                <span class="comment-date"> &middot; <?php echo get_comment_date('', $comment); ?></span>
            </div>
            <?php if ('0' === $comment->comment_approved) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'aura-loop'); ?></p>
            <?php endif; ?>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <div class="comment-reply">
                <?php
                comment_reply_link(array_merge($args, array(
                    'reply_text' => esc_html__('Reply', 'aura-loop'),
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth'],
                )));
                ?>
            </div>
        </article>
    <?php
}

// ==============================
// FORM HANDLER (AJAX)
// ==============================
function aura_loop_handle_contact() {
    if (!empty($_POST['_wpnonce']) && !wp_verify_nonce($_POST['_wpnonce'], 'aura_contact_nonce')) {
        wp_send_json_error(array('msg' => 'Session expired. Please refresh and try again.'));
    }

    $name    = isset($_POST['name'])     ? trim($_POST['name'])     : '';
    $email   = isset($_POST['email'])    ? trim($_POST['email'])    : '';
    $plan    = isset($_POST['plan'])     ? trim($_POST['plan'])     : '';
    $vision  = isset($_POST['vision'])   ? trim($_POST['vision'])   : '';
    $captcha = isset($_POST['captcha'])  ? trim($_POST['captcha'])  : '';
    $cap1    = isset($_POST['cap1'])     ? intval($_POST['cap1'])   : 0;
    $cap2    = isset($_POST['cap2'])     ? intval($_POST['cap2'])   : 0;
    $cap_token = isset($_POST['cap_token']) ? trim($_POST['cap_token']) : '';

    if (empty($name) || empty($email)) {
        wp_send_json_error(array('msg' => 'Please fill in all required fields.'));
    }

    if (! is_email($email)) {
        wp_send_json_error(array('msg' => 'Please provide a valid email address.'));
    }

    $expected_answer = $cap1 + $cap2;
    $expected_token = wp_hash($expected_answer . '|aura-loop-captcha');

    if ((int) $captcha !== $expected_answer || $cap_token !== $expected_token) {
        wp_send_json_error(array('msg' => 'Incorrect captcha answer. Please try again.'));
    }

    // Save submission as CPT
    $post_id = wp_insert_post(array(
        'post_type'   => 'aura_submission',
        'post_title'  => 'Submission from ' . $name,
        'post_status' => 'publish',
        'meta_input'  => array(
            '_aura_name'       => $name,
            '_aura_email'      => $email,
            '_aura_plan'       => $plan,
            '_aura_vision'     => $vision,
            '_aura_ip'         => $_SERVER['REMOTE_ADDR'] ?? '',
            '_aura_user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ),
    ));

    if (!$post_id) {
        wp_send_json_error(array('msg' => 'Server error. Please try again or contact us directly.'));
    }

    // Notify admin
    $to = 'project.colorgraphicz@gmail.com';
    $subject = "Aura Loop — New Membership Inquiry from $name";
    $body = "Name: $name\nEmail: $email\nPlan: " . ($plan ?: 'Not specified') . "\nVision: " . ($vision ?: 'Not provided') . "\nSubmitted: " . current_time('mysql');
    $headers = array(
        'From: Aura Loop <contact@auraloop.colorgraphicz.in>',
        'Reply-To: ' . $email,
        'Content-Type: text/plain; charset=UTF-8',
    );
    wp_mail($to, $subject, $body, $headers);

    // Auto-reply to submitter
    $reply_subject = 'Welcome to Aura Loop — We\'ve Received Your Request';
    $reply_body = "Hi $name,\n\nThanks for reaching out. Our loop agent will contact you soon!\n\nStay tuned,\nThe Aura Loop Team";
    $reply_headers = array(
        'From: Aura Loop <contact@auraloop.colorgraphicz.in>',
        'Content-Type: text/plain; charset=UTF-8',
    );
    wp_mail($email, $reply_subject, $reply_body, $reply_headers);

    wp_send_json_success(array('msg' => 'Thank you! Your request has been received. Welcome to the Loop.'));
}
add_action('wp_ajax_nopriv_aura_loop_contact', 'aura_loop_handle_contact');
add_action('wp_ajax_aura_loop_contact', 'aura_loop_handle_contact');

// ==============================
// SEARCH FORM
// ==============================
function aura_loop_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '" style="max-width:400px; margin:0 auto 3rem; display:flex; gap:0.5rem; padding:0 5rem;">
        <input type="search" class="search-field" placeholder="' . esc_attr__('Search...', 'aura-loop') . '" value="' . get_search_query() . '" name="s" style="flex:1; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.12); border-radius:24px; padding:0.8rem 1.2rem; font-family:var(--font-b); font-size:0.85rem; color:var(--white);">
        <button type="submit" class="search-submit btn-mint" style="padding:0.8rem 1.5rem; border-radius:24px; border:none;">' . esc_html__('Search', 'aura-loop') . '</button>
    </form>';
    return $form;
}
add_filter('get_search_form', 'aura_loop_search_form');

// ==============================
// INCLUDE ADMIN MODULE
// ==============================
require_once get_template_directory() . '/inc/admin.php';

// ==============================
// CPT: AURA SUBMISSIONS
// ==============================
function aura_register_submission_cpt() {
    register_post_type('aura_submission', array(
        'public'       => false,
        'show_ui'      => false,
        'show_in_menu' => false,
        'capability_type' => 'post',
        'capabilities' => array('create_posts' => 'do_not_allow'),
        'supports'     => array('title'),
    ));
}
add_action('init', 'aura_register_submission_cpt');

// ==============================
// DB TABLES: CAMPAIGNS & RECIPIENTS
// ==============================
function aura_create_db_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $prefix = $wpdb->prefix;

    $sql1 = "CREATE TABLE IF NOT EXISTS {$prefix}aura_campaigns (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(255) NOT NULL DEFAULT '',
        message TEXT NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'draft',
        emails_per_hour INT UNSIGNED NOT NULL DEFAULT 50,
        total_count INT UNSIGNED NOT NULL DEFAULT 0,
        sent_count INT UNSIGNED NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) $charset_collate;";

    $sql2 = "CREATE TABLE IF NOT EXISTS {$prefix}aura_campaign_recipients (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        campaign_id BIGINT UNSIGNED NOT NULL,
        submission_id BIGINT UNSIGNED NOT NULL,
        email VARCHAR(255) NOT NULL DEFAULT '',
        sent TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
        sent_at DATETIME NULL,
        INDEX (campaign_id),
        INDEX (submission_id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql1);
    dbDelta($sql2);
}
add_action('after_switch_theme', 'aura_create_db_tables');

function aura_check_db_tables() {
    global $wpdb;
    $table = $wpdb->prefix . 'aura_campaigns';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") !== $table) {
        aura_create_db_tables();
    }
}
add_action('admin_init', 'aura_check_db_tables');

// ==============================
// CRON: SCHEDULE CAMPAIGN BATCH
// ==============================
function aura_schedule_campaign_cron() {
    if (!wp_next_scheduled('aura_send_campaign_batch')) {
        wp_schedule_event(time(), 'hourly', 'aura_send_campaign_batch');
    }
}
add_action('init', 'aura_schedule_campaign_cron');

function aura_clear_campaign_cron() {
    $t = wp_next_scheduled('aura_send_campaign_batch');
    if ($t) wp_unschedule_event($t, 'aura_send_campaign_batch');
}
add_action('switch_theme', 'aura_clear_campaign_cron');

// ==============================
// CUSTOMIZER: SOCIAL LINKS
// ==============================
function aura_customize_register($wp_customize) {
    $wp_customize->add_section('aura_social', array(
        'title'    => __('Social Media', 'aura-loop'),
        'priority' => 130,
    ));

    $networks = array(
        'youtube'  => 'YouTube URL',
        'linkedin' => 'LinkedIn URL',
        'facebook' => 'Facebook URL',
        'instagram' => 'Instagram URL',
    );

    foreach ($networks as $key => $label) {
        $wp_customize->add_setting("aura_social_$key", array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("aura_social_$key", array(
            'label'   => $label,
            'section' => 'aura_social',
            'type'    => 'url',
        ));
    }
}
add_action('customize_register', 'aura_customize_register');

// ==============================
// AUTO-CREATE LEGAL PAGES ON THEME ACTIVATION
// ==============================
function aura_create_legal_pages() {
    $pages = array(
        'privacy-policy' => array(
            'title' => 'Privacy Policy',
            'content' => '<h2>Privacy Policy</h2><p>Last updated: June 2026</p><p>Aura Loop ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p><h3>Information We Collect</h3><p>We collect personal information you voluntarily provide when you fill out our contact form, including your name, email address, and any details you share about your fashion restoration or membership interests.</p><h3>How We Use Your Information</h3><p>We use the information we collect to respond to your inquiries, process membership requests, improve our platform, send relevant updates about our circular fashion ecosystem, and comply with legal obligations.</p><h3>Data Protection</h3><p>We implement appropriate technical and organizational measures to protect your personal data. Your information is stored securely and only accessed by authorized personnel.</p><h3>Third-Party Services</h3><p>We may use third-party services for analytics and marketing. These service providers have their own privacy policies governing data handling.</p><h3>Your Rights</h3><p>You have the right to access, correct, or delete your personal data. To exercise these rights, please contact us through our website.</p><h3>Cookies</h3><p>We use cookies to enhance your browsing experience. See our Cookie Policy for details.</p><h3>Changes to This Policy</h3><p>We may update this Privacy Policy periodically. Changes will be posted on this page.</p>',
        ),
        'terms-of-service' => array(
            'title' => 'Terms of Service',
            'content' => '<h2>Terms of Service</h2><p>Last updated: June 2026</p><p>By accessing or using Aura Loop\'s website and services, you agree to be bound by these Terms of Service.</p><h3>Services Description</h3><p>Aura Loop provides a platform for luxury streetwear restoration, upcycling, authentication, and trade through a sustainable membership model. Our services include archival preservation, syndicate membership, and digital verification.</p><h3>Membership Terms</h3><p>Membership tiers are subject to availability and may be updated. Members agree to provide accurate information and comply with platform guidelines. Membership fees are non-refundable unless otherwise stated.</p><h3>Intellectual Property</h3><p>All content, trademarks, and intellectual property on this platform are owned by Aura Loop. You may not reproduce, distribute, or create derivative works without permission.</p><h3>Limitation of Liability</h3><p>Aura Loop is not liable for indirect, incidental, or consequential damages arising from your use of the platform. Our total liability is limited to the amount paid for services.</p><h3>Governing Law</h3><p>These terms are governed by applicable laws. Any disputes shall be resolved through arbitration.</p><h3>Changes to Terms</h3><p>We reserve the right to modify these terms. Continued use constitutes acceptance of updated terms.</p>',
        ),
        'cookie-policy' => array(
            'title' => 'Cookie Policy',
            'content' => '<h2>Cookie Policy</h2><p>Last updated: June 2026</p><p>Aura Loop uses cookies and similar tracking technologies to enhance your browsing experience, analyze site traffic, and understand where our audience comes from.</p><h3>What Are Cookies</h3><p>Cookies are small text files stored on your device when you visit a website. They help us remember your preferences and improve site functionality.</p><h3>Types of Cookies We Use</h3><p><strong>Essential Cookies:</strong> Required for basic site functionality and security.</p><p><strong>Analytics Cookies:</strong> Help us understand how visitors interact with our site, which pages are most popular, and how users navigate.</p><p><strong>Functional Cookies:</strong> Remember your preferences and settings for a personalized experience.</p><h3>Managing Cookies</h3><p>You can control cookies through your browser settings. Disabling certain cookies may affect site functionality.</p><h3>Third-Party Cookies</h3><p>We may use third-party services that set their own cookies. These are governed by the respective third-party privacy policies.</p><h3>Updates</h3><p>We may update this Cookie Policy periodically. Changes will be posted here.</p>',
        ),
    );

    foreach ($pages as $slug => $data) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if (!$existing) {
            wp_insert_post(array(
                'post_title'   => $data['title'],
                'post_content' => $data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_name'    => $slug,
            ));
        }
    }
}
add_action('after_switch_theme', 'aura_create_legal_pages');

// ==============================
// FRONT PAGE CUSTOM FIELDS (META BOXES)
// ==============================
function aura_front_defaults() {
    return array(
        'hero_eyebrow'    => 'Circular Fashion Technology',
        'hero_headline'   => "The end of the<br>\n<span class=\"struck\">temporary</span><br>\nwardrobe.<br>\nOwn the <span class=\"hi\">style.</span><br>\nCirculate the asset.",
        'hero_lead'       => 'Aura Loop is a premium circular fashion ecosystem for luxury streetwear and designer apparel. We repair, upcycle, authenticate, and trade high-end garments, transforming clothing from a depreciating purchase into an evolving lifestyle asset through sustainable fashion membership.',
        'hero_cta_1'      => 'Initiate Your First Loop',
        'hero_cta_1_url'  => '#connect',
        'hero_cta_2'      => 'How the Ecosystem Works',
        'hero_cta_2_url'  => '#system',
        'ticker_items'    => "Repair\nRenew\nUpcycle\nEvolve\nTrade\nCirculate\nAuthenticate\nPreserve\nElevate",
        'problem_eyebrow' => 'The Inconvenient Truth',
        'problem_heading' => "The high cost of<br><em>disposable</em> luxury.",
        'problem_p1'      => 'Modern streetwear was built on exclusivity and structural integrity, yet the current fashion cycle forces premature obsolescence. Minor tears, natural fading, and changing personal tastes relegate thousands of dollars of premium, heavyweight cotton and technical outerwear to the back of closets or landfills.',
        'problem_p2'      => 'True luxury is not disposable. The modern wardrobe requires an infrastructure that respects both the craft of design and the necessity of preservation. Buying new is a linear dead end. Buying for longevity is the new market standard.',
        'system_eyebrow'  => 'The Process',
        'system_heading'  => 'A closed loop. Zero waste.',
        'system_lead'     => 'Three circular economy phases designed to keep premium designer garments in perpetual circulation — from restoration and upcycling to authenticated trade.',
        'system_1_num'    => '01 / Repair & Renew',
        'system_1_title'  => 'The Restoration Phase',
        'system_1_desc'   => 'Send your worn, faded, or structurally compromised designer garments to our restoration studio. Our expert tailors and textile conservators fix seams, revive dyes, and restore structural integrity to original manufacturing specifications.',
        'system_2_num'    => '02 / Upcycle & Evolve',
        'system_2_title'  => 'The Adaptation Phase',
        'system_2_desc'   => 'When a garment no longer fits your personal aesthetic, it undergoes strategic modification. We collaborate with independent designers to reconstruct your pieces, creating limited-edition, custom variations that renew the item\'s market value.',
        'system_3_num'    => '03 / Trade & Circulate',
        'system_3_title'  => 'The Trade Ecosystem',
        'system_3_desc'   => 'Transition your pieces directly out of your digital wardrobe and into our verification ecosystem. Trade your authenticated clothing for credits to acquire curated, pre-circulated garments from other members of the Loop & Layer platform.',
        'pricing_eyebrow' => 'Membership Tiers',
        'pricing_heading' => 'Choose your access level.',
        'pricing_sub'     => 'Two pathways into the circular economy. One direction.',
        'tier1_label'       => 'Entry Access',
        'tier1_name'        => 'The Archival Membership',
        'tier1_price'       => '$85',
        'tier1_price_label' => '/ month',
        'tier1_features'    => "Two professional garment restorations per quarter\nDirect access to the digital trading ecosystem with zero transaction fees\nComplimentary insured shipping on all inward and outward loops",
        'tier1_cta'         => 'Select Archival Tier',
        'tier1_cta_url'     => '#connect?plan=archival',
        'tier2_badge'       => 'Most Popular',
        'tier2_label'       => 'Full Access',
        'tier2_name'        => 'The Syndicate Membership',
        'tier2_price'       => '$150',
        'tier2_price_label' => '/ month',
        'tier2_features'    => "Unlimited structural repairs and monthly color revivals\nPriority access to limited-edition upcycled designer collaborations\nDirect personal closet management and white-glove courier pickup",
        'tier2_cta'         => 'Join the Syndicate',
        'tier2_cta_url'     => '#connect?plan=syndicate',
        'verify_eyebrow'  => 'Authentication Protocol',
        'verify_heading'  => "Verifiable authenticity.<br><span>Guaranteed</span> circularity.",
        'verify_body'     => 'Every garment entering our ecosystem passes through a rigorous multi-point physical inspection and digital verification process. We verify stitching patterns, hardware weight, fabric density, and production codes. Our digital tracking system assigns a unique cryptographic ledger entry to each item, documenting its entire restoration history and ownership provenance. You receive a verified asset, every single time.',
        'verify_metric_1_num'   => '12+',
        'verify_metric_1_label' => 'Inspection Checkpoints',
        'verify_metric_2_num'   => '100%',
        'verify_metric_2_label' => 'Digital Provenance',
        'verify_metric_3_num'   => '0%',
        'verify_metric_3_label' => 'Counterfeit Rate',
        'form_heading' => 'Initiate your journey',
        'form_text'    => 'Reserved access. Receive early invitations and circular insights.',
        'footer_desc'  => 'A premium circular fashion technology platform dedicated to luxury streetwear restoration, upcycling, authentication, and trade — preserving designer craftsmanship for generations through sustainable membership.',
    );
}

function aura_get_front_field($key) {
    $defaults = aura_front_defaults();
    $front_id = (int) get_option('page_on_front');
    if (!$front_id) $front_id = get_the_ID();
    $val = get_post_meta($front_id, '_aura_' . $key, true);
    return $val !== '' ? $val : ($defaults[$key] ?? '');
}

function aura_add_front_meta_boxes() {
    $front_id = (int) get_option('page_on_front');
    if (!$front_id) return;
    add_meta_box('aura_front_fields', __('Home Page Content', 'aura-loop'), 'aura_render_front_meta_box', 'page', 'normal', 'high');
}
add_action('add_meta_boxes', 'aura_add_front_meta_boxes');

function aura_render_front_meta_box($post) {
    wp_nonce_field('aura_front_save', 'aura_front_nonce');
    $defaults = aura_front_defaults();
    $sections = array(
        'Hero' => array(
            'hero_eyebrow'    => array('label' => 'Eyebrow', 'type' => 'text'),
            'hero_headline'   => array('label' => 'Headline (HTML allowed)', 'type' => 'textarea', 'rows' => 6),
            'hero_lead'       => array('label' => 'Lead paragraph', 'type' => 'textarea', 'rows' => 4),
            'hero_cta_1'      => array('label' => 'CTA 1 text', 'type' => 'text'),
            'hero_cta_1_url'  => array('label' => 'CTA 1 link', 'type' => 'text'),
            'hero_cta_2'      => array('label' => 'CTA 2 text', 'type' => 'text'),
            'hero_cta_2_url'  => array('label' => 'CTA 2 link', 'type' => 'text'),
        ),
        'Ticker' => array(
            'ticker_items'    => array('label' => 'Ticker words (one per line)', 'type' => 'textarea', 'rows' => 6),
        ),
        'Truth / Problem' => array(
            'problem_eyebrow' => array('label' => 'Eyebrow', 'type' => 'text'),
            'problem_heading' => array('label' => 'Heading (HTML)', 'type' => 'textarea', 'rows' => 3),
            'problem_p1'      => array('label' => 'Paragraph 1', 'type' => 'textarea', 'rows' => 4),
            'problem_p2'      => array('label' => 'Paragraph 2', 'type' => 'textarea', 'rows' => 4),
        ),
        'System / Process' => array(
            'system_eyebrow'  => array('label' => 'Eyebrow', 'type' => 'text'),
            'system_heading'  => array('label' => 'Heading', 'type' => 'text'),
            'system_lead'     => array('label' => 'Lead paragraph', 'type' => 'textarea', 'rows' => 3),
            'system_1_num'    => array('label' => 'Card 1 — Number', 'type' => 'text'),
            'system_1_title'  => array('label' => 'Card 1 — Title', 'type' => 'text'),
            'system_1_desc'   => array('label' => 'Card 1 — Description', 'type' => 'textarea', 'rows' => 3),
            'system_2_num'    => array('label' => 'Card 2 — Number', 'type' => 'text'),
            'system_2_title'  => array('label' => 'Card 2 — Title', 'type' => 'text'),
            'system_2_desc'   => array('label' => 'Card 2 — Description', 'type' => 'textarea', 'rows' => 3),
            'system_3_num'    => array('label' => 'Card 3 — Number', 'type' => 'text'),
            'system_3_title'  => array('label' => 'Card 3 — Title', 'type' => 'text'),
            'system_3_desc'   => array('label' => 'Card 3 — Description', 'type' => 'textarea', 'rows' => 3),
        ),
        'Pricing / Membership' => array(
            'pricing_eyebrow' => array('label' => 'Eyebrow', 'type' => 'text'),
            'pricing_heading' => array('label' => 'Heading', 'type' => 'text'),
            'pricing_sub'     => array('label' => 'Subtitle', 'type' => 'text'),
            'tier1_label'       => array('label' => 'Tier 1 — Label', 'type' => 'text'),
            'tier1_name'        => array('label' => 'Tier 1 — Name', 'type' => 'text'),
            'tier1_price'       => array('label' => 'Tier 1 — Price', 'type' => 'text'),
            'tier1_price_label' => array('label' => 'Tier 1 — Price suffix', 'type' => 'text'),
            'tier1_features'    => array('label' => 'Tier 1 — Features (one per line)', 'type' => 'textarea', 'rows' => 4),
            'tier1_cta'         => array('label' => 'Tier 1 — CTA text', 'type' => 'text'),
            'tier1_cta_url'     => array('label' => 'Tier 1 — CTA link', 'type' => 'text'),
        ),
        'Pricing — Tier 2' => array(
            'tier2_badge'       => array('label' => 'Tier 2 — Badge', 'type' => 'text'),
            'tier2_label'       => array('label' => 'Tier 2 — Label', 'type' => 'text'),
            'tier2_name'        => array('label' => 'Tier 2 — Name', 'type' => 'text'),
            'tier2_price'       => array('label' => 'Tier 2 — Price', 'type' => 'text'),
            'tier2_price_label' => array('label' => 'Tier 2 — Price suffix', 'type' => 'text'),
            'tier2_features'    => array('label' => 'Tier 2 — Features (one per line)', 'type' => 'textarea', 'rows' => 4),
            'tier2_cta'         => array('label' => 'Tier 2 — CTA text', 'type' => 'text'),
            'tier2_cta_url'     => array('label' => 'Tier 2 — CTA link', 'type' => 'text'),
        ),
        'Verification' => array(
            'verify_eyebrow'  => array('label' => 'Eyebrow', 'type' => 'text'),
            'verify_heading'  => array('label' => 'Heading (HTML)', 'type' => 'textarea', 'rows' => 3),
            'verify_body'     => array('label' => 'Body text', 'type' => 'textarea', 'rows' => 5),
            'verify_metric_1_num'   => array('label' => 'Metric 1 — Number', 'type' => 'text'),
            'verify_metric_1_label' => array('label' => 'Metric 1 — Label', 'type' => 'text'),
            'verify_metric_2_num'   => array('label' => 'Metric 2 — Number', 'type' => 'text'),
            'verify_metric_2_label' => array('label' => 'Metric 2 — Label', 'type' => 'text'),
            'verify_metric_3_num'   => array('label' => 'Metric 3 — Number', 'type' => 'text'),
            'verify_metric_3_label' => array('label' => 'Metric 3 — Label', 'type' => 'text'),
        ),
        'Form / Contact' => array(
            'form_heading' => array('label' => 'Heading', 'type' => 'text'),
            'form_text'    => array('label' => 'Subtitle', 'type' => 'text'),
        ),
        'Footer' => array(
            'footer_desc'  => array('label' => 'Footer description', 'type' => 'textarea', 'rows' => 3),
        ),
    );

    foreach ($sections as $section_name => $fields) {
        echo '<div style="margin:0 -12px 16px; padding:12px 14px; background:rgba(0,0,0,0.02); border-bottom:1px solid #e0e0e0;">';
        echo '<h3 style="margin:0 0 12px; font-size:13px; text-transform:uppercase; letter-spacing:1px; color:#666;">' . esc_html($section_name) . '</h3>';
        foreach ($fields as $key => $def) {
            $val = get_post_meta($post->ID, '_aura_' . $key, true);
            if ($val === '') $val = $defaults[$key] ?? '';
            $id = 'aura_field_' . $key;
            echo '<div style="margin-bottom:10px;">';
            echo '<label for="' . esc_attr($id) . '" style="display:block; font-weight:600; font-size:12px; margin-bottom:3px; color:#444;">' . esc_html($def['label']) . '</label>';
            if ($def['type'] === 'textarea') {
                $rows = isset($def['rows']) ? (int) $def['rows'] : 4;
                echo '<textarea id="' . esc_attr($id) . '" name="_aura_' . esc_attr($key) . '" rows="' . $rows . '" style="width:100%; padding:6px 8px; border:1px solid #ccc; border-radius:4px; font-size:13px;">' . esc_textarea($val) . '</textarea>';
            } else {
                echo '<input type="text" id="' . esc_attr($id) . '" name="_aura_' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%; padding:5px 8px; border:1px solid #ccc; border-radius:4px; font-size:13px;">';
            }
            echo '</div>';
        }
        echo '</div>';
    }
}

function aura_save_front_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['aura_front_nonce']) || !wp_verify_nonce($_POST['aura_front_nonce'], 'aura_front_save')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $defaults = aura_front_defaults();
    foreach ($defaults as $key => $default) {
        $field_key = '_aura_' . $key;
        if (isset($_POST[$field_key])) {
            update_post_meta($post_id, $field_key, wp_kses_post(stripslashes($_POST[$field_key])));
        }
    }
}
add_action('save_post', 'aura_save_front_meta_box');
