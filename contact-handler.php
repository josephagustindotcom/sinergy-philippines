<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$firstName = trim($_POST['firstName'] ?? '');
$lastName  = trim($_POST['lastName'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$company   = trim($_POST['company'] ?? '');
$website   = trim($_POST['website'] ?? '');
$service   = trim($_POST['service'] ?? '');
$teamSize  = trim($_POST['teamSize'] ?? '');
$timeline  = trim($_POST['timeline'] ?? '');
$budget    = trim($_POST['budget'] ?? '');
$message   = trim($_POST['message'] ?? '');

if (!$firstName || !$lastName || !$email || !$company || !$service || !$message) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please complete all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

// Credentials loaded from config.php

function buildMailer(): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;
    $mail->setFrom(ADMIN_EMAIL, 'Sinergy-Philippines');
    return $mail;
}

$phoneLine    = $phone    ?: 'Not provided';
$websiteLine  = $website  ?: 'Not provided';
$teamSizeLine = $teamSize ?: 'Not specified';
$timelineLine = $timeline ?: 'Not specified';
$budgetLine   = $budget   ?: 'Not specified';
$msgEscaped   = nl2br(htmlspecialchars($message));
$nameEscaped  = htmlspecialchars($firstName . ' ' . $lastName);
$companyEsc   = htmlspecialchars($company);
$serviceEsc   = htmlspecialchars($service);

try {
    // 1. Notify admin
    $adminMail = buildMailer();
    $adminMail->addAddress(ADMIN_EMAIL, 'Sinergy Admin');
    $adminMail->Subject = "Outsourcing Inquiry from {$companyEsc}";
    $adminMail->isHTML(true);
    $adminMail->Body = "
        <h2 style='font-family:sans-serif;'>New Outsourcing Inquiry</h2>
        <table style='font-family:sans-serif;border-collapse:collapse;'>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Name</strong></td><td>{$nameEscaped}</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Email</strong></td><td>" . htmlspecialchars($email) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Phone / WhatsApp</strong></td><td>" . htmlspecialchars($phoneLine) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Company</strong></td><td>{$companyEsc}</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Website</strong></td><td>" . htmlspecialchars($websiteLine) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Service Needed</strong></td><td>{$serviceEsc}</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Team Size</strong></td><td>" . htmlspecialchars($teamSizeLine) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Timeline</strong></td><td>" . htmlspecialchars($timelineLine) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Budget</strong></td><td>" . htmlspecialchars($budgetLine) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;vertical-align:top;'><strong>Message</strong></td><td>{$msgEscaped}</td></tr>
        </table>
    ";
    $adminMail->AltBody = "New inquiry from {$firstName} {$lastName} ({$email})\nCompany: {$company}\nService: {$service}\n\nMessage:\n{$message}";
    $adminMail->send();

    // 2. Auto-reply to requester
    $replyMail = buildMailer();
    $replyMail->addAddress($email, $firstName . ' ' . $lastName);
    $replyMail->Subject = 'We received your inquiry — Sinergy';
    $replyMail->isHTML(true);
    $replyMail->Body = "
        <p style='font-family:sans-serif;'>Hi " . htmlspecialchars($firstName) . ",</p>
        <p style='font-family:sans-serif;'>Thank you for reaching out to Sinergy. We have received your inquiry regarding <strong>{$serviceEsc}</strong> and will review it shortly.</p>
        <p style='font-family:sans-serif;'>Our team typically responds within 1&ndash;2 business days. If you have additional details to share, feel free to reply to this email.</p>
        <p style='font-family:sans-serif;'><strong>Summary of your inquiry:</strong></p>
        <table style='font-family:sans-serif;border-collapse:collapse;'>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Service Needed</strong></td><td>{$serviceEsc}</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Company</strong></td><td>{$companyEsc}</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Team Size</strong></td><td>" . htmlspecialchars($teamSizeLine) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Timeline</strong></td><td>" . htmlspecialchars($timelineLine) . "</td></tr>
        </table>
        <br>
        <p style='font-family:sans-serif;'>Sinergy Team<br><a href='mailto:" . ADMIN_EMAIL . "'>" . ADMIN_EMAIL . "</a></p>
    ";
    $replyMail->AltBody = "Hi {$firstName},\n\nThank you for reaching out to Sinergy. We received your inquiry regarding {$service} and will get back to you within 1-2 business days.\n\nSinergy Team\n" . ADMIN_EMAIL;
    $replyMail->send();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send. Email us directly at ' . ADMIN_EMAIL]);
}
