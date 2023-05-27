<?php
require '../../vendor/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/src/SMTP.php';
require '../../vendor/phpmailer/src/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($recipient,$subject,$message)
{    $mail = new PHPMailer();
    //Server settings
    $mail->isSMTP();
    $mail->SMTPAuth = true;                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'teaspillers4532@gmail.com';                     //SMTP username
    $mail->Password   = 'wandsquhvuwfhtex';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->addAddress($recipient, "recipient-name");     //Add a recipient

    //Recipients
    $mail->setFrom('teaspillers4532@gmail.com', 'TeaSpillers');
    
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $content = $message;
    $mail->msgHTML($content);
    $mail->Body    = $message;
    $mail->AltBody = 'Please let this message go through...non-html client';

    if(!$mail->send()){
        echo"Error while sending Email.";
        var_dump($mail);
        return false;
    }
    else
    {
        return true;
    }
}
?>
