
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('src/Exception.php');
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mehrsys123@gmail.com';
    $mail->Password = 'icubiojxixwfwdun';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';
    $mail->setFrom('mehrsys123@gmail.com');
    $mail->addAddress($email_from_db);

    $mail->isHTML(true);
    $mail->Subject = 'MEHR System -MyAccount OTP';
    $mail->Body =
        "<h3 style='font-weight:bold'>OTP</h3>
        <br/><p>$random_pin</p>
        <p>Please click change your password link to reset password!</p>";
    $mail->send();
} catch (Exception $e) {
}
