<?php
require "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
     $invoiceId = intval($_POST['id']);
     $invoice = Databases::Search("SELECT * FROM `invoice` WHERE `id`='" . $invoiceId . "' ");
     $invoicenum = $invoice->num_rows;

     if ($invoicenum == 1) {
          $invoicedata = $invoice->fetch_assoc();

          // Fetch related data
          $batch = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $invoicedata["batch_id"] . "' ");
          $batchdata = $batch->fetch_assoc();
          $product = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata['product_id'] . "' ");
          $productdata = $product->fetch_assoc();
          $user = Databases::Search("SELECT * FROM `user` WHERE `email`='" . $invoicedata["user_email"] . "' ");
          $userdata = $user->fetch_assoc();
          $address = Databases::Search("SELECT * FROM `address` WHERE `address_id`='" . $userdata["adress_id"] . "' ");
          $addressdata = $address->fetch_assoc();
          $city = Databases::Search("SELECT * FROM `city` WHERE `city_id`='" . $addressdata["city_city_id"] . "' ");
          $citydata = $city->fetch_assoc();
          $district = Databases::Search("SELECT * FROM `distric` WHERE `distric_id`='" . $addressdata["distric_distric_id"] . "' ");
          $districtdata = $district->fetch_assoc();

          // Create new PDF document
?>
          <!DOCTYPE html>
          <html lang="en">

          <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <title>Invoice</title>
               <style>
                    body {
                         font-family: Arial, sans-serif;
                         margin: 0;
                         padding: 0;
                         background-color: #f4f4f9;
                         color: #333;
                    }

                    .container {
                         width: 80%;
                         margin: 30px auto;
                         padding: 20px;
                         background-color: #fff;
                         border-radius: 8px;
                         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }

                    .header {
                         text-align: center;
                         margin-bottom: 40px;
                    }

                    .header h1 {
                         margin: 0;
                         font-size: 30px;
                         color: #333;
                    }

                    .header p {
                         font-size: 18px;
                         color: #666;
                    }

                    .invoice-details,
                    .billing-info {
                         margin-bottom: 30px;
                    }

                    .invoice-details h2,
                    .billing-info h2 {
                         font-size: 22px;
                         margin-bottom: 10px;
                    }

                    .invoice-details table,
                    .billing-info table {
                         width: 100%;
                         border-collapse: collapse;
                         margin-top: 15px;
                    }

                    .invoice-details th,
                    .billing-info th {
                         text-align: left;
                         padding: 8px;
                         background-color: #f2f2f2;
                    }

                    .invoice-details td,
                    .billing-info td {
                         padding: 8px;
                         border: 1px solid #ddd;
                    }

                    .total {
                         font-size: 18px;
                         font-weight: bold;
                         text-align: right;
                         margin-top: 10px;
                    }

                    .footer {
                         margin-top: 40px;
                         text-align: center;
                         font-size: 14px;
                         color: #777;
                    }
               </style>
          </head>

          <body>
               <div class="container">
                    <div class="header">
                         <h1>Invoice # <?php echo $invoicedata['uni_code']; ?></h1>
                         <p>Issued on: <?php echo date('Y-m-d', strtotime($invoicedata['date_time'])); ?></p>
                    </div>

                    <div class="invoice-details">
                         <h2>Invoice Details</h2>
                         <table>
                              <tr>
                                   <th>Product</th>
                                   <td><?php echo $productdata['title']; ?></td>
                              </tr>
                              <tr>
                                   <th>Quantity</th>
                                   <td><?php echo $invoicedata['qty']; ?></td>
                              </tr>
                              <tr>
                                   <th>Price</th>
                                   <td>$<?php echo number_format($invoicedata['price'], 2); ?></td>
                              </tr>
                              <tr>
                                   <th>Discount</th>
                                   <td>-$<?php echo number_format($invoicedata['discount'], 2); ?></td>
                              </tr>
                              <tr>
                                   <th>Delivery Fee</th>
                                   <td>$<?php echo number_format($invoicedata['delivery_fee'], 2); ?></td>
                              </tr>
                              <tr>
                                   <th>Total</th>
                                   <td>$<?php echo number_format($invoicedata['price'] - $invoicedata['discount'] + $invoicedata['delivery_fee'], 2); ?></td>
                              </tr>
                         </table>
                    </div>

                    <div class="billing-info">
                         <h2>Billing Information</h2>
                         <table>
                              <tr>
                                   <th>Name</th>
                                   <td><?php echo $userdata['fname'] . ' ' . $userdata['lname']; ?></td>
                              </tr>
                              <tr>
                                   <th>Address</th>
                                   <td><?php echo $addressdata['line_1'] . ', ' . $addressdata['line_2']; ?></td>
                              </tr>
                              <tr>
                                   <th>City</th>
                                   <td><?php echo $citydata['name']; ?></td>
                              </tr>
                              <tr>
                                   <th>District</th>
                                   <td><?php echo $districtdata['name']; ?></td>
                              </tr>
                         </table>
                    </div>

                    <div class="total">
                         <p>Total Amount: $<?php echo number_format($invoicedata['price'] - $invoicedata['discount'] + $invoicedata['delivery_fee'], 2); ?></p>
                    </div>

                    <div class="footer">
                         <p>&copy; 2025 Your Company Name. All rights reserved.</p>
                    </div>
               </div>
          </body>

          </html>

<?php
     }
} else {
     http_response_code(400);
     echo "Invalid request.";
}
?>