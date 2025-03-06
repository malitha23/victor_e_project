<?php
include "../connection.php"; // Include your DB connection

if (isset($_GET['city'])) {
    $city = trim($_GET['city']);

    // Fetch city_id
    $cityQuery = Database::Search("SELECT `city_id`, `name` FROM `city` WHERE `name` = '" . $city . "'");
    if ($cityQuery->num_rows > 0) {
        $cityData = $cityQuery->fetch_assoc();
        $city_id = $cityData['city_id'];

        // Fetch delivery fee using city_id
        $feeQuery = Database::Search("SELECT `fee` FROM `delivery_fee` WHERE `city_city_id` = '" . $city_id . "'");
        if ($feeQuery->num_rows > 0) {
            $feeData = $feeQuery->fetch_assoc();
            $fee = $feeData['fee'];

            // Return JSON response
            echo json_encode(["success" => true, "city_id" => $city_id, "fee" => $fee]);
            exit();
        }
    }

    echo json_encode(["success" => false, "message" => "City not found"]);
    exit();
}
?>
