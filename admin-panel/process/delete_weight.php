<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["weightId"])) {
     $weightId = intval($_POST["weightId"]);

     require "../db.php";

     $delete = Databases::IUD("DELETE FROM `delivery_fee_for_weight` WHERE `id` = '$weightId'");

     echo "Weight entry deleted successfully.";
}
