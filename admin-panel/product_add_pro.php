<?php
session_start();
require_once("db.php");
if (isset($_SESSION["a"])) {
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $title = $_POST["title"];
          $productGroup = $_POST["productGroup"];
          $category = $_POST["category"];
          $condition = $_POST["condition"];
          $status = $_POST["status"];
          $weight = $_POST["weight"];
          $description = $_POST["description"];
          $consignmentStock = $_POST["consignmentStock"];

          if (empty($title)) {
               echo "Please enter a title.";
           } elseif (strlen($title) > 100) {
               echo "Title must not exceed 100 characters.";
           } elseif ($productGroup == 0) {
               echo "Please select a product group.";
           } elseif ($category == 0) {
               echo "Please select a category.";
           } elseif ($condition == 0) {
               echo "Please select a condition.";
           } elseif ($status == 0) {
               echo "Please select a status.";
           } elseif (empty($weight)) {
               echo "Please enter the weight.";
           } elseif (!is_numeric($weight)) {
               echo "Weight must be a number.";
           } elseif (empty($description)) {
               echo "Please enter a description.";
           } elseif (strlen($description) > 1500) {
               echo "Description must not exceed 1500 characters.";
           } else {
               echo "Validation successful!";
           }
           
          // Image Upload Handling
          $targetDir = "product_image/";
          $img1 = $img2 = $img3 = null;

          if (!file_exists($targetDir)) {
               mkdir($targetDir, 0777, true);
          }

          function uploadImage($inputName, $targetDir)
          {
               if (!isset($_FILES[$inputName]) || $_FILES[$inputName]["error"] != 0) {
                    return null;
               }
               $fileName = time() . "_" . basename($_FILES[$inputName]["name"]);
               $targetFilePath = $targetDir . $fileName;
               if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                    return $fileName;
               }
               return null;
          }
          $product_id = 1;
          $img1 = uploadImage("img1", $targetDir);
          $img2 = uploadImage("img2", $targetDir);
          $img3 = uploadImage("img3", $targetDir);


          if ($img1 === null && $img2 === null && $img3 === null) {
               echo "No image uploaded";
          } else {
               $images = array_filter([$img1, $img2, $img3]);
               foreach ($images as $index => $img) {
                    $name = "Image " . ($index + 1);
                    Databases::IUD("INSERT INTO `picture` (`path`, `product_id`, `name`) 
        VALUES ('" . $img . "', '" . $product_id . "', '" . $name . "');");
               }
          }
     } else {
          echo "something else";
     }
} else {
}
