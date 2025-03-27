<?php
// your-server-endpoint.php

// Assuming you've received the POST data
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validation functions for mobile and password
function validateMobile($mobile) {
    // Check if the mobile number is exactly 10 digits
    return preg_match('/^\d{10}$/', $mobile);
}

function validatePassword($password) {
    // Check if password contains at least one uppercase, one lowercase, and one number
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,16}$/', $password);
}

// Perform validation checks
if ($mobile && $email && $password) {
    // Check if the email is valid
    if (empty($email)) {
        echo "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } elseif (strlen($email) > 101) {
        echo "Email is too long";
    } // Check if the mobile number is valid
    elseif (empty($mobile)) {
        echo "Please enter your mobile number";
    } elseif (!validateMobile($mobile)) {
        echo "Invalid mobile number format. It should be 10 digits.";
    } // Check if the password is valid
    elseif (empty($password)) {
        echo "Password is empty";
    } elseif (strlen($password) > 16) {
        echo "Password is too long";
    } elseif (!validatePassword($password)) {
        echo "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
    } else {
        // If all validations pass, registration is successful
        echo 1;
    }
} else {
    // If any of the fields are empty
    echo "Please fill in all the fields.";
}
?>
