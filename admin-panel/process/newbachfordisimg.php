<?php
require "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["new_image"]) && isset($_POST["discountId"])) {
    $discountId = intval($_POST["discountId"]);
    $uploadDir = "uploads/";
    
    // Ensure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileName = basename($_FILES["new_image"]["name"]);
    $targetFilePath = $uploadDir . time() . "_" . $fileName;
    
    // Allowed file types
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    if (!in_array($fileType, $allowedTypes)) {
        die("Invalid file type! Only JPG, JPEG, PNG, and GIF are allowed.");
    }

    if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $targetFilePath)) {
        // Update the database
        $dg = Databases::Search("SELECT * FROM `discount_group` WHERE `id` = '". $discountId."' ");
        $dgd = $dg->fetch_assoc();
        unlink($dgd["image_path"]);
        Databases::Search("UPDATE `discount_group` SET `image_path` = 
        '".$targetFilePath."' WHERE (`id` = '". $discountId."');");
            echo "Image uploaded successfully!";
    } else {
        echo "Image upload failed! Please try again.";
    }
} else {
    echo "Invalid request!";
}
?>
