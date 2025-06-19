<?php
// process/cashondelete.php

// 1. Include your database connection file
// Make sure this path is correct for your project structure
require_once '../db.php';

// 2. Check if the request method is POST and if the 'id' parameter exists
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // 3. Sanitize and validate the input
    // Always sanitize input to prevent SQL injection
    $orderId = (int)$_POST['id']; // Cast to integer for security

        Databases::IUD("DELETE FROM `cashond` WHERE  `id`='".$orderId."'  ;");

        echo "success";

    // 4. Execute the delete operation
    // Use a try-catch block to handle any exceptions that may occur

    try {
        
        
    } catch (PDOException $e) {
        // Catch any database connection or query execution exceptions
        error_log("PDO Exception during delete: " . $e->getMessage()); // Log the exception
        echo "error: database exception"; // Generic error for client
    }
} else {
    // If the request method is not POST or 'id' is missing
    echo "error: invalid request";
}

// 5. Important: Ensure no extra output before echo "success" or "error"
// Any extra spaces, newlines, or HTML before `echo` will break the JavaScript `req.responseText` check.
?>