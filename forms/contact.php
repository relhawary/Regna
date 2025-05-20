<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Basic config
$to = "roeyaelhawary@gmail.com";  // 👈 Change this to your real email address
$subject = "New Contact Message from Regna Website";

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  echo "Method Not Allowed";
  exit;
}

// Get and sanitize form input
$name    = htmlspecialchars(trim($_POST["name"] ?? ""));
$email   = filter_var(trim($_POST["email"] ?? ""), FILTER_VALIDATE_EMAIL);
$subject = htmlspecialchars(trim($_POST["subject"] ?? ""));
$message = htmlspecialchars(trim($_POST["message"] ?? ""));

// Validate input
if (!$name || !$email || !$subject || !$message) {
  http_response_code(400);
  echo "All fields are required and must be valid.";
  exit;
}

// Email content
$email_content = "You received a new message from your website:\n\n";
$email_content .= "Name: $name\n";
$email_content .= "Email: $email\n";
$email_content .= "Subject: $subject\n";
$email_content .= "Message:\n$message\n";

// Headers
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";

// Send email
if (mail($to, $subject, $email_content, $headers)) {
  http_response_code(200);
  echo "Message sent successfully!";
} else {
  die('Message send failed!');
}

