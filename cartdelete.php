<?php
session_start();
require_once "connection.php"; // Ensure this file properly includes your Database class

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cartid"])) {
    $cartid = intval($_POST["cartid"]); // Ensure it is an integer
if(isset($_SESSION["cart"])){
    unset($_SESSION['cart']); // Clear cart data if not set
    echo "Cart item deleted successfully";
    exit();
}
    // Check if the cart item exists before deleting
    $checkQuery = "SELECT id FROM cart WHERE id = $cartid";
    $checkResult = Database::Search($checkQuery);

    if ($checkResult->num_rows === 0) {
        echo "Cart item not found";
        exit;
    }

    // Delete the cart item securely
    $deleteQuery = "DELETE FROM cart WHERE id = ?";
    $deleteStatus = Database::IUD($deleteQuery, [$cartid], "i");

    if ($deleteStatus) {
        echo "Cart item deleted successfully";
    } else {
        echo "Failed to delete item";
    }
} else {
    echo "Invalid request";
}
?>
