<?php
require "../db.php";
// Check if the form data is set and valid
if (isset($_POST['title']) && isset($_POST['description']) && isset($_FILES['image'])) {
     $title = $_POST['title'];
     $description = $_POST['description'];
     $index = $_POST["index"];

     // Title and description validation
     if (strlen($title) > 45 || strlen($description) > 45) {
          echo 'Title and Description cannot exceed 45 characters.';
          exit;
     }

     // File upload validation
     $file = $_FILES['image'];
     $allowedFileTypes = ['image/jpeg', 'image/png', 'image/svg+xml']; // Allowed file types
     $uploadDir = 'display-img/'; // Set upload directory

     if (!in_array($file['type'], $allowedFileTypes)) {
          echo 'Invalid file type. Only JPG, PNG, and SVG images are allowed.';
          exit;
     }

     // Ensure the uploads directory exists
     if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0755, true);
     }

     // Generate a unique file name to avoid collisions
     $fileName = uniqid('advertisement_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

     // Move the uploaded file to the specified directory
     if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
          // Success response
          $add = Databases::Search("SELECT * FROM `advertisment` WHERE `add_p`='" . $index . "' ");
          $addnum = $add->num_rows;
          if ($addnum > 0) {
               $adddeata = $add->fetch_assoc();
               $path = $adddeata["path"];
               unlink($path);
               Databases::IUD("DELETE FROM `advertisment` 
          WHERE (`id` = '" . $adddeata["id"] . "');");
          }
          Databases::IUD("INSERT INTO `advertisment` (`path`, `title`, `description`, `add_p`) 
        VALUES ('" . $uploadDir . $fileName . "', '" . $title . "', '" . $description . "', '" . $index . "');");
          echo 'Advertisement uploaded successfully!';
     } else {
          // Error response
          echo 'Error uploading advertisement. Please try again.';
     }
} else {
     echo 'Invalid data.';
}
