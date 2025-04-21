<?php
require "../db.php"; // Your database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["subcats"])) {
        echo "No sub-category data received.";
        exit;
    }

    $subcats = json_decode($_POST["subcats"], true);
    if (!is_array($subcats) || count($subcats) === 0) {
        echo "Invalid data.";
        exit;
    }

    foreach ($subcats as $subcatName) {
     try {
          Databases::IUD("DELETE FROM `sub_category` WHERE `name` = '$subcatName'");
     } catch (\Throwable $th) {
          echo("can't delete this");
          exit;
     }
    }

    echo "Selected sub-categories deleted successfully.";
} else {
    echo "Invalid request method.";
}
?>
