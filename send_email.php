<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer if installed via Composer

function sendEmail($to, $subject, $body, $bccEmails = [])
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'deguzmanmarkfrancisp@gmail.com'; // Change to your email
        $mail->Password = 'hcjn nxlw ohje vtri'; // Use an App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Content
        $mail->setFrom('deguzmanmarkfrancisp@gmail.com', 'CDP-Francis');
        $mail->addAddress($to); // Main recipient

        // Add BCC recipients
        foreach ($bccEmails as $bcc) {
            $mail->addBCC($bcc);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send Email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
