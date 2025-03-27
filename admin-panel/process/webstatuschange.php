<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     require "../db.php"; // Include database connection file

     $status = isset($_POST['status']) ? (int)$_POST['status'] : null;

     if ($status !== null) {
          $s = Databases::Search("SELECT * FROM `web_status`");
          $SN = $s->num_rows;
          for ($i = 0; $i <  $SN; $i++) {
               $sd = $s->fetch_assoc();
               Databases::IUD("DELETE FROM `web_status` WHERE (`id` = '" . $sd["id"] . "');");
          }
          $query = "INSERT INTO `web_status` (`status`) VALUES ('" . $status . "');";
          $result = Databases::IUD($query);
          if ($result) {
               echo json_encode(["success" => true, "message" => "Website status updated successfully!"]);
          } else {
               echo json_encode(["success" => false, "message" => "Failed to update website status."]);
          }
     } else {
          echo json_encode(["success" => false, "message" => "Invalid request."]);
     }
}
