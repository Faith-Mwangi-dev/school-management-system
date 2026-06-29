<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function getMailer()
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // Change these
    $mail->Username = 'faymwangi27@gmail.com';
    $mail->Password = 'yourapppassword';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('faymwangi27@gmail.com', 'School Management System');

    $mail->isHTML(true);

    return $mail;
}