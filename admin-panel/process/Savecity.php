<?php
session_start();

if (isset($_SESSION["a"])) {
    require "../db.php";
    
    $uemail = $_SESSION["a"]["username"];
    $query = "SELECT * FROM `admin` WHERE `username` = ?";
    $params = [$uemail];
    $types = "s";
    
    $u_detail = Databases::Search($query, $params, $types);

    if ($u_detail->num_rows == 1) {

        $length = isset($_POST["length"]) ? (int)$_POST["length"] : 0;
        $distric = isset($_POST["distric"]) ? (int)$_POST["distric"] : 0;

        if ($length <= 0 || $distric <= 0) {
            exit("Invalid input. Please select a district and add cities.");
        }

        $respon = 0;

        for ($i = 1; $i <= $length; $i++) {
            $city = isset($_POST["city" . $i]) ? trim($_POST["city" . $i]) : "";

            if (empty($city)) {
                exit("Enter city name.");
            }

            if (strlen($city) > 45) {
                exit("The city name must be less than 45 characters long.");
            }

            // Check if the city already exists
            $existingCity = Databases::Search(
                "SELECT * FROM `city` WHERE `name` = ?",
                [$city],
                "s"
            );

            if ($existingCity->num_rows > 0) {
                $cityRow = $existingCity->fetch_assoc();

                // Check if this city-district combination already exists
                $check = Databases::Search(
                    "SELECT * FROM `city_has_distric` WHERE `city_city_id` = ? AND `distric_distric_id` = ?",
                    [$cityRow["city_id"], $distric],
                    "ii"
                );

                if ($check->num_rows > 0) {
                    exit("You have previously added this city.");
                }

                $cityId = $cityRow["city_id"];
            } else {
                // Insert new city
                $cityId = Databases::IUD(
                    "INSERT INTO `city` (`name`) VALUES (?)",
                    [$city],
                    "s"
                );
            }

            // Link city to district
            Databases::IUD(
                "INSERT INTO `city_has_distric` (`city_city_id`, `distric_distric_id`) VALUES (?, ?)",
                [$cityId, $distric],
                "ii"
            );

            $respon++;
        }

        if ($respon > 0) {
            echo 1;
        }
    } else {
        exit("Unauthorized access.");
    }
} else {
    exit("Session expired. Please log in again.");
}
?>
