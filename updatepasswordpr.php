<?php
header('Content-Type: application/json');
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verificationCode = $_POST['verificationCode'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $email = $_POST["email"] ?? '';

    // Validate email input
    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Email is required.']);
        exit;
    }

    // Validate other inputs
    if (empty($verificationCode) || empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Check for valid password length
    if (strlen($newPassword) > 16) {
        echo json_encode(['success' => false, 'message' => 'Password is too long.']);
        exit;
    }
     // Check for valid password length
     if (strlen($newPassword) < 5) {
          echo json_encode(['success' => false, 'message' => 'Password is too small.']);
          exit;
      }

    // Fetch user data based on email
    $row = Database::Search("SELECT * FROM `user` WHERE `email` = '" . $email . "' ");
    if ($row->num_rows > 0) {
        $row_data = $row->fetch_assoc();
        // Verify the code
        if ($row_data["v_code"] == $verificationCode) {
            Database::IUD("UPDATE `user` SET `password` = '" . $newPassword . "' WHERE `email` = '" . $email . "';");
            echo json_encode(['success' => true, 'message' => 'Password updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid verification code.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not found.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
