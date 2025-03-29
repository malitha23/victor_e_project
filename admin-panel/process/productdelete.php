<?php
// Include database connection file
require_once '../db.php'; // Adjust the path as necessary

// Check if productID is sent via POST
if (isset($_POST['productID'])) {
     // Sanitize and validate input
     $productID = intval($_POST['productID']);
     $bachcode = [];
     $batch = Databases::Search("SELECT * FROM `batch` WHERE `product_id`='" . $productID . "' AND `Delete`='0' ");
     $batchnum = $batch->num_rows;
     for ($i = 0; $i < $batchnum; $i++) {
          $batchdata = $batch->fetch_assoc();
          $bachcode[$i] = $batchdata["batch_code"];
     }
     if ($batchnum > 0) {
          for ($i = 0; $i < $batchnum; $i++) {
               echo ($bachcode[$i] . "Delete these first.Then delete these.");
          }
          exit();
     }
     $product = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $productID . "' ");
     $productnum = $product->num_rows;
     if ($productnum == 1) {
          $productdata = $product->fetch_assoc();
          if ($productdata["delete_id"] == 0) {
               if ($batchnum == 0) {
                    Databases::IUD("UPDATE `product` SET `delete_id` = '1' WHERE (`id` = '" . $productID . "');");
               }
          } else {
               echo ("This product has been deleted in the past.");
               exit();
          }
     }else{
          echo("not found product");
     }
} else {
     echo "No product ID provided.";
}

