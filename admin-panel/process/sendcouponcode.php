<?php
require "../db.php";
// Send Email
require ".../email/PHPMailer.php";
require ".../email/SMTP.php";
require ".../email/Exception.php";

class main
{
    public function main()
    {
        $cuponcode = "abc";
        $user_email = "sahantharakasahan500@gmail.com";
        $start_date = 2021 - 12 - 12;
        $end_date = 2022 - 12 - 12;
        $dispre = 20;
        if (strlen($user_email) > 100) {
            return ("user email is invalid");
            exit();
        }
        if (strlen($cuponcode) > 45) {
            return ("code is invalid");
            exit();
        }
        if (strlen($dispre) > 45) {
            return ("discount is invalid");
            exit();
        }
        $S = new insert();
        return  $S->sql($cuponcode, $user_email, $start_date, $end_date, $dispre);
    }
}
class insert
{
    function sql($cuponcode, $user_email, $start_date, $end_date, $dispre)
    {
        Databases::IUD("INSERT INTO `coupon` (`code`, `user_email`, `start_date`, `end_date`, `status`, `dis_percentage`) 
        VALUES ('" . $cuponcode . "', '" . $user_email . "', '" . $start_date . ", '$end_date', 1, '$dispre');");
        return  new emailsend()->sendmail($user_email, $cuponcode);
    }
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSend
{
    public function sendmail($email, $couponCode)
    {
        require 'vendor/autoload.php'; // Ensure PHPMailer is loaded

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'codylanka00@gmail.com'; // Your Gmail
            $mail->Password = 'jnil boop pwrb sejy';    // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('codylanka00@gmail.com', 'Vectorestore');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = '🎁 Your Exclusive Coupon Code Inside!';

            $mail->Body = $this->generateEmailBody($couponCode);

            if ($mail->send()) {
                echo 1;
            } else {
                echo "Failed to send email. Please try again later.";
            }
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
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

$main = new main();
$mainmethod = $main->main();
echo $mainmethod;
