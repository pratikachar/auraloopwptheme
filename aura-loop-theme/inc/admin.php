<?php
/**
 * Aura Loop Admin Module
 * Author: colorgraphicz
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}



// ==============================
// ADMIN MENU
// ==============================
function aura_admin_menu() {
    $icon = 'data:image/svg+xml;base64,' . base64_encode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="10" cy="10" r="8"/><path d="M10 2v16M2 10h16"/></svg>'
    );

    add_menu_page('Aura Loop', 'Aura Loop', 'manage_options', 'aura-loop', 'aura_submissions_page', $icon, 30);
    add_submenu_page('aura-loop', 'Submissions', 'Submissions', 'manage_options', 'aura-loop', 'aura_submissions_page');
    add_submenu_page('aura-loop', 'Campaigns', 'Campaigns', 'manage_options', 'aura-campaigns', 'aura_campaigns_page');
    add_submenu_page('aura-loop', 'New Campaign', 'New Campaign', 'manage_options', 'aura-new-campaign', 'aura_new_campaign_page');
}
add_action('admin_menu', 'aura_admin_menu');

// ==============================
// ADMIN STYLES
// ==============================
function aura_admin_head_styles() {
    $screen = get_current_screen();
    if (!$screen || strpos($screen->id, 'aura-') === false && $screen->id !== 'toplevel_page_aura-loop') return;
    ?>
    <style>
    .aura-wrap { max-width: 1200px; margin: 20px 0; }
    .aura-wrap h1 { margin-bottom: 20px; display: flex; align-items: center; gap: 12px; }
    .aura-cf { background: #1d2327; padding: 24px 28px; border-radius: 8px; max-width: 780px; border: 1px solid #2c3338; }
    .aura-cf label { display: block; color: #9ca2a7; margin: 16px 0 4px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; }
    .aura-cf input[type="text"], .aura-cf textarea { width: 100%; padding: 10px 14px; background: #2c3338; border: 1px solid #3c434a; border-radius: 6px; color: #e0e0e0; font-size: 14px; }
    .aura-cf textarea { min-height: 180px; font-family: monospace; }
    .aura-cf .submit-row { margin-top: 24px; }
    .aura-cf .aura-recipients { background: #2c3338; border: 1px solid #3c434a; border-radius: 6px; padding: 12px 16px; max-height: 260px; overflow-y: auto; margin: 8px 0 0; }
    .aura-cf .aura-recipients li { padding: 4px 0; color: #c3c9cf; font-size: 13px; border-bottom: 1px solid #333; }
    .aura-cf .aura-recipients li:last-child { border-bottom: none; }
    .aura-detail { background: #1d2327; padding: 20px 24px; border-radius: 8px; margin-top: 20px; border: 1px solid #2c3338; }
    .aura-detail p { margin: 8px 0; }
    .aura-detail strong { color: #9ca2a7; min-width: 110px; display: inline-block; }
    .camp-status { display: inline-block; padding: 2px 12px; border-radius: 10px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
    .camp-status.active { background: #1a6b38; color: #b5f5c2; }
    .camp-status.draft { background: #3c434a; color: #c3c9cf; }
    .camp-status.paused { background: #7a5d1a; color: #ffe58f; }
    .camp-status.completed { background: #1a446b; color: #b5d5f5; }
    .aura-msg { padding: 10px 16px; border-radius: 6px; margin: 0 0 16px; display: inline-block; }
    .aura-msg.success { background: #1a6b38; color: #b5f5c2; }
    .aura-msg.error { background: #6b1a1a; color: #f5b5b5; }
    </style>
    <?php
}
add_action('admin_head', 'aura_admin_head_styles');

// ==============================
// ACTION PROCESSOR
// ==============================
function aura_process_admin_actions() {
    global $wpdb;

    if (!is_admin() || !current_user_can('manage_options')) return;

    $page = sanitize_key($_REQUEST['page'] ?? '');

    // --- CSV export (run early before any output) ---
    if ($page === 'aura-loop' && !empty($_GET['export']) && $_GET['export'] === 'csv') {
        aura_export_csv();
        exit;
    }

    // --- Submissions: single delete ---
    if ($page === 'aura-loop' && !empty($_GET['action']) && $_GET['action'] === 'delete' && !empty($_GET['id'])) {
        $id = intval($_GET['id']);
        check_admin_referer('aura_delete_' . $id);
        wp_delete_post($id, true);
        wp_redirect(add_query_arg(array('page' => 'aura-loop', 'msg' => 'deleted'), admin_url('admin.php')));
        exit;
    }

    // --- Submissions: bulk actions ---
    if ($page === 'aura-loop' && !empty($_REQUEST['submission_ids'])) {
        $bulk_action = '';
        if (!empty($_REQUEST['action']) && $_REQUEST['action'] !== '-1') {
            $bulk_action = sanitize_key($_REQUEST['action']);
        } elseif (!empty($_REQUEST['action2']) && $_REQUEST['action2'] !== '-1') {
            $bulk_action = sanitize_key($_REQUEST['action2']);
        }

        if ($bulk_action && check_admin_referer('bulk-submissions')) {
            $ids = array_map('intval', $_REQUEST['submission_ids']);

            if ($bulk_action === 'delete') {
                foreach ($ids as $id) wp_delete_post($id, true);
                wp_redirect(add_query_arg(array('page' => 'aura-loop', 'msg' => 'deleted'), admin_url('admin.php')));
                exit;
            }

            if ($bulk_action === 'campaign') {
                wp_redirect(add_query_arg(array('page' => 'aura-new-campaign', 'ids' => implode(',', $ids)), admin_url('admin.php')));
                exit;
            }
        }
    }

    // --- Campaign actions (start / pause / resume / delete) ---
    if ($page === 'aura-campaigns' && !empty($_GET['action']) && !empty($_GET['id'])) {
        $action = sanitize_key($_GET['action']);
        $id     = intval($_GET['id']);
        $table  = $wpdb->prefix . 'aura_campaigns';

        check_admin_referer('campaign_' . $action . '_' . $id);

        switch ($action) {
            case 'start':
                $wpdb->update($table, array('status' => 'active'), array('id' => $id));
                $msg = 'started';
                break;
            case 'pause':
                $wpdb->update($table, array('status' => 'paused'), array('id' => $id));
                $msg = 'paused';
                break;
            case 'resume':
                $wpdb->update($table, array('status' => 'active'), array('id' => $id));
                $msg = 'resumed';
                break;
            case 'delete':
                $wpdb->delete($wpdb->prefix . 'aura_campaign_recipients', array('campaign_id' => $id));
                $wpdb->delete($table, array('id' => $id));
                $msg = 'deleted';
                break;
            default:
                return;
        }

        wp_redirect(add_query_arg(array('page' => 'aura-campaigns', 'msg' => $msg), admin_url('admin.php')));
        exit;
    }

    // --- Campaign: create ---
    if ($page === 'aura-new-campaign' && !empty($_POST['aura_create_campaign'])) {
        check_admin_referer('aura_create_campaign');

        $subject = sanitize_text_field($_POST['subject'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');
        $rate    = max(1, intval($_POST['emails_per_hour'] ?? 50));
        $ids     = !empty($_POST['submission_ids']) ? array_map('intval', $_POST['submission_ids']) : array();
        $ids_from_get = !empty($_GET['ids']) ? array_map('intval', explode(',', $_GET['ids'])) : array();
        if (empty($ids)) $ids = $ids_from_get;

        if (!empty($subject) && !empty($message) && !empty($ids)) {
            $wpdb->insert($wpdb->prefix . 'aura_campaigns', array(
                'subject'         => $subject,
                'message'         => $message,
                'status'          => 'active',
                'emails_per_hour' => $rate,
                'total_count'     => count($ids),
            ));
            $campaign_id = $wpdb->insert_id;

            foreach ($ids as $sid) {
                $email = get_post_meta($sid, '_aura_email', true);
                if (is_email($email)) {
                    $wpdb->insert($wpdb->prefix . 'aura_campaign_recipients', array(
                        'campaign_id'   => $campaign_id,
                        'submission_id' => $sid,
                        'email'         => $email,
                    ));
                }
            }

            wp_redirect(add_query_arg(array('page' => 'aura-campaigns', 'msg' => 'created'), admin_url('admin.php')));
            exit;
        }
    }
}
add_action('admin_init', 'aura_process_admin_actions');

// ==============================
// PAGE: SUBMISSIONS (simple HTML table)
// ==============================
function aura_submissions_page() {
    global $wpdb;

    // Single view
    if (!empty($_GET['action']) && $_GET['action'] === 'view' && !empty($_GET['id'])) {
        $id   = intval($_GET['id']);
        $post = get_post($id);
        if (!$post || $post->post_type !== 'aura_submission') {
            echo '<div class="wrap aura-wrap"><h1>Submission not found.</h1></div>';
            return;
        }
        $name  = get_post_meta($id, '_aura_name', true);
        $email = get_post_meta($id, '_aura_email', true);
        $plan  = get_post_meta($id, '_aura_plan', true);
        $vis   = get_post_meta($id, '_aura_vision', true);
        ?>
        <div class="wrap aura-wrap">
            <h1>Submission Detail <a href="?page=aura-loop" class="button button-secondary">&larr; Back</a></h1>
            <div class="aura-detail">
                <p><strong>Name:</strong> <?php echo esc_html($name); ?></p>
                <p><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                <p><strong>Plan:</strong> <?php echo esc_html($plan ?: 'Not specified'); ?></p>
                <p><strong>Vision:</strong> <?php echo esc_html($vis ?: 'Not provided'); ?></p>
                <p><strong>Submitted:</strong> <?php echo get_the_date('F j, Y g:i a', $id); ?></p>
                <p><strong>IP:</strong> <?php echo esc_html(get_post_meta($id, '_aura_ip', true) ?: 'N/A'); ?></p>
            </div>
        </div>
        <?php
        return;
    }

    // Success/error messages
    $msg = sanitize_key($_GET['msg'] ?? '');
    $notices = array('deleted' => array('Deleted successfully.', 'success'), 'none-selected' => array('No submissions selected.', 'error'));

    // Pagination
    $per_page = 20;
    $paged    = max(1, intval($_GET['paged'] ?? 1));
    $offset   = ($paged - 1) * $per_page;

    // Fetch submissions directly via SQL
    $ids   = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'aura_submission' AND post_status = 'publish' ORDER BY post_date DESC LIMIT $per_page OFFSET $offset");
    $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'aura_submission' AND post_status = 'publish'");
    $pages = max(1, ceil($total / $per_page));

    // Get post objects for selected ids
    $posts = array();
    foreach ($ids as $id) {
        $p = get_post($id);
        if ($p) $posts[] = $p;
    }
    ?>
    <div class="wrap aura-wrap">
        <h1>Submissions
            <a href="?page=aura-loop&export=csv" class="button">Download CSV</a>
            <span style="font-size:14px;font-weight:400;color:#9ca2a7;margin-left:8px;">(<?php echo $total; ?>)</span>
        </h1>
        <?php if (isset($notices[$msg])): ?>
            <div class="aura-msg <?php echo $notices[$msg][1]; ?>"><?php echo $notices[$msg][0]; ?></div>
        <?php endif; ?>

        <?php if (empty($posts)): ?>
            <p>No submissions yet. Submit the contact form on the front page to see entries here.</p>
        <?php else: ?>
        <form method="get">
            <input type="hidden" name="page" value="aura-loop">
            <table class="wp-list-table widefat fixed striped" style="margin-top:12px;">
                <thead>
                    <tr>
                        <td style="width:30px;"><input type="checkbox" id="cb-all"></td>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Vision</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $p):
                    $fn  = get_post_meta($p->ID, '_aura_name', true) ?: '(no name)';
                    $em  = get_post_meta($p->ID, '_aura_email', true);
                    $pl  = get_post_meta($p->ID, '_aura_plan', true);
                    $vi  = get_post_meta($p->ID, '_aura_vision', true);
                    $dt  = get_the_date(get_option('date_format') . ' g:i a', $p->ID);
                    $vu  = add_query_arg(array('page' => 'aura-loop', 'action' => 'view', 'id' => $p->ID), admin_url('admin.php'));
                    $du  = wp_nonce_url(add_query_arg(array('page' => 'aura-loop', 'action' => 'delete', 'id' => $p->ID), admin_url('admin.php')), 'aura_delete_' . $p->ID);
                ?>
                    <tr>
                        <td><input type="checkbox" name="submission_ids[]" value="<?php echo $p->ID; ?>"></td>
                        <td>
                            <strong><a href="<?php echo esc_url($vu); ?>"><?php echo esc_html($fn); ?></a></strong>
                            <div class="row-actions">
                                <span><a href="<?php echo esc_url($vu); ?>">View</a> | </span>
                                <span><a href="<?php echo esc_url($du); ?>" onclick="return confirm('Delete this submission?')">Delete</a></span>
                            </div>
                        </td>
                        <td><a href="mailto:<?php echo esc_attr($em); ?>"><?php echo esc_html($em); ?></a></td>
                        <td><?php echo $pl ? esc_html(ucfirst($pl)) : '—'; ?></td>
                        <td><?php echo $vi ? esc_html(wp_trim_words($vi, 8)) : '—'; ?></td>
                        <td><?php echo $dt; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div style="display:flex;align-items:center;gap:8px;margin-top:12px;">
                <select name="action">
                    <option value="-1">Bulk Actions</option>
                    <option value="campaign">Create Campaign from Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <input type="submit" class="button" value="Apply">
                <?php wp_nonce_field('bulk-submissions'); ?>
            </div>
        </form>

        <?php if ($pages > 1): ?>
        <div class="tablenav bottom" style="margin-top:16px;">
            <div class="tablenav-pages">
                <span class="displaying-num"><?php echo $total; ?> items</span>
                <?php if ($paged > 1): ?>
                    <a class="button" href="?page=aura-loop&paged=<?php echo $paged - 1; ?>">&lsaquo; Prev</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <?php if ($i === $paged): ?>
                        <span class="button" disabled style="opacity:0.6;"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a class="button" href="?page=aura-loop&paged=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($paged < $pages): ?>
                    <a class="button" href="?page=aura-loop&paged=<?php echo $paged + 1; ?>">Next &rsaquo;</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php
}

// ==============================
// CSV EXPORT
// ==============================
function aura_export_csv() {
    $query = new WP_Query(array(
        'post_type'      => 'aura_submission',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="aura-loop-submissions-' . date('Y-m-d') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo "\xEF\xBB\xBF"; // UTF-8 BOM to help Excel

    $out = fopen('php://output', 'w');
    fputcsv($out, array('Entry', 'Name', 'Email', 'Plan', 'Vision', 'Date', 'IP'));

    foreach ($query->posts as $post) {
        fputcsv($out, array(
            $post->ID,
            get_post_meta($post->ID, '_aura_name', true),
            get_post_meta($post->ID, '_aura_email', true),
            get_post_meta($post->ID, '_aura_plan', true),
            get_post_meta($post->ID, '_aura_vision', true),
            get_the_date('Y-m-d H:i:s', $post->ID),
            get_post_meta($post->ID, '_aura_ip', true),
        ));
    }
    fclose($out);
    exit;
}

// ==============================
// PAGE: CAMPAIGNS LIST
// ==============================
function aura_campaigns_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'aura_campaigns';
    $campaigns = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
    $msg = sanitize_key($_GET['msg'] ?? '');
    $notices = array(
        'created'  => array('Campaign created and sending has started.', 'success'),
        'started'  => array('Campaign started.', 'success'),
        'paused'   => array('Campaign paused.', 'success'),
        'resumed'  => array('Campaign resumed.', 'success'),
        'deleted'  => array('Campaign deleted.', 'success'),
    );
    ?>
    <div class="wrap aura-wrap">
        <h1>Campaigns <a href="?page=aura-new-campaign" class="button button-primary">New Campaign</a></h1>
        <?php if (isset($notices[$msg])): ?>
            <div class="aura-msg <?php echo $notices[$msg][1]; ?>"><?php echo $notices[$msg][0]; ?></div>
        <?php endif; ?>
        <table class="wp-list-table widefat fixed striped" style="margin-top:16px;">
            <thead>
                <tr>
                    <th style="width:40px;">ID</th>
                    <th>Subject</th>
                    <th style="width:100px;">Status</th>
                    <th style="width:120px;">Progress</th>
                    <th style="width:100px;">Rate</th>
                    <th style="width:150px;">Created</th>
                    <th style="width:220px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($campaigns)): ?>
                    <tr><td colspan="7">No campaigns yet.</td></tr>
                <?php else: foreach ($campaigns as $c): ?>
                    <tr>
                        <td><?php echo $c->id; ?></td>
                        <td><?php echo esc_html($c->subject); ?></td>
                        <td><span class="camp-status <?php echo $c->status; ?>"><?php echo $c->status; ?></span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span><?php echo $c->sent_count; ?> / <?php echo $c->total_count; ?></span>
                                <?php if ($c->total_count > 0): ?>
                                    <span style="font-size:11px;color:#9ca2a7;">(<?php echo round(($c->sent_count / $c->total_count) * 100); ?>%)</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><?php echo $c->emails_per_hour; ?>/hr</td>
                        <td><?php echo date('M j, Y g:i a', strtotime($c->created_at)); ?></td>
                        <td>
                            <?php if ($c->status === 'draft' || $c->status === 'paused'): ?>
                                <a class="button button-small" href="<?php echo wp_nonce_url(admin_url('admin.php?page=aura-campaigns&action=start&id=' . $c->id), 'campaign_start_' . $c->id); ?>">Start</a>
                            <?php endif; ?>
                            <?php if ($c->status === 'active'): ?>
                                <a class="button button-small" href="<?php echo wp_nonce_url(admin_url('admin.php?page=aura-campaigns&action=pause&id=' . $c->id), 'campaign_pause_' . $c->id); ?>">Pause</a>
                            <?php endif; ?>
                            <?php if ($c->status === 'paused'): ?>
                                <a class="button button-small" href="<?php echo wp_nonce_url(admin_url('admin.php?page=aura-campaigns&action=resume&id=' . $c->id), 'campaign_resume_' . $c->id); ?>">Resume</a>
                            <?php endif; ?>
                            <a class="button button-small" href="<?php echo wp_nonce_url(admin_url('admin.php?page=aura-campaigns&action=delete&id=' . $c->id), 'campaign_delete_' . $c->id); ?>" onclick="return confirm('Delete this campaign?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
        <p class="description" style="margin-top:16px;">Campaigns send batches automatically every hour via WP Cron. Sent count updates after each batch completes.</p>
    </div>
    <?php
}

// ==============================
// PAGE: NEW CAMPAIGN
// ==============================
function aura_new_campaign_page() {
    global $wpdb;

    $selected_ids = array();
    if (!empty($_GET['ids'])) {
        $selected_ids = array_map('intval', explode(',', $_GET['ids']));
    }

    $error = !empty($_GET['error']) ? sanitize_text_field($_GET['error']) : '';

    // Load recipients
    $recipients = array();
    if (!empty($selected_ids)) {
        $args = array(
            'post_type'      => 'aura_submission',
            'post__in'       => $selected_ids,
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        foreach (get_posts($args) as $p) {
            $email = get_post_meta($p->ID, '_aura_email', true);
            if ($email) {
                $recipients[] = array('id' => $p->ID, 'email' => $email, 'name' => get_post_meta($p->ID, '_aura_name', true));
            }
        }
    }
    ?>
    <div class="wrap aura-wrap">
        <h1>New Campaign <a href="?page=aura-campaigns" class="button button-secondary">&larr; Back to Campaigns</a></h1>

        <?php if ($error): ?>
            <div class="aura-msg error"><?php echo esc_html($error); ?></div>
        <?php endif; ?>

        <form method="post" class="aura-cf">
            <?php wp_nonce_field('aura_create_campaign'); ?>

            <label>Recipients (<?php echo count($recipients); ?> selected)</label>
            <?php if (empty($recipients)): ?>
                <p style="color:#9ca2a7;">No recipients selected. Go to <a href="?page=aura-loop">Submissions</a>, select entries, and use "Create Campaign from Selected".</p>
            <?php else: ?>
                <ul class="aura-recipients">
                    <?php foreach ($recipients as $r): ?>
                        <li><strong><?php echo esc_html($r['name']); ?></strong> &lt;<?php echo esc_html($r['email']); ?>&gt;
                            <input type="hidden" name="submission_ids[]" value="<?php echo $r['id']; ?>">
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <label for="subject">Email Subject</label>
            <input type="text" name="subject" id="subject" value="<?php echo esc_attr($_POST['subject'] ?? ''); ?>" required>

            <label for="message">Email Message (plain text)</label>
            <textarea name="message" id="message" required><?php echo esc_textarea($_POST['message'] ?? ''); ?></textarea>

            <label for="emails_per_hour">Emails per Hour</label>
            <input type="number" name="emails_per_hour" id="emails_per_hour" value="<?php echo intval($_POST['emails_per_hour'] ?? 50); ?>" min="1" max="500" style="width:120px;">
            <p class="description" style="color:#9ca2a7;font-size:12px;">The campaign will send this many emails each hour until all recipients are covered.</p>

            <div class="submit-row">
                <input type="submit" name="aura_create_campaign" class="button button-primary" value="Start Campaign">
            </div>
        </form>
    </div>
    <?php
}

// ==============================
// CRON: SEND CAMPAIGN BATCH
// ==============================
function aura_send_campaign_batch() {
    global $wpdb;
    $prefix = $wpdb->prefix;

    $campaigns = $wpdb->get_results("SELECT * FROM {$prefix}aura_campaigns WHERE status = 'active'");

    foreach ($campaigns as $c) {
        $remaining = $c->total_count - $c->sent_count;
        if ($remaining <= 0) {
            $wpdb->update("{$prefix}aura_campaigns", array('status' => 'completed'), array('id' => $c->id));
            continue;
        }

        $batch = min($c->emails_per_hour, $remaining);

        $recipients = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$prefix}aura_campaign_recipients WHERE campaign_id = %d AND sent = 0 LIMIT %d",
            $c->id, $batch
        ));

        $sent_this_run = 0;
        foreach ($recipients as $r) {
            $sent = wp_mail($r->email, $c->subject, $c->message, array(
                'From: Aura Loop <contact@auraloop.colorgraphicz.in>',
                'Content-Type: text/plain; charset=UTF-8',
            ));
            if ($sent) {
                $wpdb->update("{$prefix}aura_campaign_recipients",
                    array('sent' => 1, 'sent_at' => current_time('mysql')),
                    array('id' => $r->id)
                );
                $sent_this_run++;
            }
        }

        if ($sent_this_run > 0) {
            $wpdb->query($wpdb->prepare(
                "UPDATE {$prefix}aura_campaigns SET sent_count = sent_count + %d WHERE id = %d",
                $sent_this_run, $c->id
            ));
        }

        $updated = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$prefix}aura_campaigns WHERE id = %d", $c->id
        ));
        if ($updated && $updated->sent_count >= $updated->total_count) {
            $wpdb->update("{$prefix}aura_campaigns",
                array('status' => 'completed'),
                array('id' => $c->id)
            );
        }
    }
}
add_action('aura_send_campaign_batch', 'aura_send_campaign_batch');
