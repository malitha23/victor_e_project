<?php
require "../db.php";

// Email library imports
require "email/PHPMailer.php";
require "email/SMTP.php";
require "email/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MainClass
{
    public function execute()
    {
        $cuponcode = "abc";
        $user_email = "sahantharakasahan500@gmail.com";
        $start_date = '2021-12-12';
        $end_date = '2022-12-12';
        $dispre = 20;

        if (strlen($user_email) > 100) {
            return "User email is invalid";
        }
        if (strlen($cuponcode) > 45) {
            return "Coupon code is invalid";
        }
        if (!is_numeric($dispre) || $dispre < 0 || $dispre > 100) {
            return "Discount percentage is invalid";
        }

        $insertObj = new Insert();
        return $insertObj->sql($cuponcode, $user_email, $start_date, $end_date, $dispre);
    }
}

class Insert
{
    public function sql($cuponcode, $user_email, $start_date, $end_date, $dispre)
    {
        // You should use prepared statements here for security
        $query = "INSERT INTO `coupon` (`code`, `user_email`, `start_date`, `end_date`, `status`, `dis_percentage`) 
                  VALUES ('$cuponcode', '$user_email', '$start_date', '$end_date', 1, '$dispre')";

        Databases::IUD($query);

        $emailSender = new EmailSend();
        return $emailSender->sendMail($user_email, $cuponcode);
    }
}

class EmailSend
{
    public function sendMail($email, $couponCode)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'codylanka00@gmail.com';
            $mail->Password = 'jnil boop pwrb sejy';  // App-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('codylanka00@gmail.com', 'Vectorestore');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = '🎁 Your Exclusive Coupon Code Inside!';
            $mail->Body = $this->generateEmailBody($couponCode);

            if ($mail->send()) {
                return "Email sent successfully.";
            } else {
                return "Failed to send email. Please try again later.";
            }
        } catch (Exception $e) {
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    private function generateEmailBody($code)
    {
        return '
        <html>
        <head>
            <style>
                .email-container {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 30px;
                }
                .email-content {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    text-align: center;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                .coupon-code {
                    font-size: 24px;
                    color: #ffffff;
                    background-color: #4CAF50;
                    padding: 10px 20px;
                    display: inline-block;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .footer {
                    margin-top: 30px;
                    font-size: 12px;
                    color: #999999;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-content">
                    <h2>Hello!</h2>
                    <p>Thank you for being a valued customer. Here’s your exclusive coupon code:</p>
                    <div class="coupon-code">' . htmlspecialchars($code) . '</div>
                    <p>Use this code at checkout to enjoy your discount!</p>
                    <p><strong>Hurry, it’s valid for a limited time only!</strong></p>
                </div>
                <div class="footer">
                    &copy; ' . date("Y") . ' Vectorestore. All rights reserved.
                </div>
            </div>
        </body>
        </html>';
    }
}

// Run the process
$main = new MainClass();
echo $main->execute();
