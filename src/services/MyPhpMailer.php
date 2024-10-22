<?php

namespace App\Services;

use App\Utils\Utils;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MyPhpMailer
{
    public $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'samquocdoan.me@gmail.com';
        $this->mail->Password   = 'ffof jyke niif lxxn';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
    }

    public static function sendRegisterConfirm($toEmail, $clientName)
    {
        $mailer = new self();
        $otpCode = Utils::generateVerificationCode();
        $_SESSION['otpcode'] = $otpCode;
        
        try {
            $mailer->mail->setFrom('no-reply@iforum.000.pe', 'iForum');
            $mailer->mail->addAddress($toEmail, $clientName);

            $mailer->mail->isHTML(true);
            $mailer->mail->Subject = 'Registration Confirmation';
            $mailer->mail->Body    = "Your OTP code: {$otpCode}\nThank you for registering, " . $clientName . "!";

            $mailer->mail->send();
            echo 'Email xác nhận đã được gửi.';
        } catch (Exception $e) {
            echo "Gửi email thất bại. Lỗi: {$mailer->mail->ErrorInfo}";
        }
    }
}
