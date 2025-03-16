<?php
session_start();
include "../connection.php";
require '../email/emailSend.php';
include '../email/emailTemplates/emailTemplate.php';

// Read the input data
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

file_put_contents('ipay_callback_log.txt', print_r($data, true), FILE_APPEND);

if (!$data) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid request"]);
    exit();
}

// Extract and sanitize input data
$transactionReference = $data['transactionReference'] ?? null;
$transactionTimeInMillis = $data['transactionTimeInMillis'] ?? null;
$transactionAmount = number_format((float) ($data['transactionAmount'] ?? 0), 2, '.', '');
$creditedAmount = $data['creditedAmount'] ?? null;
$transactionStatus = $data['transactionStatus'] ?? null;
$transactionMessage = $data['transactionMessage'] ?? null;
$orderId = $data['orderId'] ?? null;
$checksum = $data['checksum'] ?? null;

if (!$transactionReference || !$orderId || !$transactionTimeInMillis || !$transactionAmount || !$transactionStatus || !$checksum) {
    http_response_code(400);
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$secret = "@A123456";

// Generate checksum for validation
$message = $transactionReference . $orderId . $transactionTimeInMillis . $transactionAmount . $transactionStatus;
$generatedChecksum = base64_encode(hash_hmac('sha256', $message, $secret, true));

file_put_contents('ipay_callback_log.txt', "Generated Checksum: " . $generatedChecksum . "\n", FILE_APPEND);

if ($generatedChecksum !== $checksum) {
    http_response_code(400);
    echo json_encode(["message" => "Checksum verification failed!"]);
    file_put_contents('ipay_callback_log.txt', "Checksum verification failed\n", FILE_APPEND);
    exit();
}

// Open database connection
Database::SetupConnection();

// Insert transaction record
$insertTransactionQuery = "INSERT INTO transactions 
(transaction_reference, order_id, transaction_time, transaction_amount, credited_amount, transaction_status, transaction_message, checksum) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$result = Database::IUD($insertTransactionQuery, [
    $transactionReference,
    $orderId,
    $transactionTimeInMillis,
    $transactionAmount,
    $creditedAmount,
    $transactionStatus,
    $transactionMessage,
    $checksum
], "ssiddsss");

if ($result) {
    file_put_contents('ipay_callback_log.txt', "Transaction saved to database.\n", FILE_APPEND);
} else {
    file_put_contents('ipay_callback_log.txt', "Failed to save transaction.\n", FILE_APPEND);
}

// Determine order status
$orderStatusId = 0;
if ($transactionStatus === 'A') {
    $orderStatusId = 2; // Approved
} elseif ($transactionStatus === 'P') {
    $orderStatusId = 2; // Pending
} elseif ($transactionStatus === 'D') {
    $orderStatusId = 1; // Declined
}

// Update order status if valid
if ($orderStatusId > 0) {
    $updateOrderQuery = "UPDATE `order` SET Order_status_id = ? WHERE id = ?";
    $result = Database::IUD($updateOrderQuery, [$orderStatusId, $orderId], "is");


    if ($result) {
        file_put_contents('ipay_callback_log.txt', "Order status updated to: {$orderStatusId}\n", FILE_APPEND);

        if ($transactionStatus === 'A' || $transactionStatus === 'P') {
            // Get invoice ID from order
            $getOrderIdQuery = "SELECT invoice_id FROM `order` WHERE id = '$orderId'";
            $orderIdResult = Database::SEARCH($getOrderIdQuery);

            if ($orderIdResult && $orderIdResult->num_rows > 0) {
                $row = $orderIdResult->fetch_assoc();
                $invoice_id = $row['invoice_id'];

                // Get product details from invoice
                $getInvoiceQuery = "SELECT product_id, batch_id, qty FROM invoice WHERE uni_code = '$invoice_id'";
                $invoiceResult = Database::SEARCH($getInvoiceQuery);

                if ($invoiceResult) {
                    while ($invoiceRow = $invoiceResult->fetch_assoc()) {
                        $productId = $invoiceRow['product_id'];
                        $quantity = $invoiceRow['qty'];
                        $batchId = $invoiceRow['batch_id'];

                        // Get current batch quantity
                        $getBatchQuery = "SELECT batch_qty FROM batch WHERE product_id = '$productId' AND id = '$batchId'";
                        $batchResult = Database::SEARCH($getBatchQuery);

                        if ($batchResult && $batchResult->num_rows > 0) {
                            $batchRow = $batchResult->fetch_assoc();
                            $currentBatchQty = $batchRow['batch_qty'];

                            if ($currentBatchQty >= $quantity) {
                                $newBatchQty = $currentBatchQty - $quantity;

                                // Update batch quantity
                                $updateBatchQuery = "UPDATE batch SET batch_qty = ? WHERE id = ? AND product_id = ?";
                                $batchUpdateResult = Database::IUD($updateBatchQuery, [$newBatchQty, $batchId, $productId], "iii");

                                if ($batchUpdateResult) {
                                    file_put_contents('ipay_callback_log.txt', "Batch quantity updated for product ID: {$productId}. New quantity: {$newBatchQty}\n", FILE_APPEND);
                                } else {
                                    file_put_contents('ipay_callback_log.txt', "Failed to update batch quantity for product ID: {$productId}\n", FILE_APPEND);
                                }
                            } else {
                                file_put_contents('ipay_callback_log.txt', "Not enough stock for product ID: {$productId}\n", FILE_APPEND);
                            }
                        }
                    }

                    $getInvoiceQuery = "SELECT 
                        i.id AS invoice_id,
                        i.uni_code,
                        i.product_id,
                        i.batch_id,
                        i.price,
                        i.discount,
                        i.delivery_fee,
                        i.user_email,
                        i.qty,
                        p.id AS product_id,
                        p.title,
                        p.description,
                        p.delete_id,
                        p.condition_id,
                        p.status_id,
                        p.picture_id,
                        p.consignment_stock,
                        p.weight,
                        p.date,
                        p.sub_category_id,
                        p.brand_id
                    FROM 
                        invoice i
                    JOIN 
                        product p ON i.product_id = p.id
                    WHERE 
                        i.uni_code = '$invoice_id' ";

                    $invoiceResult = Database::SEARCH($getInvoiceQuery);

                    if ($invoiceResult) {
                        $invoiceData = [];

                        while ($invoiceRow = $invoiceResult->fetch_assoc()) {
                            $invoiceData[] = [
                                'invoice_id' => $invoiceRow['invoice_id'],
                                'uni_code' => $invoiceRow['uni_code'],
                                'batch_id' => $invoiceRow['batch_id'],
                                'price' => $invoiceRow['price'],
                                'discount' => $invoiceRow['discount'],
                                'delivery_fee' => $invoiceRow['delivery_fee'],
                                'user_email' => $invoiceRow['user_email'],
                                'qty' => $invoiceRow['qty'],
                                'product_id' => $invoiceRow['product_id'],
                                'title' => $invoiceRow['title'],
                                'description' => $invoiceRow['description'],
                                'delete_id' => $invoiceRow['delete_id'],
                                'condition_id' => $invoiceRow['condition_id'],
                                'status_id' => $invoiceRow['status_id'],
                                'picture_id' => $invoiceRow['picture_id'],
                                'consignment_stock' => $invoiceRow['consignment_stock'],
                                'weight' => $invoiceRow['weight'],
                                'date' => $invoiceRow['date'],
                                'sub_category_id' => $invoiceRow['sub_category_id'],
                                'brand_id' => $invoiceRow['brand_id']
                            ];
                        }

                        // Call the async function
                        asyncGenerateInvoice($invoiceData, $invoiceData[0]['user_email']);
                    } else {
                        file_put_contents('invoice_log.txt', "Failed to fetch invoice details\n", FILE_APPEND);
                    }

                }
            }
        }
    } else {
        file_put_contents('ipay_callback_log.txt', "Failed to update order status.\n", FILE_APPEND);
    }
}

function asyncGenerateInvoice($invoiceData, $email)
{
    try {
        $getUserQuery = "SELECT fname, lname FROM user WHERE email = '$email'";
        $userResult = Database::SEARCH($getUserQuery);
        $fname = '';
        $lname = '';
        if ($userResult) {
            $user = $userResult->fetch_assoc(); // Fetch as an associative array
            $fname = $user['fname'];
            $lname = $user['lname'];
        }

        // Generate invoice
        $emailContent = generateInvoice($invoiceData);

        $emailSend = new EmailSend();
        $emailSend->setRecipient($email, $fname);
        $emailSend->setContent('Your Payment Successful', $emailContent['html'], $emailContent['plain']);

        // Send the email and check status
        if ($emailSend->send()) {
            file_put_contents('invoice_log.txt', "Invoice generated and email sent successfully.\n", FILE_APPEND);
        } else {
            file_put_contents('invoice_log.txt', "Invoice generated, but email sending failed.\n", FILE_APPEND);
        }
    } catch (Exception $e) {
        file_put_contents('invoice_log.txt', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
    }
}


// Function to generate invoice
// function generateInvoice($invoiceData) {
//     try {
//         $totalAmount = 0;
//         $dateTime = date('Y-m-d H:i:s'); // Get current date and time

//         $html = '<!DOCTYPE html>
//         <html lang="en">
//         <head>
//             <meta charset="UTF-8">
//             <meta name="viewport" content="width=device-width, initial-scale=1.0">
//             <title>Invoice</title>
//             <style>
//                 body {
//                     font-family: Arial, sans-serif;
//                     margin: 10px;
//                     color: #333;
//                     font-size: 12px;
//                 }
//                 .invoice-container {
//                     width: 100%;
//                     max-width: 700px;
//                     margin: 0 auto;
//                     padding: 15px;
//                     border: 1px solid #ccc;
//                     border-radius: 6px;
//                     box-shadow: 0 2px 6px rgba(0,0,0,0.1);
//                     background-color: #f9f9f9;
//                 }
//                 h2 {
//                     text-align: center;
//                     color: #4CAF50;
//                     margin-bottom: 3px;
//                     font-size: 18px;
//                 }
//                 .invoice-info {
//                     margin-bottom: 15px;
//                     text-align: center;
//                     font-size: 12px;
//                     color: #555;
//                 }
//                 table {
//                     width: 100%;
//                     border-collapse: collapse;
//                     margin-top: 10px;
//                 }
//                 th, td {
//                     padding: 6px;
//                     border: 1px solid #ddd;
//                     text-align: center;
//                     font-size: 12px;
//                 }
//                 th {
//                     background-color: #4CAF50;
//                     color: white;
//                     font-size: 12px;
//                 }
//                 tr:nth-child(even) {
//                     background-color: #f2f2f2;
//                 }
//                 .total-section {
//                     margin-top: 15px;
//                     display: flex;
//                     justify-content: flex-end;
//                 }
//                 .total-table {
//                     border: 1px solid #ddd;
//                     border-collapse: collapse;
//                     font-size: 12px;
//                 }
//                 .total-table th, .total-table td {
//                     padding: 6px;
//                     border: 1px solid #ddd;
//                     text-align: right;
//                 }
//                 .total-table th {
//                     background-color: #4CAF50;
//                     font-weight: bold;
//                      text-align: center;
//                 }
//             </style>
//         </head>
//         <body>

//         <div class="invoice-container">
//             <h2>Invoice</h2>
//             <div class="invoice-info">
//                 <p><strong>Date:</strong> ' . $dateTime . '</p>
//                 <p><strong>Invoice Code:</strong> ' . htmlspecialchars($invoiceData[0]['uni_code']) . '</p>
//             </div>

//             <table>
//                 <tr>
//                     <th>Product Title</th>
//                     <th>Quantity</th>
//                     <th>Price (LKR)</th>
//                     <th>Discount (%)</th>
//                     <th>Discount Amount (LKR)</th>
//                     <th>Delivery Fee (LKR)</th>
//                     <th>Sub Total (LKR)</th>
//                 </tr>';

//         foreach ($invoiceData as $data) {
//             // Calculate discount as percentage of total price (price * qty)
//             $discountAmount = ($data['price'] * $data['qty']) * ($data['discount'] / 100);

//             // Calculate line total after applying discount and adding delivery fee
//             $lineTotal = ($data['price'] * $data['qty']) - $discountAmount + $data['delivery_fee'];
//             $totalAmount += $lineTotal;

//             $html .= '<tr>
//                 <td>' . htmlspecialchars($data['title']) . '</td>
//                 <td>' . htmlspecialchars($data['qty']) . '</td>
//                 <td>Rs ' . number_format($data['price'], 2) . '</td>
//                 <td>' . number_format($data['discount'], 2) . '%</td>
//                 <td>Rs ' . number_format($discountAmount, 2) . '</td>
//                 <td>Rs ' . number_format($data['delivery_fee'], 2) . '</td>
//                 <td>Rs ' . number_format($lineTotal, 2) . '</td>
//             </tr>';
//         }

//         $html .= '</table>';

//         // Total Section
//         $html .= '
//             <div class="total-section">
//                 <table class="total-table">
//                     <tr>
//                         <th>Total Amount:</th>
//                         <td><strong>Rs ' . number_format($totalAmount, 2) . '</strong></td>
//                     </tr>
//                 </table>
//             </div>
//         </div>

//         </body>
//         </html>';

//         // Save to file
//         file_put_contents('generated_invoice.html', $html);

//         echo "Invoice generated successfully.";

//     } catch (Exception $e) {
//         echo 'Error generating invoice: ' . $e->getMessage();
//     }
// }




// Close the database connection
Database::CloseConnection();

// Respond to iPay
if ($transactionStatus === 'A') {
    file_put_contents('ipay_callback_log.txt', "Payment successful for Order ID: {$orderId}\n", FILE_APPEND);
    http_response_code(200);
    echo json_encode(["message" => "Payment successful."]);
} elseif ($transactionStatus === 'P') {
    file_put_contents('ipay_callback_log.txt', "Payment pending for Order ID: {$orderId}\n", FILE_APPEND);
    http_response_code(200);
    echo json_encode(["message" => "Payment is pending."]);
} else {
    file_put_contents('ipay_callback_log.txt', "Payment failed for Order ID: {$orderId}. Status: {$transactionStatus}\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(["message" => "Payment failed."]);
}
