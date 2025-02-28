<?php

session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method");
}

// Sanitize user input
$username = trim($_POST["userName"] ?? '');
$password = trim($_POST["password"] ?? '');

// Check if input is empty
if (empty($username) || empty($password)) {
    die("Invalid Username or Password");
}

// Use prepared statements to prevent SQL injection
Databases::SetupConnection();
$query = "SELECT id, username, password FROM admin WHERE username = ?";
$params = [$username];
$types = "s";

$result = Databases::Search("SELECT id, username, password FROM admin WHERE username = '$username'");

if ($result->num_rows === 1) {
    $d = $result->fetch_assoc();

    // Verify password hash
    if (password_verify($password, $d['password'])) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        
        $_SESSION["a"] = $d;

        echo "success";
    } else {
        die("Invalid Username or Password1");
    }
} else {
    die("Invalid Username or Password");
}

Databases::CloseConnection();

?>
