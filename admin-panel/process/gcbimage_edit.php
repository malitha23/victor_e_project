<?php

require "../db.php"; // include your DB connection

// File handling setup
if (isset($_FILES["image"]["name"])) {
    $file = $_FILES["image"];
    $newPath = "uploads/" . uniqid() . "_" . $file["name"]; // save in uploads/ folder

    // Determine what was selected
    $groupId = $_POST["group_id"];
    $categoryId = $_POST["category_id"];
    $brandId = $_POST["brand_id"];

    if ($groupId) {
        // Get old image
        $result = Databases::Search("SELECT `image_path` FROM `group` WHERE `id` = '$groupId'");
        if ($result->num_rows == 1) {
            $old = $result->fetch_assoc();
            $oldPath = $old["image_path"];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        // Move and update
        move_uploaded_file($file["tmp_name"], $newPath);
        Databases::iud("UPDATE `group` SET `image_path` = '$newPath' WHERE `id` = '$groupId'");
        echo "Group image updated successfully.";
    } elseif ($categoryId) {
        $result = Databases::Search("SELECT `image_path` FROM `category` WHERE `id` = '$categoryId'");
        if ($result->num_rows == 1) {
            $old = $result->fetch_assoc();
            $oldPath = $old["image_path"];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        move_uploaded_file($file["tmp_name"], $newPath);
        Databases::iud("UPDATE `category` SET `image_path` = '$newPath' WHERE `id` = '$categoryId'");
        echo "Category image updated successfully.";
    } elseif ($brandId) {
        $result = Databases::Search("SELECT `img_path` FROM `brand` WHERE `id` = '$brandId'");
        if ($result->num_rows == 1) {
            $old = $result->fetch_assoc();
            $oldPath = $old["img_path"];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        move_uploaded_file($file["tmp_name"], $newPath);
        Databases::iud("UPDATE `brand` SET `img_path` = '$newPath' WHERE `id` = '$brandId'");
        echo "Brand image updated successfully.";
    } else {
        echo "No item selected to update.";
    }
} else {
    echo "No file uploaded.";
}

?>
