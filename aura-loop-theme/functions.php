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
        'primary' => esc_html__('Primary Menu (Header)', 'aura-loop'),
        'footer'  => esc_html__('Footer Menu', 'aura-loop'),
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
    $to = get_option('admin_email');
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
