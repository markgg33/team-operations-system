<?php
include "send_email.php"; // Ensure this file contains the `sendEmail` function

// Test recipient email (use your own email)
$to = "siopaomark@gmail.com";
$subject = "Email Test";
$body = "<h3>PHPMailer Test</h3><p>If you receive this, PHPMailer is working!</p>";

if (sendEmail($to, $subject, $body)) {
    echo "✅ Test email sent successfully!";
} else {
    echo "❌ Test email failed. Check your SMTP settings.";
}
