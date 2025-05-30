<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    require_once '../db.php';


    $status = $_POST['status'];
    $id = $_POST["id"];
    try {
        Databases::Search("UPDATE `cashond` SET `cashon_status_id` = '" . $status . "' WHERE (`id` = '".$id."');");
    } catch (\Throwable $th) {
        echo ("problem");
        exit();
    }

    echo "success";
    exit;
}
