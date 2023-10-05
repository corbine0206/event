<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(60); // Increase the time limit to 60 seconds (adjust as needed)

// Email parameters
$to = "corbine.santos0206@gmail.com";
$subject = "Test Email";
$message = "This is a test email sent from PHP with SMTP authentication and SSL/TLS encryption.";

// Set the HELO name
$from = "event@laundryandwash.com"; // Use a valid email address from your domain

// SMTP authentication credentials
$username = "event@laundryandwash.com"; // Use your actual email address from cPanel
$password = "GhZ%3SiW]x=Z"; // Use your cPanel password

// Use PHPMailer
require 'vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'mail.laundryandwash.com';
$mail->Port = 587; // Use the correct SMTP port for TLS
$mail->SMTPSecure = 'tls'; // Use 'tls' for TLS encryption
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
$mail->setFrom($from);
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->msgHTML($message);

try {
    $mail->send();
    echo "Email sent successfully.";
} catch (Exception $e) {
    echo "Email sending failed. Error: " . $mail->ErrorInfo;
}
?>
