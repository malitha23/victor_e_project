<?php
header('Content-Type: application/json');

// Include the database connection file
require "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Get the weightId from the POST request
     $weightId = isset($_POST['weightId']) ? (int)$_POST['weightId'] : null;
     $fee = isset($_POST['fee']) ? (int)$_POST['fee'] : null;
   
     // Validate the input
     if (!$weightId) {
          echo json_encode(["success" => false, "message" => "Invalid weight selected."]);
          exit;
     }
     if(empty($fee)){
          echo json_encode(["success" => false, "message" => "ENTER FEE."]);
          exit;  
     }

     Databases::IUD("INSERT INTO `delivery_fee_for_weight` 
     (`fee`, `weight_id`) VALUES ('".$fee."', '".$weightId."');");

     echo json_encode(["success" => true, "message" => "Weight successfully saved!"]);
} else {
     echo json_encode(["success" => false, "message" => "Invalid request."]);
}
