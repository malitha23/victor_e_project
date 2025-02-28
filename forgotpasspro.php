<?php

// Handle POST Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and Validate Email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Include Database Connection
    require "connection.php"; // Ensure $pdo is defined inside this file

    // Check if Email Exists
    $stmt = Database::Search("SELECT * FROM `user` WHERE `email` = '".$email."' ");
  
    if ($stmt->num_rows === 0) {
        echo "Email address not registered.";
        exit;
    }

    // Generate OTP and Update Database
    $code = bin2hex(random_bytes(5)); // Generate a 10-character verification code
    Database::IUD("UPDATE `user` SET `v_code` = '".$code."' WHERE `email` = '".$email."'");
   

    // Send Email
    require "email/PHPMailer.php";
    require "email/SMTP.php";
    require "email/Exception.php";

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'codylanka00@gmail.com'; // Replace with your email
        $mail->Password = 'jnil boop pwrb sejy';       // Replace with your email password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Email Content
        $mail->setFrom('your_email@gmail.com', 'Vectorestore');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';

        $mail->Body = generateEmailBody($code);

        // Send Email
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

// Generate HTML Email Body
function generateEmailBody($code): string
{
    return '
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #0056b3;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            color: #333333;
        }
        .email-body p {
            line-height: 1.8;
            margin: 0 0 15px;
        }
        .otp {
            display: inline-block;
            font-size: 22px;
            font-weight: bold;
            color: #0056b3;
            background-color: #e9f4ff;
            padding: 10px 20px;
            margin: 20px 0;
            border-radius: 6px;
            text-align: center;
        }
        .products-section {
            margin-top: 20px;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .product-item {
            flex: 1 1 calc(50% - 10px);
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .product-item img {
            max-width: 100%;
            border-radius: 4px;
        }
        .product-item p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .email-footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .email-footer a {
            color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Vectorestore</h1>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <p>Dear Customer,</p>
            <p>We received a request to reset your password for your Vectorestore account. Use the verification code below to reset your password. If you did not request this, please ignore this email.</p>
            <div class="otp">'.$code.'</div> <!-- Replace with dynamic OTP -->
            <p>If you have any questions or need assistance, please feel free to contact our support team.</p>

            <!-- Product Section -->
            <div class="products-section">
                <h3>Discover Our Popular Products:</h3>
                <div class="product-list">
                    <div class="product-item">
                        <img src="https://via.placeholder.com/100x100?text=Biscuits" alt="Biscuits">
                        <p>Biscuits</p>
                    </div>
                    <div class="product-item">
                        <img src="https://via.placeholder.com/100x100?text=Cooking+Oil" alt="Cooking Oil">
                        <p>Cooking Oil</p>
                    </div>
                    <div class="product-item">
                        <img src="https://via.placeholder.com/100x100?text=Snacks" alt="Snacks">
                        <p>Snacks</p>
                    </div>
                    <div class="product-item">
                        <img src="https://via.placeholder.com/100x100?text=Groceries" alt="Groceries">
                        <p>Groceries</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>Thank you for choosing <strong>Vectorestore</strong>.</p>
            <p><a href="#">Visit Our Website</a></p>
            <p>Need help? Contact us:</p>
            <p>Email: <a href="mailto:support@vectorestore.com">support@vectorestore.com</a></p>
            <p>Phone: +1 234 567 890</p>
        </div>
    </div>
</body>
</html>
';
}
