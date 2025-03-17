<?php
session_start();

if (isset($_SESSION["a"])) {
     require "../db.php";
     $uemail = $_SESSION["a"]["username"];
     $query = "SELECT * FROM `admin` WHERE `username` = ?";
     $params = [$uemail];
     $types = "s";
     $u_detail = Databases::Search($query, $params, $types);
     if ($u_detail->num_rows == 1) {
          if ($_SERVER["REQUEST_METHOD"] === "POST") {
               $status = isset($_POST['status']) ? trim($_POST['status']) : '';
               $orderId = isset($_POST['orderId']) ? trim($_POST['orderId']) : '';

               // Basic validation
               if (empty($status) || empty($orderId)) {
                    echo "Please provide a valid order ID and status.";
                    exit;
               }
               Databases::IUD("UPDATE `victore`.`order` SET `Order_status_id` = '" . $status . "' WHERE 
(`id` = '" . $orderId . "');");
               // Example success message (You can add database saving logic here)
               echo "Order status for Order ID  has been successfully updated to '..'.";
          } else {
               echo "Invalid request method.";
          }
     }
}
