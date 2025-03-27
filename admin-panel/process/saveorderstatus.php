<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     require "../db.php"; // Make sure you include your database connection file

     // Get the order status from the POST request
     $status = isset($_POST['status']) ? trim($_POST['status']) : null;

     // Validate the input
     if (empty($status)) {
          echo json_encode(["success" => false, "message" => "Order status cannot be empty."]);
          exit;
     }
     if (strlen($status) > 45) {
          echo json_encode(["success" => false, "message" => "Order status text is too high."]);
          exit;
     }
     Databases::IUD("INSERT INTO `order_status` (`status`) VALUES ('".$status."');");
     echo json_encode(["success" => true, "message" => "Order status saved successfully!"]);
} else {
     echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
