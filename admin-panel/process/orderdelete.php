<?php
require "../db.php";
if (isset($_POST["status_id"])) {
     $id = intval($_POST["status_id"]);
     if ($id === 0) {
          echo "Invalid status ID.";
          exit;
     }
     try {
          Databases::IUD("DELETE FROM `order_status` WHERE (`id` = '" . $id . "');");
          echo "Order status deleted successfully.";
     } catch (\Throwable $th) {
          echo ("can't  delete this");
     }
} else {
     echo "No status selected.";
}
