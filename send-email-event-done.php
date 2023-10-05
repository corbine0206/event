<?php
$to = "corbine.santos0206@gmail.com"; // Recipient's email address
$subject = "Test Email"; // Email subject
$message = "This is a test email sent from PHP."; // Email message
$headers = "From: yourname@example.com\r\n"; // Replace with your sender email address

// Additional headers to set SMTP server and port
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "X-Priority: 1\r\n"; // Set email priority
$headers .= "X-MSMail-Priority: High\r\n";

// SMTP server configuration
$smtpServer = "laundryandwash.com"; // Replace with your SMTP server hostname or IP address
$smtpPort = 587; // Replace with the appropriate port for your SMTP server

// Send the email
if (mail($to, $subject, $message, $headers, "-f yourname@example.com")) {
    echo "Email sent successfully.";
} else {
    echo "Email sending failed.";
}
?>
