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
          $length = $_POST["length"];
          $distric = (int)$_POST["distric"];
          $cities = []; // Array to store city values
          $m = 1;
          $v = 0;
          $respon = 0;
          for ($i = 0; $i < $length; $i++) {
               $cities[] = $_POST["city" . $m];
               if (strlen($cities[$v]) > 45) {
                    $i = $length;
                    echo ("The city name is less than 45 characters long.");
               } elseif ($distric == 0) {
                    $i = $length;
                    echo ("Please select the district..");
               } elseif (empty($cities[$v])) {
                    echo ("enter city name");
                    $i = $length;
               } else {
                    $city = Databases::Search("SELECT * FROM `city` WHERE `name`='".$cities[$v]."'");
                    $citynum = $city->num_rows;
                    if($citynum > 0){
                         $citydeta = $city->fetch_assoc();
                         $chd = Databases::Search("SELECT * FROM `city_has_distric` WHERE 
                         `city_city_id`='".$citydeta["city_id"]."' AND `distric_distric_id`='".$distric."' ");
                         $chdnum = $chd->num_rows;
                         if($chdnum > 0){
                              echo("You have previously added to the city.");
                              exit();
                         }
                    }
                    $insid =  Databases::IUD("INSERT INTO `city` (`name`) 
                     VALUES ('" . $cities[$v] . "');");
                    Databases::IUD("INSERT INTO `city_has_distric` 
                    (`city_city_id`, `distric_distric_id`) VALUES ('" . $insid . "', '" . $distric . "');
                    ");
                    $respon = $respon + 1;
               }
               $v = $v + 1;
               $m = $m + 1;
          }
          if ($respon > 0) {
               echo 1;
          }
     }
}
