<?php

require 'mail_config.php';

try {
    $mail = getMailer();

    // Send to yourself first
    $mail->addAddress('faymwangi27@gmail.com');

    $mail->Subject = 'PHPMailer Test';
    $mail->Body = '<h2>Congratulations!</h2><p>Your PHPMailer is working correctly.</p>';

    $mail->send();

    echo "Email sent successfully!";
} catch (Exception $e) {
    echo "Error: " . $mail->ErrorInfo;
}