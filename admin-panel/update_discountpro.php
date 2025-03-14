<?php
session_start();

if (isset($_SESSION["a"])) {
     include "db.php";

     if ($_SERVER["REQUEST_METHOD"] == "POST") {

          // Retrieve data from the form
          $groupid = intval($_POST["groupid"]);
          $title = trim($_POST["title"]);
          $description = trim($_POST["description"]);
          $discountPre = trim($_POST["discountPre"]);
          $qty = trim($_POST["qty"]);
          $start_date = trim($_POST["start_date"]);
          $end_date = trim($_POST["end_date"]);

          // Validation
          if (empty($title)) {
               echo "Please enter a title.";
               exit();
          } elseif (strlen($title) > 25) {
               echo "Title length is over, only 25 characters allowed.";
               exit();
          }

          if (empty($description)) {
               echo "Please enter a description.";
               exit();
          } elseif (strlen($description) > 30) {
               echo "Description length is over, only 30 characters allowed.";
               exit();
          }

          if (empty($qty)) {
               echo "Please enter quantity.";
               exit();
          } elseif (!is_numeric($qty) || $qty <= 0) {
               echo "Quantity must be a positive number.";
               exit();
          }

          if (empty($discountPre)) {
               echo "Please enter discount percentage.";
               exit();
          } elseif (!is_numeric($discountPre) || $discountPre < 0 || $discountPre > 100) {
               echo "Discount percentage must be between 0 and 100.";
               exit();
          }

          if (empty($start_date) || empty($end_date)) {
               echo "Please enter both start and end dates.";
               exit();
          } elseif ($start_date > $end_date) {
               echo "End date must be later than start date.";
               exit();
          }

          // Update the discount group details in the database
          Databases::IUD("UPDATE `discount_group` SET `title`='" . $title . "', `description`='" . $description . "' WHERE `id`='" . $groupid . "'");

          // Update discount date range
          $ddrb = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $groupid . "'");
          $ddrbdeta = $ddrb->fetch_assoc();
          Databases::IUD("UPDATE `discount_date_range` SET `start_date`='" . $start_date . "', `end_date`='" . $end_date . "' WHERE `id`='" . $ddrbdeta["discount_date_range_id"] . "'");

          // Update discount percentage and quantity
          Databases::IUD("UPDATE `discount_date_range_has_product` SET `discount_pre`='" . $discountPre . "', `qty`='" . $qty . "' WHERE `discount_group_id`='" . $groupid . "'");

          $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/svg+xml"];
          $max_size = 3 * 1024 * 1024;

          if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {

               $image_name = $_FILES["image"]["name"];
               $image_tmp = $_FILES["image"]["tmp_name"];
               $image_type = $_FILES["image"]["type"];
               $image_size = $_FILES["image"]["size"];
               $image_folder = "discount/";
               $image_path = $image_folder . $image_name;

               if (!in_array($image_type, $allowed_types)) {
                    echo "Invalid file type. Only JPEG, JPG, PNG, and SVG are allowed.";
                    exit();
               }

               if ($image_size > $max_size) {
                    echo "File size exceeds the 3MB limit.";
                    exit();
               }
               $oldpath = Databases::Search("SELECT * FROM `discount_group` WHERE `id`='" . $groupid . "' ");
               $oldpathdeta = $oldpath->fetch_assoc();
               $imgpathold = $oldpathdeta["image_path"];
               if (move_uploaded_file($image_tmp, $image_path)) {
                    unlink($imgpathold);
                    Databases::IUD("UPDATE `discount_group` SET `image_path`='" . $image_path . "' WHERE `id`='" . $groupid . "'");
               } else {
                    echo "Failed to upload the image.";
                    exit();
               }
          }

          echo "success";
     } else {
          echo "Invalid request method.";
     }
} else {
     echo "Unauthorized access.";
}
