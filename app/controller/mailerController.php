<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

 class mailerController {


    public function sendMail($to, $subject, $body, $name) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'emrsystem0123@gmail.com';                     // SMTP username
            $mail->Password   = 'zjdanofukzoyrhuh';                               // Gmail App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('emrsystem0123@gmail.com', 'Emr System');
            $mail->addAddress($to);     // Add a recipient
            $mail->addCC('emrsystem0123@gmail.com');
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = 'Hi '.$name. ',<br/><br/>'. $body;

            if($mail->send()) {
                return true;
            }
            
        } catch (Exception $e) {
            return false;
        }
    }



 }


?>
