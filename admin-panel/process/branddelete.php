<?php
require_once '../db.php'; // Replace with your actual DB connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     if (!isset($_POST["brands"])) {
          echo "No data received.";
          exit;
     }
     $brandNames = json_decode($_POST["brands"], true);
     if (!is_array($brandNames) || count($brandNames) === 0) {
          echo "Invalid brand data.";
          exit;
     }
     foreach ($brandNames as $brand) {
          try {
               Databases::IUD("DELETE FROM `brand` WHERE `name` = '$brand'");
          } catch (\Throwable $th) {
              echo("can't delete this brand");
              exit;
          }
     }
     echo "Selected brand(s) deleted successfully.";
}
