<?php
require_once("../db.php"); // Adjust as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subcats = json_decode($_POST["subcats"]);

    if (!empty($subcats)) {
        foreach ($subcats as $name) {
            try {
                Databases::iud("DELETE FROM `sub_category` WHERE `name` = '" . $name . "'");
                echo "Selected sub-categories deleted successfully.";
            } catch (\Throwable $th) {
                echo $name." "."Selected sub-categories deleted UN-successfully.";
            }
        }
    } else {
        echo "No sub-categories received.";
    }
} else {
    echo "Invalid request.";
}
