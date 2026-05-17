<?php
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input    = json_decode(file_get_contents('php://input'), true);
$messages = $input['messages'] ?? [];

if (empty($messages)) {
    http_response_code(400);
    echo json_encode(['error' => 'No messages provided']);
    exit;
}

$systemPrompt = <<<PROMPT
You are Sinergy's friendly and professional website assistant. Sinergy is a Philippines-based outsourcing company providing offshore support teams for global businesses.

YOUR ROLE:
1. Answer questions about Sinergy's services clearly and concisely
2. Help visitors identify which service fits their needs
3. Schedule discovery calls by collecting visitor information

SINERGY'S SERVICES:
- Customer Support: Email, chat, and phone support — order updates, complaint handling, customer follow-ups
- Technical Support: Troubleshooting, helpdesk tickets, issue triage, escalation, product guidance
- Sales Services: Lead generation, outbound calling, appointment setting, CRM updates, prospect follow-up
- Data Entry & Verification: Data entry, cleanup, validation, CRM updates, form processing, quality checking
- Data Annotation: Image, text, and audio labeling and classification for AI and ML projects

COMPANY INFO:
- Founded: October 2021, Philippines-based
- Supports global businesses across all industries
- General inquiries: hello@sinergy.com
- Careers: careers@sinergyph.com
- Services are tailored per client — not generic staffing

BOOKING DISCOVERY CALLS:
When a visitor wants to schedule a call or speak with someone, collect these four items one at a time:
1. Full name
2. Email address
3. Preferred date and time (ask for their timezone)
4. Which service they are interested in

Once you have all four confirmed, output this EXACT block at the END of your response (after your confirmation message to the user):
<BOOKING>{"name":"FULL NAME","email":"EMAIL","datetime":"DATE TIME TIMEZONE","service":"SERVICE INTEREST"}</BOOKING>

RULES:
- Keep responses to 2-4 sentences unless listing services
- Never invent pricing, team sizes, or guarantees
- If unsure about something, direct to hello@sinergy.com
- Be warm but professional
PROMPT;

$apiMessages = [['role' => 'system', 'content' => $systemPrompt]];

foreach ($messages as $msg) {
    $role = $msg['role'] ?? '';
    if (in_array($role, ['user', 'assistant'])) {
        $apiMessages[] = ['role' => $role, 'content' => (string) $msg['content']];
    }
}

$payload = json_encode([
    'model'       => 'gpt-4o-mini',
    'messages'    => $apiMessages,
    'max_tokens'  => 400,
    'temperature' => 0.7,
]);

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . OPENAI_API_KEY,
    ],
    CURLOPT_TIMEOUT => 30,
]);
$result = curl_exec($ch);
$curlErr = curl_error($ch);
curl_close($ch);

if ($curlErr) {
    http_response_code(500);
    echo json_encode(['error' => 'Request failed. Please try again.', 'debug_curl' => $curlErr]);
    exit;
}

$data = json_decode($result, true);

if (isset($data['error'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Assistant unavailable. Email us at hello@sinergy.com', 'debug_openai' => $data['error']]);
    exit;
}

$content = $data['choices'][0]['message']['content'] ?? '';

// Detect and process booking block
$bookingSubmitted = false;
if (preg_match('/<BOOKING>(.*?)<\/BOOKING>/s', $content, $matches)) {
    $bookingData = json_decode($matches[1], true);
    if ($bookingData) {
        sendBookingEmail($bookingData);
        $bookingSubmitted = true;
    }
    $content = trim(preg_replace('/<BOOKING>.*?<\/BOOKING>/s', '', $content));
}

echo json_encode([
    'message'           => $content,
    'booking_submitted' => $bookingSubmitted,
]);

function sendBookingEmail(array $data): void {
    try {
        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';

        $name     = htmlspecialchars($data['name'] ?? 'Unknown');
        $email    = $data['email'] ?? '';
        $datetime = htmlspecialchars($data['datetime'] ?? 'Not specified');
        $service  = htmlspecialchars($data['service'] ?? 'Not specified');

        function makeMailer(): \PHPMailer\PHPMailer\PHPMailer {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            $mail->setFrom(FROM_EMAIL, 'Sinergy');
            return $mail;
        }

        // Admin notification
        $adminMail = makeMailer();
        $adminMail->addAddress(ADMIN_EMAIL, 'Sinergy Admin');
        if ($email) $adminMail->addReplyTo($email, $name);
        $adminMail->Subject = "Discovery Call Request — {$name}";
        $adminMail->isHTML(true);
        $adminMail->Body = "
            <h2 style='font-family:sans-serif;'>Discovery Call Request</h2>
            <table style='font-family:sans-serif;border-collapse:collapse;'>
                <tr><td style='padding:6px 16px 6px 0;'><strong>Name</strong></td><td>{$name}</td></tr>
                <tr><td style='padding:6px 16px 6px 0;'><strong>Email</strong></td><td>" . htmlspecialchars($email) . "</td></tr>
                <tr><td style='padding:6px 16px 6px 0;'><strong>Preferred Date &amp; Time</strong></td><td>{$datetime}</td></tr>
                <tr><td style='padding:6px 16px 6px 0;'><strong>Service Interest</strong></td><td>{$service}</td></tr>
            </table>
            <p style='font-family:sans-serif;color:#666;font-size:0.9em;'>Submitted via website chatbot.</p>
        ";
        $adminMail->AltBody = "Discovery Call Request\n\nName: {$name}\nEmail: {$email}\nPreferred Time: {$datetime}\nService: {$service}\n\nSubmitted via website chatbot.";
        $adminMail->send();

        // Auto-reply to visitor
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $replyMail = makeMailer();
            $replyMail->addAddress($email, $name);
            $replyMail->Subject = 'Discovery call request received — Sinergy';
            $replyMail->isHTML(true);
            $replyMail->Body = "
                <p style='font-family:sans-serif;'>Hi {$name},</p>
                <p style='font-family:sans-serif;'>We received your request for a discovery call regarding <strong>{$service}</strong>. Our team will reach out to confirm your preferred time of <strong>{$datetime}</strong> shortly.</p>
                <p style='font-family:sans-serif;'>Sinergy Team<br><a href='mailto:" . ADMIN_EMAIL . "'>" . ADMIN_EMAIL . "</a></p>
            ";
            $replyMail->AltBody = "Hi {$name},\n\nWe received your discovery call request for {$service}. We will confirm your preferred time of {$datetime} shortly.\n\nSinergy Team";
            $replyMail->send();
        }
    } catch (\Exception $e) {
        // Silent fail — chat response still returns
    }
}
