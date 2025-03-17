<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once 'vendor/autoload.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'm38133871@gmail.com';
$mail->Password = 'tcyz zjnd qmsp alqm';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->addAddress("m38133871@gmail.com");

function sendEmail($name, $email, $message) {
    global $mail;
    $mail->setFrom("$email");
    $mail->Subject = "Contact Form Submission from $name";
    $mail->Body = "Name: $name\nEmail: $email\nMessage: $message";
    
    if($mail->send()) {
        echo "<p class='success'>Message sent successfully</p>";
    } else {
        echo "<p class='error'>Message could not be sent</p>";
    }
}
