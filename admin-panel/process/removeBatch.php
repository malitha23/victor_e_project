<?php
// Start the session
session_start();

// Check if the admin is logged in
if (isset($_SESSION["a"])) {
     require "../db.php";

     // Get the batch ID and discount group ID from the POST request
     if (isset($_POST['batchId']) && isset($_POST['discountGroupId'])) {
          $batchId = $_POST['batchId'];
          $discountGroupId = $_POST['discountGroupId'];

          Databases::IUD("DELETE FROM `discount_date_range_has_product` 
WHERE (`batch_id` = '" . $batchId . "' AND `discount_group_id`='" . $discountGroupId . "' );");
     } else {
          echo "Error: Invalid request.";
     }
} else {
     echo "Error: Unauthorized access.";
}
