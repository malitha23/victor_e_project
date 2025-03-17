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
               $lenth = $_POST["length"];

               //
               $title = $_POST["title"];
               $desc = $_POST["desc"];
               $discount = $_POST["Discount"];
               $start_date = $_POST["start_date"];
               $end_date = $_POST["end_date"];

               // Title Validation
               if (empty($title)) {
                    echo "Please enter a title";
               } elseif (strlen($title) > 25) {
                    echo "Title length is over, only 25 characters allowed";
               }
               // Description Validation
               elseif (empty($desc)) {
                    echo "Please enter a description";
               } elseif (strlen($desc) > 45) {
                    echo "Description length is over, only 30 characters allowed";
               }
               elseif (empty($discount)) {
                    echo "Please enter discount percentage";
               } elseif (!is_numeric($discount) || $discount < 0 || $discount > 100) {
                    echo "Discount percentage must be between 0 and 100";
               }
               // Date Validation
               elseif (empty($start_date) || empty($end_date)) {
                    echo "Please enter both start and end dates";
               } elseif ($start_date > $end_date) {
                    echo "End date must be later than start date";
               }
               // Validation Passed
               else {
                    $drlid = Databases::IUD("INSERT INTO `discount_date_range` (`start_date`, `end_date`)
                     VALUES ('" . $start_date . "', '" . $end_date . "');");
                    $idg = Databases::IUD("INSERT INTO `discount_group`
                               (`title`, `description`, `status`) 
                              VALUES ('" . $title . "', '" . $desc . "', '1');");
                    for ($i = 0; $i < $lenth; $i++) {
                         $batch = $_POST["batch" . $i];
                         $qty  = $_POST["qty" . $i];
                         if (empty($qty)) {
                              echo "Please enter quantity";
                         } elseif (!is_numeric($qty) || $qty <= 0) {
                              echo "Quantity must be a positive number";
                         } else {
                              Databases::IUD("INSERT INTO `discount_date_range_has_product`
                               (`discount_date_range_id`, `discount_pre`, `discount_group_id`, `qty`, `batch_id`) 
                              VALUES ('" . $drlid . "', '" . $discount . "', '".$idg."', '" . $qty . "', '" . $batch . "');");
                         }
                    }
               }
               //
          }
     }
}
