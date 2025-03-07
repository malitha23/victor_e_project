<?php
session_start();

if (isset($_SESSION["a"])) {
     include "db.php";
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

          // Get the submitted form data
          $subCategory = isset($_POST['subCategory']) ? $_POST['subCategory'] : '';
          $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';

          // Validate the inputs
          if (empty($subCategory)) {
               echo "Subcategory name is required.";
               exit;
          }

          if ($categoryId == 0) {
               echo "Please select a valid category.";
               exit;
          }
          if (strlen($subCategory) > 45) {
               echo "Subcategory name is long.";
               exit;
          }
          $res = Databases::Search("SELECT * FROM `sub_category` WHERE `category_id`='".$categoryId."' AND `name`='".$subCategory."' ");
          $res_num =$res->num_rows;
          if($res_num == 1){
               echo "The subcategory name has already been added."; 
          }else{
               Databases::IUD("INSERT INTO `sub_category` (`category_id`, `name`) 
               VALUES ('" . $categoryId . "', '" . $subCategory . "');");
               echo "Subcategory added successfully.";
          }
     }
}
