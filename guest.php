<?php
session_start();
include "connection.php";
$guest_id = uniqid('guest_', true);
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$session_token = bin2hex(random_bytes(16));
$visit_time = date("Y-m-d H:i:s");
$referrer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct';
$device_id = hash('sha256', $user_agent . $ip_address);
$guess = Database::Search("SELECT * FROM `guess` WHERE `device_id`='" . $device_id . "' ");
$guess_num = $guess->num_rows;
if ($guess_num == 1) {
     $guess_data = $guess->fetch_assoc();
     $nowvisit_time = strtotime(date("Y-m-d H:i:s"));
     $befoervisit_time = strtotime($guess_data["visit_time"]);
     $timeDistance = $nowvisit_time - $befoervisit_time;
     Database::IUD("UPDATE `guess` SET `visit_time` = '" . $visit_time . "' 
          WHERE (`id` = '" . $guess_data["id"] . "');");
     $person = [
          "guest_id" => $guess_data["id"],
          "age" => 25,
          "email" => "john@example.com"
     ];
     $_SESSION["guess".$device_id] = "JaneDoe";
} else {
     Database::IUD("INSERT INTO `guess` (`id`, `ip_address`, ` user_agent`, ` session_token`, `visit_time`, `referrer_url`, `device_id`) 
VALUES ('" . $guest_id . "', '" . $ip_address . "', '" . $user_agent . "', '" . $session_token . "', '" . $visit_time . "', '" . $referrer_url . "', '" . $device_id . "');");
}
