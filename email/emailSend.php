<?php

// Include PHPMailer files
require 'Exception.php';
require 'OAuth.php';
require 'PHPMailer.php';
require 'POP3.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class EmailSend {

    private $mail;

    public function __construct() {
        // Initialize PHPMailer instance
        $this->mail = new PHPMailer(true);

        // Configure SMTP settings
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';              // SMTP server
        $this->mail->SMTPAuth   = true;                          // Enable SMTP authentication
        $this->mail->Username   = 'lghmalith@gmail.com';        // SMTP username
        $this->mail->Password   = 'vkdcnlljzsbnmety';               // SMTP password (or app password)
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
        $this->mail->Port       = 587;                           // TCP port to connect to
    }

    // Set the sender and recipient of the email
    public function setRecipient($to, $name = '') {
        try {
            // Add recipient address and name
            $this->mail->addAddress($to, $name);
        } catch (Exception $e) {
            echo "Failed to add recipient. Error: {$this->mail->ErrorInfo}";
        }
    }

    public function setContent($subject, $htmlContent, $textContent) {
        try {
            $this->mail->Subject = $subject;
            $this->mail->Body = $htmlContent;  // HTML content
            $this->mail->AltBody = $textContent;  // Plain text content
        } catch (Exception $e) {
            echo "Failed to set email content. Error: {$this->mail->ErrorInfo}";
        }
    }

    public function send() {
        try {
            if ($this->mail->send()) {
                return true;
            }
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$this->mail->ErrorInfo}";
        }
        return false;
    }
}
?>
