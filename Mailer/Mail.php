<?php

namespace Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class Mail {

    /**
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    private PHPMailer $mail;

    public function __construct(string $host, string $username, string $password, int $port = 465, ?string $encryption = null)
    {
        ini_set("log_errors", 1);
        ini_set("error_log", __DIR__ . "../errors/php-error.log");

        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = false; // To view errors
        $this->mail->SMTPAuth   = true;
        $this->mail->SMTPSecure = $encryption ?? PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->isSMTP();
        $this->mail->Host       = $host;
        $this->mail->Username   = $username;
        $this->mail->Password   = $password;
        $this->mail->Port       = $port;
        $this->mail->isHTML(true);
    }

    /**
     * Set from address
     *
     * @param string $address
     * @return void
     */
    public function setFrom(string $address): void
    {
        $this->mail->setFrom($address, 'Mailer');
    }

    /**
     * Add email address
     *
     * @param string $address
     * @param null|string $name
     * @return void
     */
    public function addAddress(string $address, ?string $name = null): void
    {
        $this->mail->addAddress($address, $name);
    }

    /**
     * Add reply email
     *
     * @param string $address
     * @return void
     */
    public function addReplyTo(string $address): void
    {
        $this->mail->addReplyTo($address, 'Information');
    }

    /**
     * Add CC email
     *
     * @param string $address
     * @return void
     */
    public function addCC(string $address): void
    {
        $this->mail->addCC($address);
    }

    /**
     * Add BCC email
     *
     * @param string $address
     * @return void
     */
    public function addBCC(string $address): void
    {
        $this->mail->addBCC($address);
    }

    /**
     * Add email attachment
     *
     * @param string $file
     * @return void
     */
    public function addAttachment(string $file): void
    {
        if (!file_exists($file)) {
            throw new Exception("404!, File not found");
            return;
        }

        $this->mail->addAttachment($address);
    }

    /**
     * Set email subject
     *
     * @param string $text
     * @return void
     */
    public function setSubject(string $text): void
    {
        $this->mail->Subject = $text;
    }

    /**
     * Set email HTML body
     *
     * @param string $html
     * @return void
     */
    public function setHTMLBody(string $html): void
    {
        $this->mail->Body = $html;
    }

    /**
     * Set email plain text
     *
     * @param string $text
     * @return void
     */
    public function setAltBody(string $text): void
    {
        $this->mail->AltBody = $text;
    }

    public function sendMail(): void
    {
        try {
            $this->mail->send();
        } catch (\Exception $e) {
            throw new Exception($this->mail->ErrorInfo);
        }
    }

}