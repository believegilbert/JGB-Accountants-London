<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/jgbaccountants/public_html/PHPMailer/PHPMailer/src/Exception.php';
require '/home/jgbaccountants/public_html/PHPMailer/PHPMailer/src/PHPMailer.php';
require '/home/jgbaccountants/public_html/PHPMailer/PHPMailer/src/SMTP.php';
require '/home/jgbaccountants/connect/mailconnect.php';

$gobalVarMail = new PHPMailer(true);

try {
 $mail = $GLOBALS['gobalVarMail'];
 //$mail->SMTPDebug = 2;
 $mail->isSMTP();
 $mail->Host = $MailHost;
 $mail->SMTPAuth = true;
 $mail->Username = $MailUsername; 
 $mail->Password = $MailPassword;
 $mail->SMTPSecure = $MailSMTPSecure;
 $mail->Port = $MailPort;

 // Send email
function sendEmail($to, $bcc, $toName, $subject, $body, $name, $fromEmail, $replyTo) {
    $mail = $GLOBALS['gobalVarMail'];

//Recipients
 $mail->setFrom($fromEmail, $name);
 $mail->addAddress($to, $toName); // Add a recipient
 $mail->addReplyTo($replyTo, $name);
 //$mail->addCC('cc@example.com');
 //$mail->addBCC($bcc);

// Attachments
 //$mail->addAttachment('/home/cpanelusername/attachment.txt'); // Add attachments
 //$mail->addAttachment('/home/cpanelusername/image.jpg', 'new.jpg'); // Optional name

// Content
 $mail->isHTML(true); // Set email format to HTML
 $mail->Subject = $subject;
 $mail->Body = $body;
 $mail->AltBody = $body;

$mail->send();
 //echo 'SENT';
 return true;
}
} catch (Exception $e) {
 //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
 return false;
}

