<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'src/Exception.php';
  require 'src/PHPMailer.php';
  require 'src/SMTP.php';

function sendMail($recepient, $subject, $message)
{
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 0;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
  //  $mail->Host       = 'smtp.example.com';                    
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication   
    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Host       = "smtp.gmail.com";                       //Set the SMTP server to send through
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->Username   = 'travellingbuddy2908@gmail.com';        //SMTP username          
    $mail->Password   = 'SD3.1project@';                        //SMTP password
   
   
   
   
  
    $mail->isHTML(true);                                  //Set email format to HTML
    //Recipients
    $mail->setFrom('travellingbuddy2908@gmail.com', 'Travelling Buddy');
    $mail->addAddress($recepient);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
   // $mail->addReplyTo('info@example.com', 'Information');
   // $mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');

    //Attachments
  //  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content   
    $mail->Subject = $subject;
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $content = $message;
   
    $mail->MsgHTML($content); 
    $mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}