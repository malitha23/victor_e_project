<?php
require "../db.php"; // include your DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["groups"])) {
     $groupArray = json_decode($_POST["groups"], true);

     if (!empty($groupArray)) {
          foreach ($groupArray as $groupName) {
               try {
                    Databases::iud("DELETE FROM `group` WHERE `group_name` = '" . $groupName . "'");
               } catch (\Throwable $th) {
                    echo ("can't delete this group");
                    exit;
               }
          }
          echo "Selected groups deleted successfully.";
     } else {
          echo "No groups selected.";
     }
} else {
     echo "Invalid request.";
}
