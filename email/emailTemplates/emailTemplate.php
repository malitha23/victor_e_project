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

function generateInvoice($invoiceData) {
    try {
        $totalAmount = 0;
        $dateTime = date('Y-m-d H:i:s'); // Get current date and time

        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Invoice</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 10px;
                    color: #333;
                    font-size: 12px;
                }
                .invoice-container {
                    width: 100%;
                    max-width: 700px;
                    margin: 0 auto;
                    padding: 15px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                    background-color: #f9f9f9;
                }
                h2 {
                    text-align: center;
                    color: #4CAF50;
                    margin-bottom: 3px;
                    font-size: 18px;
                }
                .invoice-info {
                    margin-bottom: 15px;
                    text-align: center;
                    font-size: 12px;
                    color: #555;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }
                th, td {
                    padding: 6px;
                    border: 1px solid #ddd;
                    text-align: center;
                    font-size: 12px;
                }
                th {
                    background-color: #4CAF50;
                    color: white;
                    font-size: 12px;
                }
                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                .total-section {
                    margin-top: 15px;
                    display: flex;
                    justify-content: flex-end;
                }
                .total-table {
                    border: 1px solid #ddd;
                    border-collapse: collapse;
                    font-size: 12px;
                }
                .total-table th, .total-table td {
                    padding: 6px;
                    border: 1px solid #ddd;
                    text-align: right;
                }
                .total-table th {
                    background-color: #4CAF50;
                    font-weight: bold;
                     text-align: center;
                }
            </style>
        </head>
        <body>
<h2> Your Payment Is Success</h2>
        <div class="invoice-container">
            <h2>Invoice</h2>
            <div class="invoice-info">
                <p><strong>Date:</strong> ' . $dateTime . '</p>
                <p><strong>Invoice Code:</strong> ' . htmlspecialchars($invoiceData[0]['uni_code']) . '</p>
            </div>

            <table>
                <tr>
                    <th>Product Title</th>
                    <th>Quantity</th>
                    <th>Price (LKR)</th>
                    <th>Discount (%)</th>
                    <th>Discount Amount (LKR)</th>
                    <th>Delivery Fee (LKR)</th>
                    <th>Sub Total (LKR)</th>
                </tr>';

        foreach ($invoiceData as $data) {
            // Calculate discount as percentage of total price (price * qty)
            $discountAmount = ($data['price'] * $data['qty']) * ($data['discount'] / 100);

            // Calculate line total after applying discount and adding delivery fee
            $lineTotal = ($data['price'] * $data['qty']) - $discountAmount + $data['delivery_fee'];
            $totalAmount += $lineTotal;

            $html .= '<tr>
                <td>' . htmlspecialchars($data['title']) . '</td>
                <td>' . htmlspecialchars($data['qty']) . '</td>
                <td>Rs ' . number_format($data['price'], 2) . '</td>
                <td>' . number_format($data['discount'], 2) . '%</td>
                <td>Rs ' . number_format($discountAmount, 2) . '</td>
                <td>Rs ' . number_format($data['delivery_fee'], 2) . '</td>
                <td>Rs ' . number_format($lineTotal, 2) . '</td>
            </tr>';
        }

        $html .= '</table>';

        // Total Section
        $html .= '
            <div class="total-section">
                <table class="total-table">
                    <tr>
                        <th>Total Amount:</th>
                        <td><strong>Rs ' . number_format($totalAmount, 2) . '</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        </body>
        </html>';

        // Save to file
        file_put_contents('generated_invoice.html', $html);

         // Plain text version
         $plainTextContent = ",\n\nThank you for your purchase. Here are the details of your invoice:\n\n";
    return [
        'html' => $html,
        'plain' => $plainTextContent
    ];
     
    } catch (Exception $e) {
        echo 'Error generating invoice: ' . $e->getMessage();
    }
}
?>
