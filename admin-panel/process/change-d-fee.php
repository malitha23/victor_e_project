<?php

require "../db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through all received data (each city_id and its corresponding fee)

    if (isset($_SESSION["a"])) {

        $uemail = $_SESSION["a"]["username"];

        $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

        if ($u_detail->num_rows == 1) {

            foreach ($_POST as $city_id => $fee) {
                // Ensure fee is not empty and is a valid number
                if (!empty($fee) && is_numeric($fee)) {
                    $fee = (float)$fee;  // Cast fee to float for safety
                    $city_id = (int)$city_id;  // Cast city_id to integer for safety

                    // Check if the city_city_id already exists in the delivery_fee table
                    $checkQuery = "SELECT * FROM delivery_fee WHERE city_city_id = ?";
                    $existingCity = Databases::Search($checkQuery, [$city_id], 'i');

                    if ($existingCity->num_rows > 0) {
                        // If the city_id exists, update the fee
                        $updateQuery = "UPDATE delivery_fee SET fee = ? WHERE city_city_id = ?";
                        Databases::IUD($updateQuery, [$fee, $city_id], 'di');
                    } else {
                        // If the city_id does not exist, insert a new row
                        $insertQuery = "INSERT INTO delivery_fee (city_city_id, fee) VALUES (?, ?)";
                        Databases::IUD($insertQuery, [$city_id, $fee], 'id');
                    }
                } else {
                    // If the fee is empty or not numeric, alert an error (optional)
                    echo "Invalid fee value for city ";
                    return;
                }
            }
            
            echo "1";

        } else {
            echo "Error";
        };
    } else {
        echo "Error";
    }
} else {
    echo "Invalid request.";  // Error message for invalid requests
}



?>