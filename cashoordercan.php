<?php
// cashoordercan.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "connection.php"; // Ensure this sets up $pdo or Database class

header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *');

require "email/PHPMailer.php";
require "email/SMTP.php";
require "email/Exception.php";

if (isset($_POST['uniq_id'])) {
    $uniq_id = $_POST['uniq_id'];

    // Retrieve the order from `cashond` table
    $cashon = Database::Search("SELECT * FROM `cashond` WHERE `uniq_id`='" . $uniq_id . "'");
    $cashon_data = $cashon->fetch_assoc();

    if ($cashon_data) {
        $user_email = $cashon_data['email'];

        // Send Email to Admin
        $admin_email = "jayasundarasahan913@gmail.com"; // Admin email address

        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'codylanka00@gmail.com'; // Your Gmail
            $mail->Password = 'jnil boop pwrb sejy';   // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email Setup
            $mail->setFrom('codylanka00@gmail.com', 'Vicstore Notifications');
            $mail->addAddress($admin_email);
            $mail->isHTML(true);
            $mail->Subject = 'Order Cancelled - Notification';
            $mail->Body = "
                <h2>Order Cancellation Alert</h2>
                <p>The following order has been canceled:</p>
                <ul>
                    <li><strong>Unique ID:</strong> {$uniq_id}</li>
                    <li><strong>User Email:</strong> {$user_email}</li>
                </ul>
            ";

            $mail->send();
            echo "success";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "error_no_order_found";
    }
} else {
    echo "error_no_id";
}
?>
