<?php
// emailTemplate.php

function getEmailContent($fname, $lname, $email, $generatedPassword) {
    // HTML version
    $htmlContent = "
    <h1>Welcome to Our Website!</h1>
    <p>Hi <strong>$fname $lname</strong>,</p>
    <p>Thank you for registering. Below are your login credentials:</p>
    <table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>
        <tr>
            <th style='text-align: left;'>Email</th>
            <td>$email</td>
        </tr>
        <tr>
            <th style='text-align: left;'>Password</th>
            <td>$generatedPassword</td>
        </tr>
    </table>
    <p>Please keep these credentials secure. You can change your password later in your account settings.</p>
    <p>Best regards,<br>Our Website Team</p>
    ";

    // Plain text version
    $plainTextContent = "Hi $fname $lname,\n\nThank you for registering. Below are your login credentials:\n\nEmail: $email\nPassword: $generatedPassword\n\nPlease keep these credentials secure.";

    return [
        'html' => $htmlContent,
        'plain' => $plainTextContent
    ];
}
?>
