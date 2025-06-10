<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class newemail
{
    public $email;
    public $code;

    public function __construct($email, $code)
    {
        $this->email = $email;
        $this->code = $code;
        $this->init();
    }

    public function init()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            require "email/PHPMailer.php";
            require "email/SMTP.php";
            require "email/Exception.php";

            $mail = new PHPMailer(true);

            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'codylanka00@gmail.com'; // Your email
                $mail->Password = 'jnil boop pwrb sejy';   // Your app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Email Content
                $mail->setFrom('your_email@gmail.com', 'Vicstore');
                $mail->addAddress($this->email);
                $mail->isHTML(true);
                $mail->Subject = 'Your registration details';

                $mail->Body = $this->generateEmailBody($this->code, $this->email);

                if ($mail->send()) {
                    echo 1;
                } else {
                    echo "Failed to send email. Please try again later.";
                }
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Invalid request.";
        }
    }

    private function generateEmailBody($code, $email): string
    {
        $emailEscaped = htmlspecialchars($email);
        $codeEscaped = htmlspecialchars($code);

        return '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Vicstore Login</title>
  <style>
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(10px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    body {
      margin: 0; padding: 0; font-family: Arial, sans-serif;
      background-color: #f9fafb; color: #333;
    }
    .email-wrapper {
      max-width: 600px; margin: 0 auto; background: white;
      border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.05);
      overflow: hidden; animation: fadeIn 1.5s ease-in-out;
    }
    .header {
      background: #1e40af; padding: 20px; color: white;
      text-align: center;
    }
    .header h1 {
      margin: 0; font-size: 28px; letter-spacing: 1px;
    }
    .content {
      padding: 30px 20px;
    }
    .content h2 {
      font-size: 22px; margin-bottom: 10px;
    }
    .content p {
      font-size: 16px; margin-bottom: 20px; color: #555;
    }
    .credentials {
      background: #f4f6f8;
      padding: 15px 20px;
      border-radius: 8px;
      font-size: 16px;
      margin-bottom: 25px;
      font-family: monospace;
      word-break: break-word;
    }
    .footer {
      background: #f1f5f9; padding: 15px; text-align: center;
      font-size: 14px; color: #888;
    }
    .footer a {
      color: #1e40af; text-decoration: none;
    }
    @media (max-width: 600px) {
      .content { padding: 20px 15px; }
    }
  </style>
</head>
<body>

  <div class="email-wrapper">
    <div class="header">
      <h1>Welcome to Vicstore</h1>
    </div>

    <div class="content">
      <h2>Your Registration Details</h2>
      <p>Use the following credentials to log in to your account:</p>

      <div class="credentials">
        <strong>Email:</strong> ' . $emailEscaped . '<br/>
        <strong>Password:</strong> ' . $codeEscaped . '
      </div>

      <p><a href="https://your-vicstore-login-url.com" style="color:#1e40af; text-decoration:none; font-weight:bold;">Click here to login</a></p>
    </div>

    <div class="footer">
      Designed by <a href="https://www.codyzea.co.nz/" target="_blank">Codyzea</a> • © 2025 Vicstore
    </div>
  </div>

</body>
</html>';
    }
}
