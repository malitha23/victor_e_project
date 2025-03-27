<?php
// Include database connection
require "../db.php"; // Adjust path if needed

// Check if the discount group ID is provided
if (isset($_POST['discount_group_id']) && !empty($_POST['discount_group_id'])) {
     // Get the discount group ID from the request
     $discount_group_id = $_POST['discount_group_id'];

     $dhp = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $discount_group_id . "' ");
     $dhpn = $dhp->num_rows;
     for ($i = 0; $i <  $dhpn; $i++) {
          $dhpdata = $dhp->fetch_assoc();
          Databases::IUD("DELETE FROM `discount_date_range_has_product`
          WHERE (`id` = '" . $dhpdata["id"] . "')");
     }
     Databases::IUD("DELETE FROM `discount_group` WHERE (`id` = '" . $discount_group_id . "');");
     echo("success");
} else {
     // If no discount group ID is provided, return an error
     echo 'error';
}

// Close the database connection
