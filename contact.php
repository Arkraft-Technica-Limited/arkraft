<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit;
}

$name    = strip_tags(trim($_POST["full_name"]));
$email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$message = strip_tags(trim($_POST["message"]));

if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit;
}

/* ========= 1. SEND TO ENQUIRY EMAIL ========= */
$to = "enquiry@arkraft.tech";
$subject = "New Website Enquiry - Arkraft Technica";

$body = "You have received a new enquiry.\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n\n";
$body .= "Message:\n$message\n";

$headers = "From: Website Enquiry <no-reply@arkraft.tech>\r\n";
$headers .= "Reply-To: $email\r\n";

mail($to, $subject, $body, $headers);

/* ========= 2. AUTO-REPLY TO SENDER ========= */
$replySubject = "We’ve received your message – Arkraft Technica";
$replyBody = "Hello $name,\n\n";
$replyBody .= "Thank you for contacting Arkraft Technica.\n\n";
$replyBody .= "We have received your message and our team will respond shortly.\n\n";
$replyBody .= "This is an automated message. Please do not reply.\n\n";
$replyBody .= "Regards,\nArkraft Technica";

$replyHeaders = "From: Arkraft Technica <no-reply@arkraft.tech>\r\n";

mail($email, $replySubject, $replyBody, $replyHeaders);

/* ========= SUCCESS ========= */
http_response_code(200);
echo "OK";
