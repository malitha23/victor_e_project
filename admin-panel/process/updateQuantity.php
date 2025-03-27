<?php
session_start();
require "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     if (isset($_POST["batchId"], $_POST["discountGroupId"], $_POST["qty"])) {
          $batchId = intval($_POST["batchId"]);
          $discountGroupId = intval($_POST["discountGroupId"]);
          $qty = intval($_POST["qty"]);

          if ($qty < 1) {
               echo "Error: Quantity must be at least 1.";
               exit;
          }

          $bach = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $batchId . "' ");
          $bachnum = $bach->num_rows;
          if ($bachnum == 1) {
               $bachdata = $bach->fetch_assoc();
               if ($bachdata["batch_qty"] >= $qty) {
                    Databases::IUD("UPDATE `discount_date_range_has_product` SET
                     `qty` = '".$qty."' WHERE (`batch_id` = '".$batchId."' AND `discount_group_id`='".$discountGroupId."');");
               }
          }
          echo "Quantity updated successfully!";
     } else {
          echo "Error: Missing parameters.";
     }
} else {
     echo "Error: Invalid request method.";
}
