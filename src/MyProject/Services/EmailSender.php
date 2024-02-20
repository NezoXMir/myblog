<?php 

namespace MyProject\Services;

use MyProject\Models\Users\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use MyProject\Models\Users\UserActivationService;

class EmailSender
{
    
    static function send(User $user, string $subject, string $body, $code = [
    ])
{
    require __DIR__ . '/../../../templates/mail/' . $body;

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'miroslav73129';
        $mail->Password = 'vfdodhexfevasxtd';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('miroslav73129@gmil.com', 'Портал PHP');
        $mail->addAddress($user->getEmail(), $user);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $link;
        
        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
}
require_once __DIR__. '/../vendor/autoload.php';
?>