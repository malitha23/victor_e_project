<?php
session_start();
if (isset($_SESSION["a"])) {
     if ($_SERVER["REQUEST_METHOD"] === "POST") {
          include "db.php";
          if (isset($_POST['email'])) {
               $email = $_POST['email'];

               $re = Databases::Search("SELECT * FROM `user` WHERE `email`='" . $email . "' ");
               $renum = $re->num_rows;
               if ($renum == 1) {
                    $redata = $re->fetch_assoc();
                    $delete = $redata["status"];
                    if ($delete == 1) {
                         Databases::IUD("UPDATE `user` SET `status` = '0'
                     WHERE (`email` = '" . $email . "'); ");
                         echo 0;
                    } else {
                         Databases::IUD("UPDATE `user` SET `status` = '1'
                     WHERE (`email` = '" . $email . "'); ");
                         echo 1;
                    }
               } else {
                    echo ("you are not user");
               }
          } else {
               http_response_code(400);
               echo "Email is required.";
          }
     }
}
