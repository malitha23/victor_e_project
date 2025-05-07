<?php
session_start();
require_once "connection.php"; // Ensure this file properly includes your Database class

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cartid"])) {
    $cartid = intval($_POST["cartid"]); // Ensure it is an integer
    $cartid = intval($_POST["cartid"]); // Ensure it is an integer

    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $cartid) {
                unset($_SESSION['cart'][$key]); // Remove item from cart
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the cart
                echo "Cart item deleted successfully";
                exit();
            }
        }
        echo "Cart item not found.";
    } else {
        echo "Cart is empty.";
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
