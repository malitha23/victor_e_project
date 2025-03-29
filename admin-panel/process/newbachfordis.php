<?php
require "../db.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $batch_id = $_POST["batch_id"];
     $discount_id = $_POST["discount_id"];
     $qty = $_POST["qty"];

     // Validate input
     if (!is_numeric($batch_id) || !is_numeric($discount_id) || !is_numeric($qty) || $qty < 1) {
          echo "Invalid input data.";
          exit;
     }
     $bach = Databases::Search("SELECT * FROM `batch`");
     $bachdata = $bach->fetch_assoc();
     // Example: Insert into discount batch table
     $dhd = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE 
     `discount_group_id`='" . $discount_id . "'  AND `batch_id`='" . $batch_id . "' ");
     $dhdnum = $dhd->num_rows;
     if ($dhdnum == 1) {
          $dhddata = $dhd->fetch_assoc();
          $fqty =  $dhddata["qty"] + $qty;
          if ($fqty > $bachdata["batch_qty"]) {
               echo ("Batch quantity is too large..");
          } else {
               Databases::IUD("UPDATE `discount_date_range_has_product` SET `qty` = '" . $fqty . "'
                WHERE (`id` = '" . $dhddata["id"] . "');");
               echo ("updated");
          }
     } else {
          if ($bachdata["batch_qty"] < $qty) {
               echo ("Batch quantity is too large..");
          } else {
               $secdrhp = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE 
          `discount_group_id`='" . $discount_id . "' ");
               $secdrhpddata = $secdrhp->fetch_assoc();
               if ($secdrhpddata) {
                    Databases::IUD("INSERT INTO `discount_date_range_has_product`
                    (`discount_date_range_id`, `discount_pre`, `discount_group_id`, `qty`, `batch_id`) 
                   VALUES ('" . $secdrhpddata["discount_date_range_id"] . "', '" . $secdrhpddata["discount_pre"] . "', '" . $discount_id . "', '" . $qty . "', '" . $batch_id . "');");
                    echo ("updated");
               }else{
                    echo ("you can't update but you cant delete this discount and add new");
               }
          }
     }
}
