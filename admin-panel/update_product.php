<?php
session_start();

if (isset($_SESSION["a"])) {
     include "db.php";

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $productId = $_POST["id"];
          $productTitle = $_POST["title"];
          $productCategory = $_POST["category"];
          $productGroup = $_POST["group"];
          $productSubcategory = $_POST["subcategory"];
          $productCondition = $_POST["condition"];
          $productStatus = $_POST["status"];
          $productWeight = $_POST["weight"];
          $productDescription = $_POST["description"];
          $brand = $_POST["brand"];

          if (strlen($productTitle) > 100) {
               echo ("Title length is too big");
          } else if (strlen($productDescription) > 1000) {
               echo ("Description length is too big");
          } else if (strlen($productWeight) > 6) {
               echo ("productWeight length is too big");
          } else {
               //
               $cat = Databases::Search("SELECT * FROM `category` WHERE `id`='" . $productCategory . "' AND `group_id`='" . $productGroup . "' ");
               $catnum = $cat->num_rows;
               if ($catnum == 1) {
                    $subcat = Databases::Search("SELECT * FROM `sub_category` WHERE `id`='" . $productSubcategory . "' AND `category_id`='" . $productCategory . "' ");
                    $subcatnum = $subcat->num_rows;
                    if ($subcatnum == 1) {
                         //
                         Databases::IUD("UPDATE `product` SET
                         `title` = '" . $productTitle . "', `description` = '" . $productDescription . "', 
                         `condition_id` = '" . $productCondition . "', `status_id` = '" . $productStatus . "', `weight` = '" . $productWeight . "', `sub_category_id` = '" . $productSubcategory . "',
                          `brand_id` = '" . $brand . "'
                         WHERE (`id` = '" . $productId . "');");

                         $uploadDir = "product_image/";
                         $maxSize = 5 * 1024 * 1024; // 5 MB
                         
                         $image1status = 0;
                         $image2status = 0;
                         $image3status = 0;
                         
                         // Handle Image 1
                         if (isset($_FILES["img1"]) && $_FILES["img1"]["size"] > 0 && $_FILES["img1"] != 0) {
                             $imageName1 = $_FILES["img1"]["name"];
                             $imagePath1 = $uploadDir . basename($imageName1);
                             $imageSize1 = $_FILES["img1"]["size"];
                             
                             if ($imageSize1 <= $maxSize) {
                                 $livepath = Databases::Search("SELECT * FROM `picture` WHERE `product_id` = '$productId' AND `name` = 'Image 1' ");
                                 $livepathdata = $livepath->fetch_assoc();
                                 $piclivepath = $livepathdata["path"];
                                 
                                 if (file_exists($piclivepath)) {
                                     unlink($piclivepath);
                                 }
                                 
                                 if (move_uploaded_file($_FILES["img1"]["tmp_name"], $imagePath1)) {
                                     $image1status = 1;
                                     Databases::IUD("UPDATE `picture` SET `path` = '$imagePath1' WHERE `product_id` = '$productId' AND `name` = 'Image 1'");
                                 }
                             } else {
                                 echo "Image 1 exceeds the maximum file size of 5MB.";
                             }
                         }
                         
                         // Handle Image 2
                         if (isset($_FILES["img2"]) && $_FILES["img2"]["size"] > 0 && $_FILES["img2"] != 0) {
                             $imageName2 = $_FILES["img2"]["name"];
                             $imagePath2 = $uploadDir . basename($imageName2);
                             $imageSize2 = $_FILES["img2"]["size"];
                             
                             if ($imageSize2 <= $maxSize) {
                                 $livepath = Databases::Search("SELECT * FROM `picture` WHERE `product_id` = '$productId' AND `name` = 'Image 2' ");
                                 $livepathdata = $livepath->fetch_assoc();
                                 $piclivepath = $livepathdata["path"];
                                 
                                 if (file_exists($piclivepath)) {
                                     unlink($piclivepath);
                                 }
                                 
                                 if (move_uploaded_file($_FILES["img2"]["tmp_name"], $imagePath2)) {
                                     $image2status = 1;
                                     Databases::IUD("UPDATE `picture` SET `path` = '$imagePath2' WHERE `product_id` = '$productId' AND `name` = 'Image 2'");
                                 }
                             } else {
                                 echo "Image 2 exceeds the maximum file size of 5MB.";
                             }
                         }
                         
                         // Handle Image 3
                         if (isset($_FILES["img3"]) && $_FILES["img3"]["size"] > 0 && $_FILES["img3"] != 0) {
                             $imageName3 = $_FILES["img3"]["name"];
                             $imagePath3 = $uploadDir . basename($imageName3);
                             $imageSize3 = $_FILES["img3"]["size"];
                             
                             if ($imageSize3 <= $maxSize) {
                                 $livepath = Databases::Search("SELECT * FROM `picture` WHERE `product_id` = '$productId' AND `name` = 'Image 3' ");
                                 $livepathdata = $livepath->fetch_assoc();
                                 $piclivepath = $livepathdata["path"];
                                 
                                 if (file_exists($piclivepath)) {
                                     unlink($piclivepath);
                                 }

                                 if (move_uploaded_file($_FILES["img3"]["tmp_name"], $imagePath3)) {
                                     $image3status = 1;
                                     Databases::IUD("UPDATE `picture` SET `path` = '$imagePath3' WHERE `product_id` = '$productId' AND `name` = 'Image 3'");
                                 }
                             } else {
                                 echo "Image 3 exceeds the maximum file size of 5MB.";
                             }
                         }
                         

                         if ($image1status == 1 && $image2status == 1 && $image3status == 1) {
                              echo 123;
                         } elseif ($image1status == 1 && $image2status == 1) {
                              echo 12;
                         } elseif ($image1status == 1 && $image3status == 1) {
                              echo 13;
                         } elseif ($image2status == 1 && $image3status == 1) {
                              echo 23;
                         } elseif ($image1status == 1) {
                              echo 1;
                         } elseif ($image2status == 1) {
                              echo 2;
                         } elseif ($image3status == 1) {
                              echo 3;
                         } else {
                              echo 0;
                         }
                    } else {
                         echo "Category and Sub Category do not match.";
                    }
               } else {
                    echo "Category and group do not match.";
               }
               //
          }
     }
}
