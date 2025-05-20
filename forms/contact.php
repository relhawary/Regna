<?php
// Uncomment for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Replace with your real email address
$to = "you@example.com";

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  echo "Method Not Allowed";
  exit;
}

// Get and validate fields
$name    = htmlspecialchars(trim($_POST["name"] ?? ""));
$email   = filter_var(trim($_POST["email"] ?? ""), FILTER_VALIDATE_EMAIL);
$subject = htmlspecialchars(trim($_POST["subject"] ?? ""));
$message = htmlspecialchars(trim($_POST["message"] ?? ""));

if (!$name || !$email || !$subject || !$message) {
  http_response_code(400);
  echo "Please fill in all fields correctly.";
  exit;
}

// Email content
$email_subject = "New message from your website: $subject";
$email_body  = "Name: $name\n";
$email_body .= "Email: $email\n";
$email_body .= "Message:\n$message\n";

// Email headers
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";

// Send the email
if (mail($to, $email_subject, $email_body, $headers)) {
  echo "OK"; // This is what the JavaScript expects on success
} else {
  http_response_code(500);
  echo "Failed to send email. Check server mail configuration.";
}
