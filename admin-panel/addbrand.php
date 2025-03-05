<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($_POST["name"]) && !empty(trim($_POST["name"]))) {
          $brandName = trim($_POST["name"]);

          // Validate brand name (e.g., prevent SQL injection if using a database)
          if (strlen($brandName) < 3) {
               echo "Brand name must be at least 3 characters long.";
               exit;
          }

          if (strlen($brandName) > 50) {
               echo "Brand name is long.";
               exit;
          }
          $brand = Databases::Search("SELECT * FROM `brand` WHERE `name`='".$brandName."' ");
          $brand_num = $brand->num_rows;
          if($brand_num == 1){
               echo "This brand is an old, ready-made insert.";
          }else{
               Databases::IUD("INSERT INTO `brand` (`name`) 
               VALUES('".$brandName."')");
               echo "Brand '$brandName' added successfully!";
          }
     } else {
          echo "Please enter a brand name.";
     }
} else {
     echo "Invalid request method.";
}
