<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

function sendMail($result)
{
    $to = $_SESSION['email'];
    $subject = "Your Quiz Result";
    $txt = "You have scored  $result / 10 ";
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "patelvraju07@gmail.com";
        $mail->Password = "dvffxqbjrndjjten";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->setfrom("patelvraju07@gmail.com");
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $txt;
        $mail->send();
    } catch (Exception $e) {
        echo $e;
    }
}
?>