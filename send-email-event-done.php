<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(60); // Increase the time limit to 60 seconds (adjust as needed)

// Set SMTP configuration using ini_set()
ini_set("SMTP", "mail.laundryandwash.com");
ini_set("smtp_port", "465"); // Use the correct SMTP port (465) from your cPanel

// Email parameters
$to = "corbine.santos0206@gmail.com";
$subject = "Test Email";
$message = "This is a test email sent from PHP with SMTP authentication and SSL/TLS encryption.";

// Set the HELO name
$from = "event@laundryandwash.com"; // Use a valid email address from your domain

// SMTP authentication credentials
$username = "event@laundryandwash.com"; // Use your actual email address from cPanel
$password = "GhZ%3SiW]x=Z"; // Use your cPanel password

// Additional headers
$headers = "From: $from\r\n";
$headers .= "Reply-To: $from\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Enable SSL/TLS encryption
ini_set("smtp_ssl", "tls");

// Send the email
if (mail($to, $subject, $message, $headers, "-f $from")) {
    echo "Email sent successfully.";
} else {
    echo "Email sending failed.";
}


?>
