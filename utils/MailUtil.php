<?php
namespace App\utils;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailUtil{
    /**
     * Method used to send a mail
     * @param array $to
     * @param string $subject
     * @param string $body
     * @param string $from
     * @param $cc
     * @param $bcc
     * @return bool
     * @throws Exception
     */
    public function sendmail(array $to, string $subject, string $body, string $from = 'noreply.re7project@gmail.com', $cc = [], $bcc = []): bool
    {
        //Mail Sending
// SMTP Connection setup
        $smtpHost = 'smtp.gmail.com';
        $smtpPort = 587;
        $smtpUsername = 'noreply.re7project@gmail.com';
        $smtpPassword = 'tfvmhadennoylyhh';


// PHPMailer object creation and configuration
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->Port = $smtpPort;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;

// Mails parameters
        $mail->setFrom($from);

        foreach ($to as $address) {
            $mail->addAddress($address);
        }

        foreach ($cc as $singleCC) {
            $mail->addCC($singleCC);
        }

        foreach ($bcc as $singleBCC) {
            $mail->addBCC($singleCC);
        }

        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $body;

// send Email
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}