<?php
header('Content-Type: application/json');

// Include database connection
require "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Get the privacy policy text from the request
     $privacy = isset($_POST['privacy']) ? trim($_POST['privacy']) : '';

     // Validate input
     if (empty($privacy)) {
          echo json_encode(["success" => false, "message" => "Privacy policy cannot be empty."]);
          exit;
     }
     $m = Databases::Search("SELECT * FROM `privacy`");
     $mn = $m->num_rows;
     for ($i=0; $i < $mn; $i++) { 
         $md = $m->fetch_assoc();
         Databases::IUD("DELETE FROM `privacy` WHERE (`id` = '".$md["id"]."');");
     }
     // Save the privacy policy to the database
     Databases::IUD("INSERT INTO `privacy` (`Privacy`) VALUES ('" . $privacy . "');");
     echo json_encode(["success" => true, "message" => "Privacy policy saved successfully!"]);
} else {
     echo json_encode(["success" => false, "message" => "Invalid request."]);
}
