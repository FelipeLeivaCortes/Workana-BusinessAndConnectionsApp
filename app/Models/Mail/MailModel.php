<?php

namespace Models\Mail;

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Models\MasterModel;

class MailModel extends MasterModel
{
    private PHPMailer $mail;

    public function __construct()
    {
        require_once '../config/global.php';
        
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mail->SMTPKeepAlive = true;
        $this->mail->Host       = SMTP_HOST;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = SMTP_USERNAME;
        $this->mail->Password   = SMTP_PASSWORD;
        $this->mail->SMTPSecure = SMTPSecure;
        $this->mail->Port       = SMTP_PORT;
        $this->mail->setFrom(SMTP_USERNAME, SMTP_COMPANY);
    }

    public function DataEmail(string $template, array|string $recipients, string $subject = null, string|null $attach = null): bool
    {
        if (!is_array($recipients)) {
            $recipients = [$recipients];
        }

        try {
            foreach ($recipients as $recipient) {
                $this->mail->clearAddresses();
                $this->mail->addAddress($recipient);

                $this->mail->isHTML(true);
                $this->mail->Subject = SMTP_COMPANY . " - " . $subject;

                if (!empty($attach)) {
                    $this->mail->addAttachment($attach);
                }

                $this->mail->Body = $template;

                ob_start();
                $this->mail->send();
                ob_end_clean();
            }
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
