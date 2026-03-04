<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer files
require 'inc/PHPMailer-master/src/Exception.php';
require 'inc/PHPMailer-master/src/PHPMailer.php';
require 'inc/PHPMailer-master/src/SMTP.php';

function sendMail($name, $email, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'uday.devyarn@gmail.com';       // ✅ Replace
        $mail->Password   = 'dpvcfddcbparcbbm';          // ✅ Replace with Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('uday.devyarn@gmail.com', 'Portfolio Website');
        $mail->addAddress('udaymishracr7@gmail.com', 'UD');
        // $mail->addReplyTo($email, $name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body    = "
            <h3>New message from your website:</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Subject:</b> $subject</p>
            <p><b>Message:</b><br>$message</p>
        ";

        return $mail->send();
    } catch (Exception $e) {
        error_log("PHPMailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
