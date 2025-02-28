<?php
session_start();
include "connection.php";
if (isset($_SESSION["user_vec"])) {
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
     echo "REJISTER FIRST";
?>
     <script>
          window.location = "register.php";
     </script>
<?php
}
