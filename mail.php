<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './account/include/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    //SMTP Settings (use default cpanel email account)
    $mail->isSMTP();
    $mail->Host = "server153.web-hosting.com"; //
    $mail->SMTPAuth = true;
    $mail->Username = "support@goldenstonefinance.online"; // Default cpanel email account
    $mail->Password = 'goldenSecret.'; // Default cpanel email password
    $mail->Port = 587; // 587 or 465
    $mail->SMTPSecure = "tls"; // tls

    //Email Settings
    $mail->isHTML(true);
    $mail->setFrom('support@goldenstonefinance.online', 'Golden Stone'); // Email address/ Bank bane shown to reciever
    $mail->addAddress("makuochukwu042@gmail.com");
    $mail->AddReplyTo("support@goldenstonefinance.online", "Golden Stone"); // Email address/ Bank bane shown to reciever
    $mail->Subject = "subject";
    $mail->Body = "body";
    $mail->Send();

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
