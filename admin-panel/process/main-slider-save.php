<?php
require "../db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $uploadDir = 'display-img/';

     // Ensure upload directory exists
     if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
     }

     // Allowed file types
     $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

     // Process main image
     
     // Process sub image
     if (isset($_FILES['sub_image']) && in_array($_FILES['sub_image']['type'], $allowedTypes)) {
          $subImageName = uniqid('sub_', true) . "." . pathinfo($_FILES['sub_image']['name'], PATHINFO_EXTENSION);
          $subPath = $uploadDir . $subImageName;

          if (!move_uploaded_file($_FILES['sub_image']['tmp_name'], $subPath)) {
               echo ("Error uploading sub image.");
               exit;
          }
     } else {
          echo ("Invalid sub image format.");
          exit;
     }

     // Store title & description
     $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
     $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
     $index = htmlspecialchars($_POST['index'], ENT_QUOTES, 'UTF-8');

     if (strlen($title) > 45) {
          exit("Error: Title length exceeds 45 characters.");
      } else if (strlen($description) > 45) {
          exit("Error: Description length exceeds 45 characters.");
      }
      

     $slider = Databases::Search("SELECT * FROM  `main_slider` WHERE `slider`='" . $index . "' ");
     $slidernum = $slider->num_rows;
     if ($slidernum > 0) {
          for ($i = 0; $i < $slidernum; $i++) {
               $sliderdata = $slider->fetch_assoc();
               if (!empty($sliderdata["main_path"])) {
                    $mainp = $sliderdata["main_path"];
                    unlink($mainp);
               }
               if (!empty($sliderdata["sub_path"])) {
                    $sainp = $sliderdata["sub_path"];
                    unlink($sainp);
               }
          }
          Databases::IUD("DELETE FROM `main_slider` WHERE (`slider` = '" . $index . "');");
     }

     Databases::IUD("INSERT INTO `main_slider` (`main_path`, `sub_path`, `title`, `description`, `slider`)
      VALUES ('0', '" . $subPath . "', '" . $title . "', '" . $description . "', '" . $index . "');");

     echo  "images and details uploade successfully.";
}
