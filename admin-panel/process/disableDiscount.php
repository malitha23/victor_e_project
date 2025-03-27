<?php
// Include your database connection file (adjust the path as necessary)
require "../db.php";

// Check if the discount_group_id is set in the POST request
if (isset($_POST['discount_group_id'])) {
     // Get the discount group ID from the POST request
     $discountGroupId = $_POST['discount_group_id'];
     $discountGroup = Databases::Search("SELECT * FROM `discount_group` WHERE `id`='" . $discountGroupId . "' ");
     $discountGroupnnum = $discountGroup->num_rows;
     if ($discountGroupnnum > 0) {
          $disgdata = $discountGroup->fetch_assoc();
          if ($disgdata["status"] == 1) {
               Databases::IUD("UPDATE `discount_group` SET 
               `status` = '0' WHERE (`id` = '" . $discountGroupId . "');
               ");
          } else {
               Databases::IUD("UPDATE `discount_group` SET 
               `status` = '1' WHERE (`id` = '" . $discountGroupId . "');
               ");
          }
          echo ("success");
     }
} else {
     // Return error if no discount group ID was provided
     echo 'error';
}

