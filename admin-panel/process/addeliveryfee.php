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
               // Get POST data
               $tocity = isset($_POST['tocity']) ? trim($_POST['tocity']) : '';
               $d_price = isset($_POST['d_price']) ? trim($_POST['d_price']) : '';

               // Basic validation
               if (empty($tocity) || empty($d_price)) {
                    echo "Please fill in all required fields.";
                    exit;
               }

               if (!is_numeric($d_price)) {
                    echo "Delivery price must be a valid number.";
                    exit;
               }
               $result = Databases::Search("SELECT * FROM `delivery_fee` WHERE `fee`='" . $d_price . "' AND `city_city_id`='" . $tocity . "' ");
               $esultum = $result->num_rows;
               if ($esultum == 1) {
                    echo "Delivery price added old ready.";
                    exit;
               }
               $sre = Databases::Search("SELECT * FROM `delivery_fee`WHERE `city_city_id`='" . $tocity . "' ");
               $srenum = $sre->num_rows;
               if ($srenum == 1) {
                    Databases::IUD("UPDATE `victore`.`delivery_fee` 
                    SET `fee` = '" . $d_price . "' 
                    WHERE (`city_city_id` = '" . $tocity . "');");
               } else {
                    Databases::IUD("INSERT INTO `delivery_fee` (`fee`, `city_city_id`) 
                    VALUES ('" . $d_price . "', '" . $tocity . "');");
               }
               echo "Delivery fee for city '$tocity' has been successfully added!";
          } else {
               echo "Invalid request method.";
          }
     }
}
