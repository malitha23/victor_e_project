<?php
require_once '../db.php';

if (isset($_POST['batch_id'])) {
     $batch_id = intval($_POST['batch_id']);

     $batch = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $batch_id . "' ");
     $batchnum = $batch->num_rows;
     if ($batchnum == 1) {
          $batchdata = $batch->fetch_assoc();
          if($batchdata["Delete"] == 0){
               Databases::IUD("UPDATE `batch` SET `Delete` = '1' WHERE (`id` = '".$batch_id."');");
               echo("Deleted successfully.");
          }else{
               echo("deleted in past");
          }
     } else {
          echo ("not found");
     }
} else {
     echo "Invalid request: No batch ID provided";
}
