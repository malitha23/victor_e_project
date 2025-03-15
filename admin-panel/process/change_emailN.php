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
               $email = isset($_POST['email']) ? trim($_POST['email']) : '';
               $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';

               // Basic validation
               if (empty($email) || empty($mobile)) {
                    echo "Please fill in all required fields.";
                    exit;
               }

               if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "Invalid email format.";
                    exit;
               }

               if (!preg_match('/^\d+$/', $mobile)) {
                    echo "Mobile number must be a valid number.";
                    exit;
               }

               $r = Databases::Search("SELECT * FROM `contact`");
               $r = $r->num_rows;
               if ($r == 1) {
                    Databases::IUD("UPDATE `contact` SET `email` = '".$email."', `mobile` = '".$mobile."' 
                    WHERE (`id` = '1');");
               } else {
                    Databases::IUD("INSERT INTO `contact` (`email`, `mobile`)
          VALUES ('" . $email . "', '" . $mobile . "');");
               }
               // Example message for success
               echo "Your contact information has been successfully updated!";
          } else {
               echo "Invalid request method.";
          }
     }
}
