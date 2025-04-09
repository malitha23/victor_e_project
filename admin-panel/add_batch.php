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
                    date_default_timezone_set('Asia/Colombo'); // Set timezone to Sri Jayawardenepura Kotte, Sri Lanka
                    $date = date('Y-m-d H:i:s');
                    $delete = 0;
                    $query = "INSERT INTO `batch` (`product_id`,`Delete`,`date`,`batch_code`, `vendor_name`, `batch_qty`, `batch_price`, `selling_price`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $result = Databases::IUD($query, [$productID,$delete, $date, $batchcode, $vendor, $batchQty, $batchPrice, $sellingPrice], "iisssddd");

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
