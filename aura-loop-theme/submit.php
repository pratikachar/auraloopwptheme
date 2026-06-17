<?php
// --- CONFIGURATION ---
$recipient_email = 'project.colorgraphicz@gmail.com';  // <-- EDIT THIS LINE: change to your email address
$redirect_page = 'index.html';
// --------------------

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $redirect_page);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$plan    = trim($_POST['plan'] ?? '');
$vision  = trim($_POST['vision'] ?? '');
$captcha = trim($_POST['captcha'] ?? '');

// Validate required fields
if (empty($name) || empty($email)) {
    header('Location: ' . $redirect_page . '?error=fields');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ' . $redirect_page . '?error=email');
    exit;
}

// Simple math captcha check: "What is 6 + 9?"
if ((int)$captcha !== 15) {
    header('Location: ' . $redirect_page . '?error=captcha');
    exit;
}

// Build email
$subject = "Aura Loop — New Membership Inquiry from $name";
$body = "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Plan: " . ($plan ?: 'Not specified') . "\n";
$body .= "Vision: " . ($vision ?: 'Not provided') . "\n";

$headers = "From: Aura Loop <contact@auraloop.colorgraphicz.in>\r\n";
$headers .= "Reply-To: $email\r\n";

$sent = mail($recipient_email, $subject, $body, $headers);

if ($sent) {
    header('Location: ' . $redirect_page . '?success=1');
} else {
    header('Location: ' . $redirect_page . '?error=server');
}
exit;
