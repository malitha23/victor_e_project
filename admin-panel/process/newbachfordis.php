<?php
require "../db.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $batch_id = $_POST["batch_id"];
     $discount_id = $_POST["discount_id"];
     $qty = $_POST["qty"];
     $EpercentageInput = $_POST["EpercentageInput"];
     $startdate = $_POST["startdate"];
     $enddate = $_POST["enddate"];

     // Validate input
     if (!is_numeric($batch_id) || !is_numeric($discount_id) || !is_numeric($qty) || $qty < 1) {
          echo "Invalid input data.";
          exit;
     }

     $batch = Databases::Search("SELECT * FROM `batch`");
     $batchData = $batch->fetch_assoc();

     // Check existing entries
     $discountCheck = Databases::Search("SELECT * FROM `discount_date_range_has_product` 
        WHERE `discount_group_id`='" . $discount_id . "' AND `batch_id`='" . $batch_id . "'");

     if ($discountCheck->num_rows == 1) {
          $existingEntry = $discountCheck->fetch_assoc();
          $totalQty = $existingEntry["qty"] + $qty;

          if ($totalQty > $batchData["batch_qty"]) {
               echo "Batch quantity exceeds available stock.";
          } else {
               Databases::IUD("UPDATE `discount_date_range_has_product` 
                SET `qty` = '" . $totalQty . "'
                WHERE `id` = '" . $existingEntry["id"] . "'");
               echo "Updated";
          }
     } else {
          if ($batchData["batch_qty"] < $qty) {
               echo "Batch quantity exceeds available stock.";
          } else {
               $discountRange = Databases::Search("SELECT * FROM `discount_date_range_has_product` 
                WHERE `discount_group_id`='" . $discount_id . "'");

               if ($discountRangeData = $discountRange->fetch_assoc()) {
                    Databases::IUD("INSERT INTO `discount_date_range_has_product`
                    (`discount_date_range_id`, `discount_pre`, `discount_group_id`, `qty`, `batch_id`) 
                    VALUES ('" . $discountRangeData["discount_date_range_id"] . "', 
                            '" . $discountRangeData["discount_pre"] . "', 
                            '" . $discount_id . "', 
                            '" . $qty . "', 
                            '" . $batch_id . "');");
                    echo "Updated";
               } else {
                    if (empty($EpercentageInput)) {
                         echo "Enter percentage";
                    } else {
                         if (empty($startdate)) {
                              echo ("enter start date");
                              exit();
                         }
                         if (empty($enddate)) {
                              echo ("enter end date");
                              exit();
                         }
                         // Insert into discount_date_range table first
                         $dateInsert = Databases::IUD("INSERT INTO `discount_date_range` (`start_date`, `end_date`) 
                        VALUES ('" . $startdate . "', '" . $enddate . "');");

                         // Get the last inserted ID (discount_date_range_id)
                         $discountDateRangeId = $dateInsert;

                         // Insert into discount_date_range_has_product
                         Databases::IUD("INSERT INTO `discount_date_range_has_product`
                        (`discount_pre`, `discount_date_range_id`, `discount_group_id`, `qty`, `batch_id`) 
                        VALUES ('" . $EpercentageInput . "', '" . $discountDateRangeId . "', '" . $discount_id . "', '" . $qty . "', '" . $batch_id . "');");
                         echo "Updated";
                    }
               }
          }
     }
}
