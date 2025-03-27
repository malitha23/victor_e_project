<?php
header('Content-Type: application/json');
require "../db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $title = trim($_POST['title'] ?? '');
     $description = trim($_POST['description'] ?? '');

     if (empty($title) || empty($description) || !isset($_FILES['file'])) {
          echo json_encode(["success" => false, "message" => "All fields are required."]);
          exit;
     }

     if (strlen($title) > 45) {
          echo json_encode(["success" => false, "message" => "Title must not exceed 45 characters."]);
          exit;
     }

     if (strlen($description) > 50) {
          echo json_encode(["success" => false, "message" => "Description must not exceed 50 characters."]);
          exit;
     }

     $file = $_FILES['file'];
     $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

     if (!in_array($file['type'], $allowedTypes)) {
          echo json_encode(["success" => false, "message" => "Only image files (JPEG, PNG, GIF, WEBP) are allowed."]);
          exit;
     }

     $uploadDir = 'display-img/';
     if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
     }

     $fileName = time() . '_' . basename($file['name']);
     $filePath = $uploadDir . $fileName;

     if (move_uploaded_file($file['tmp_name'], $filePath)) {
          $top = Databases::Search("SELECT * FROM `top_selling_add`");
          $topn = $top->num_rows;
          for ($i = 0; $i < $topn; $i++) {
               $topd = $top->fetch_assoc();
               Databases::IUD("DELETE FROM `top_selling_add` WHERE (`id` = '" . $topd["id"] . "')");
               $path =  $topd["path"];
               unlink($path);
          }
          Databases::IUD("INSERT INTO `top_selling_add` (`title`, `description`, `path`) 
          VALUES ('".$title."', '".$description."', '".$filePath."');");
          echo json_encode(["success" => true, "message" => "Advertisement uploaded successfully!", "file" => $filePath]);
     } else {
          echo json_encode(["success" => false, "message" => "File upload failed."]);
     }
} else {
     echo json_encode(["success" => false, "message" => "Invalid request."]);
}
