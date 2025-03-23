<?php
session_start();
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["action"]) && $data["action"] === "logout") {
    // Destroy session and clear user data
    $_SESSION = [];
    session_destroy();

    echo json_encode(["status" => "success"]);
    exit;
}

echo json_encode(["status" => "error"]);
exit;
?>
