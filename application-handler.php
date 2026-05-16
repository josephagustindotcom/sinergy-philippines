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
$role      = trim($_POST['role'] ?? '');
$message   = trim($_POST['message'] ?? '');

if (!$firstName || !$lastName || !$email || !$role || !$message) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please complete all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

// Validate resume upload
if (empty($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please attach your resume.']);
    exit;
}

$allowedExt  = ['pdf', 'doc', 'docx'];
$resumeExt   = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
$resumeSize  = $_FILES['resume']['size'];
$maxSize     = 5 * 1024 * 1024; // 5 MB

if (!in_array($resumeExt, $allowedExt)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Resume must be a PDF, DOC, or DOCX file.']);
    exit;
}

if ($resumeSize > $maxSize) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Resume file must be under 5 MB.']);
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
    $mail->setFrom(FROM_EMAIL, 'Sinergy');
    return $mail;
}

$phoneLine   = $phone ?: 'Not provided';
$nameEscaped = htmlspecialchars($firstName . ' ' . $lastName);
$roleEscaped = htmlspecialchars($role);
$msgEscaped  = nl2br(htmlspecialchars($message));

try {
    // 1. Notify careers team — with resume attached
    $careersMail = buildMailer();
    $careersMail->addAddress(CAREERS_EMAIL, 'Sinergy Careers');
    $careersMail->addReplyTo($email, $firstName . ' ' . $lastName);
    $careersMail->Subject = "Job Application — {$roleEscaped} — {$nameEscaped}";
    $careersMail->isHTML(true);
    $careersMail->Body = "
        <h2 style='font-family:sans-serif;'>New Job Application</h2>
        <table style='font-family:sans-serif;border-collapse:collapse;'>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Role Applied For</strong></td><td>{$roleEscaped}</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Name</strong></td><td>{$nameEscaped}</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Email</strong></td><td>" . htmlspecialchars($email) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;'><strong>Phone / WhatsApp</strong></td><td>" . htmlspecialchars($phoneLine) . "</td></tr>
            <tr><td style='padding:6px 16px 6px 0;vertical-align:top;'><strong>Introduction</strong></td><td>{$msgEscaped}</td></tr>
        </table>
        <p style='font-family:sans-serif;color:#666;'>Resume is attached.</p>
    ";
    $careersMail->AltBody = "New application for {$role}\n\nName: {$firstName} {$lastName}\nEmail: {$email}\nPhone: {$phoneLine}\n\nIntroduction:\n{$message}\n\nResume attached.";
    $careersMail->addAttachment($_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
    $careersMail->send();

    // 2. Auto-reply to applicant
    $replyMail = buildMailer();
    $replyMail->addAddress($email, $firstName . ' ' . $lastName);
    $replyMail->Subject = 'We received your application — Sinergy';
    $replyMail->isHTML(true);
    $replyMail->Body = "
        <p style='font-family:sans-serif;'>Hi " . htmlspecialchars($firstName) . ",</p>
        <p style='font-family:sans-serif;'>Thank you for applying to Sinergy. We have received your application for <strong>{$roleEscaped}</strong> and will review it shortly.</p>
        <p style='font-family:sans-serif;'>Our team will be in touch if your profile matches what we are looking for. We appreciate your interest in joining Sinergy.</p>
        <br>
        <p style='font-family:sans-serif;'>Sinergy Careers Team<br><a href='mailto:" . CAREERS_EMAIL . "'>" . CAREERS_EMAIL . "</a></p>
    ";
    $replyMail->AltBody = "Hi {$firstName},\n\nThank you for applying to Sinergy. We received your application for {$role} and will review it shortly.\n\nSinergy Careers Team\n" . CAREERS_EMAIL;
    $replyMail->send();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send. Email us directly at ' . CAREERS_EMAIL]);
}
