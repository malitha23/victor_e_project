<?php
session_start();
if (isset($_SESSION["a"])) {
     include "db.php";

     if ($_SERVER["REQUEST_METHOD"] === "POST") {
          $batchId = $_POST["batch_id"];
          $batchCode = $_POST["batchcode"];
          $vendor = $_POST["vendor"];
          $batchQty = $_POST["batchqty"];
          $sellPrice = $_POST["sellprice"];
          $batchPrice = $_POST["batchprice"];

          if (empty($batchId) || empty($batchCode) || empty($vendor) || empty($batchQty) || empty($sellPrice) || empty($batchPrice)) {
               echo "Please fill in all required fields.";
               exit;
          }
          Databases::IUD("UPDATE `victore`.`batch` SET 
          `batch_code` = '".$batchCode."', `vendor_name` = '".$vendor."', `batch_price` = '".$batchPrice."', 
          `selling_price` = '".$sellPrice."', `batch_qty` = '".$batchQty."' 
          WHERE (`id` = '".$batchId."');");
          echo "success";
     }
}
