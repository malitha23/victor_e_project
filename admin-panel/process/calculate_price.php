<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $thisWeight = floatval($_POST["thisWeight"]);
    $thisPrice = floatval($_POST["thisPrice"]);
    $forWeight = floatval($_POST["forWeight"]);

    if ($thisWeight > 0 && $thisPrice > 0 && $forWeight > 0) {
        // Use proportion to calculate the price
        $forPrice = ($thisPrice / $thisWeight) * $forWeight;
        echo number_format($forPrice, 2); // Format result to 2 decimal places
    } else {
        echo "Invalid input";
    }
}
?>
