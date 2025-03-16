<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     include "db.php";
     // Get data from FormData
     $title = $_POST["title"];
     $desc = $_POST["description"];
     $batch = $_POST["batch"];
     $qty = $_POST["qty"];
     $discount = $_POST["discount"];
     $start_date = $_POST["start_date"];
     $end_date = $_POST["end_date"];

     // Title Validation
     if (empty($title)) {
          echo "Please enter a title";
     } elseif (strlen($title) > 25) {
          echo "Title length is over, only 25 characters allowed";
     }
     // Description Validation
     elseif (empty($desc)) {
          echo "Please enter a description";
     } elseif (strlen($desc) > 30) {
          echo "Description length is over, only 30 characters allowed";
     }
     // Batch Validation
     elseif (empty($batch)) {
          echo "Please enter a batch";
     }
     // Quantity Validation
     elseif (empty($qty)) {
          echo "Please enter quantity";
     } elseif (!is_numeric($qty) || $qty <= 0) {
          echo "Quantity must be a positive number";
     }
     // Discount Validation
     elseif (empty($discount)) {
          echo "Please enter discount percentage";
     } elseif (!is_numeric($discount) || $discount < 0 || $discount > 100) {
          echo "Discount percentage must be between 0 and 100";
     }
     // Date Validation
     elseif (empty($start_date) || empty($end_date)) {
          echo "Please enter both start and end dates";
     } elseif ($start_date > $end_date) {
          echo "End date must be later than start date";
     }
     // Validation Passed
     else {
          //
          $idg = Databases::IUD("INSERT INTO `discount_group`
           (`title`, `description`, `status`) 
          VALUES ('" . $title . "', '" . $desc . "', '1');");
          $idddr = Databases::IUD("INSERT INTO `discount_date_range` (`start_date`, `end_date`) 
          VALUES ('2025-03-20', '2025-04-20');");
          Databases::IUD("INSERT INTO `discount_date_range_has_product`
           (`discount_date_range_id`, `discount_pre`, `discount_group_id`, `qty`, `batch_id`)
           VALUES ('" . $idddr . "', '" . $discount . "', '" . $idg . "', '" . $qty . "', '" . $batch . "');");
          //
          $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/svg+xml"];
          $max_size = 3 * 1024 * 1024;

          if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

               $image_name = $_FILES["image"]["name"];
               $image_tmp = $_FILES["image"]["tmp_name"];
               $image_type = $_FILES["image"]["type"];
               $image_size = $_FILES["image"]["size"];
               $image_folder = "discount/";
               $image_path = $image_folder . $image_name;

               // Check file type
               if (!in_array($image_type, $allowed_types)) {
                    echo "Invalid file type. Only JPEG, JPG, PNG, and SVG are allowed.<br>";
                    exit();
               }

               // Check file size
               if ($image_size > $max_size) {
                    echo "File size exceeds the 3MB limit.<br>";
                    exit();
               }

               // Move the file to the discount directory
               if (move_uploaded_file($image_tmp, $image_path)) {
                    echo "1";
                    // Make sure to sanitize the $idg before using it in a query
                    $idg = intval($idg);
                    // Save the image path to the database
                    Databases::IUD("UPDATE `discount_group` SET `image_path` = '" . $image_path . "' WHERE `id` = '" . $idg . "';");
               } else {
                    echo "Failed to upload the image.";
               }
          } else {
               echo "0";
          }
          echo "1";
     }
} else {
     echo "Invalid Request.";
}
