<?php
require_once "db.php";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"])) {
     $groupName = trim($_POST["name"]);
     if (empty($groupName)) {
          echo ( "Group name cannot be empty");
     }elseif( strlen($groupName)>45){
          echo ( "Group name cannot store 45 charactores");
     }else{
          Databases::SetupConnection();
          $query = "INSERT INTO `group` (group_name) VALUES (?)";
          $params = [$groupName];
          $types = "s";
          $result = Databases::IUD($query, $params, $types);
          if ($result) {
               echo ("Group added successfully");
          } else {
               echo ("Failed to add group");
          }
          Databases::CloseConnection(); 
     }
} else {
     echo ("Invalid request");
}
