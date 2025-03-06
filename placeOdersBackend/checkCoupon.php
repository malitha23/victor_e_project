<?php
session_start();

require_once '../connection.php'; // Include your database connection

if (isset($_GET['code'])) {
    $couponCode = trim($_GET['code']);
    $currentDate = date("Y-m-d"); // Get current date

    $query = "SELECT `dis_percentage`, `status`, `user_email`, `start_date`, `end_date` FROM `coupon` WHERE `code` = '" . $couponCode . "'";
    $stmt = Database::Search($query);

    if ($stmt->num_rows > 0) {
        $row = $stmt->fetch_assoc();
        $isUserSpecific = !empty($row['user_email']);

        if (!$isUserSpecific) { // General coupon
            if ($row['status'] == 0) {
                echo json_encode(["success" => false, "message" => "Coupon is inactive"]);
            } elseif ($currentDate < $row['start_date']) {
                echo json_encode(["success" => false, "message" => "Coupon is not yet valid"]);
            } elseif ($currentDate > $row['end_date']) {
                echo json_encode(["success" => false, "message" => "Coupon has expired"]);
            } else {
                echo json_encode(["success" => true, "discount" => $row['dis_percentage']]);
            }
        } else { // User-specific coupon
            if (!isset($_SESSION["user_vec"])) {
                echo json_encode(["success" => false, "message" => "You need to be logged in to use this coupon"]);
            } else {
                $email = $_SESSION["user_vec"]["email"];
                if ($row['user_email'] !== $email) {
                    echo json_encode(["success" => false, "message" => "This coupon is not assigned to your account"]);
                } elseif ($row['status'] == 0) {
                    echo json_encode(["success" => false, "message" => "Coupon is inactive"]);
                } elseif ($currentDate < $row['start_date']) {
                    echo json_encode(["success" => false, "message" => "Coupon is not yet valid"]);
                } elseif ($currentDate > $row['end_date']) {
                    echo json_encode(["success" => false, "message" => "Coupon has expired"]);
                } else {
                    echo json_encode(["success" => true, "discount" => $row['dis_percentage']]);
                }
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid coupon code"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No coupon code provided"]);
}
