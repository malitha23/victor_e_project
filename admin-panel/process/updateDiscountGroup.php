<?php
// Assuming you already have a database connection set up
require "../db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $title = $_POST['title'];
     $description = $_POST['description'];
     $discount_pre = $_POST['discount_pre'];
     $discount_group_id = $_POST['discount_group_id'];

     Databases::IUD("UPDATE `discount_group` SET
      `title` = '".$title."', `description` = '".$description."' 
     WHERE (`id` = '".$discount_group_id."');");
     $phd = Databases::Search("SELECT * FROM `discount_date_range_has_product`
      WHERE `discount_group_id`='".$discount_group_id."' ");
      $phdn = $phd->num_rows;
      for ($i=0; $i < $phdn; $i++) { 
        $phpdata = $phd->fetch_assoc();
        Databases::IUD("UPDATE `discount_date_range_has_product` SET `discount_pre` = '".$discount_pre."' WHERE (`id` = '".$phpdata["id"]."');");
      }
     echo 'Success';
}
