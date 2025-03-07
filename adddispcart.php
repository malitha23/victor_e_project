<?php
session_start();
include "connection.php";

if (isset($_SESSION["user_vec"])) {
     if (isset($_SESSION['cart'])) {
          unset($_SESSION['cart']); // Clear cart data if not set
      }
     if ($_SERVER["REQUEST_METHOD"] === "POST") {
          $batch_id = isset($_POST['batch_id']) ? intval($_POST['batch_id']) : 0;
          $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
          $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;

               if ($batch_id > 0 && $price > 0) {
                    $user_row = Database::Search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user_vec"]["email"] . "' ");
                    $user_num = $user_row->num_rows;
                    if ($user_num > 0) {
                         $user_data = $user_row->fetch_assoc();
                         $user_email = $user_data["email"];
                         if ($discount == 0) {
                              $discount = 0;
                              $c = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_email . "' AND `batch_id`='" . $batch_id . "' AND `discount`='" . $discount . "' ");
                              $cn = $c->num_rows;
                              if ($cn == 1) {
                                   $cd = $c->fetch_assoc();
                                   $qty = $cd["qty"] + 1;
                                   Database::IUD("UPDATE `victore`.`cart` SET `qty` = '" . $qty . "' WHERE (`id` = '" . $cd["id"] . "');");
                                   echo "cart is update";
                              } else {
                                   Database::IUD("INSERT INTO `victore`.`cart` (`qty`, `user_email`, `batch_id`, `discount`) 
                              VALUES ('1', '" . $user_email . "', '" . $batch_id . "', '" . $discount . "');");
                                   echo "cart is update";
                              }
                         } else {
                              $c = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_email . "' AND `batch_id`='" . $batch_id . "' AND `discount` > 0 ");
                              $cn = $c->num_rows;
                              if ($cn == 1) {
                                   $cd = $c->fetch_assoc();
                                   $qty = $cd["qty"] + 1;
                                   Database::IUD("UPDATE `victore`.`cart` SET `qty` = '" . $qty . "',`discount`='" . $discount . "' WHERE (`id` = '" . $cd["id"] . "');");
                                   echo "cart is update";
                              } else {
                                   Database::IUD("INSERT INTO `victore`.`cart` (`qty`, `user_email`, `batch_id`, `discount`) 
                              VALUES ('1', '" . $user_email . "', '" . $batch_id . "', '" . $discount . "');");
                                   echo "cart is update";
                              }
                         }
                    }
               } else {
                    echo ("Invalid data");
               }
          } else {
               echo ("Invalid request");
          }
     } else {
          $batch_id = isset($_POST['batch_id']) ? intval($_POST['batch_id']) : 0;
          $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
          $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;
          $ip_address = $_SERVER['REMOTE_ADDR'];
          $user_agent = $_SERVER['HTTP_USER_AGENT'];
          $device_id = hash('sha256', $user_agent . $ip_address);
          // Initialize session array if not set
          if (!isset($_SESSION["guest"])) {
               $_SESSION["guest"] = [];
          }
          $found = false;
          foreach ($_SESSION["guest"] as $order) {
               if ($order["device_id"] == $device_id) {
                    if ($order["batch_id"] == $batch_id) {
                         echo "Your item has already been added. Please view the cart.";
                         $found = true;
                         break; 
                    }
               }else{
                   echo "Error";
               }
          }
          if (!$found) {
               $orderData = [
                    "batch_id" => $batch_id,
                    "price" => $price,
                    "qty" => 1,
                    "discount" => $discount,
                    "ip_address" => $ip_address,
                    "device_id" => $device_id
               ];
               $_SESSION["guest"][] = $orderData; 
               echo "New item added to cart.";
          }
     }
} else {

     if ($_SERVER["REQUEST_METHOD"] === "POST") {
          // Retrieve batch_id, price, and discount from POST request
          $batch_id = isset($_POST['batch_id']) ? intval($_POST['batch_id']) : 0;
          $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;
          $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1; // Default qty to 1

          // Initialize cart and cart item ID counter if not set
          if (!isset($_SESSION['cart'])) {
               $_SESSION['cart'] = [];
               $_SESSION['cart_id_counter'] = 1; // Start ID from 1
          }

          // Check if item already exists in the cart (update qty if exists)
          $itemExists = false;
          foreach ($_SESSION['cart'] as &$item) {
               if ($item['batch_id'] == $batch_id) {
                    $item['qty'] += $qty; // Update quantity
                    $itemExists = true;
                    break;
               }
          }

          // If item does not exist, add new item with an auto-incrementing ID
          if (!$itemExists) {
               $_SESSION['cart'][] = [
                    'id' => $_SESSION['cart_id_counter'], // Assign auto-incrementing ID
                    'batch_id' => $batch_id,
                    'user_email' => '',
                    'qty' => $qty,
                    'discount' => $discount,
               ];
               $_SESSION['cart_id_counter']++; // Increment ID counter for next item
          }

          echo "Item added to cart successfully";
     } else {
          echo "Invalid request method";
     }

}
