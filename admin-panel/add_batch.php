<?php
session_start();
require_once("db.php"); // Include your database connection class
if (isset($_SESSION["a"])) {
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Get values from POST request
          $productID = $_POST["productID"];
          $vendor = trim($_POST["vendor"]);
          $batchQty = trim($_POST["batchQty"]);
          $batchPrice = trim($_POST["batchPrice"]);
          $sellingPrice = trim($_POST["sellingPrice"]);
          $batchcode = trim($_POST["batchcode"]);
          
          if ($productID == "0" || empty($vendor) || !is_numeric($batchQty) || $batchQty <= 0 || !is_numeric($batchPrice) || $batchPrice <= 0 || !is_numeric($sellingPrice) || $sellingPrice <= 0) {
               echo "Invalid input data!";
          } else {
               $b = Databases::Search("SELECT * FROM `batch` WHERE `batch_code`='" . $batchcode . "' ");
               $bnum = $b->num_rows;
               if ($bnum == 1) {
                    echo "repeat batch_code,pleace enter new batch code or update";
               } else {
                    // Insert into database
                    $query = "INSERT INTO `batch` (`product_id`,`batch_code`, `vendor_name`, `batch_qty`, `batch_price`, `selling_price`) VALUES (?, ?, ?, ?, ?, ?)";
                    $result = Databases::IUD($query, [$productID, $batchcode, $vendor, $batchQty, $batchPrice, $sellingPrice], "issddd");

                    if ($result) {
                         echo "Batch added successfully!";
                    } else {
                         echo "Error adding batch.";
                    }
               }
          }
     } else {
          echo "Invalid request!";
     }
}
