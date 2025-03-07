<?php
require_once "db.php";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["category"])) {
     $categoryName = trim($_POST["category"]);
     $groupid = trim($_POST["groupid"]);
     if ($groupid == 0) {
          echo ("select product group");
     } else if (strlen($categoryName) > 45) {
          echo ("Category name cannot exceed 45 characters");
     } else if (empty($categoryName)) {
          echo ("Category name cannot be empty");
     } else {
          Databases::SetupConnection();
          $query = "INSERT INTO category (name, group_id) VALUES (?, ?)";
          $params = [$categoryName, $groupid];
          $types = "si"; // 's' for string (category name), 'i' for integer (group_id)

          $result = Databases::IUD($query, $params, $types);

          if ($result) {
               echo ("Category added successfully");
          } else {
               echo ( "Failed to add category");
          }
          Databases::CloseConnection();
     }
} else {
     echo ("Invalid request");
}
