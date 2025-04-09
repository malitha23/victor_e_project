<?php
require "db.php"; // adjust this to your DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $discount_group_id = $_POST["discount_group_id"];
     $percentage = $_POST["percentage"];
     $start_date = $_POST["start_date"];
     $end_date = $_POST["end_date"];
     $edit_id = isset($_POST["edit_id"]) ? $_POST["edit_id"] : null;

     // Basic validation (optional, you can add more)
     if (empty($discount_group_id) || empty($percentage) || empty($start_date) || empty($end_date)) {
          echo "Please fill in all required fields.";
          exit;
     }

     if ($edit_id) {
          // UPDATE existing date range
          // First, get the date_range_id to update its dates
          $res = Databases::Search("SELECT discount_date_range_id FROM discount_date_range_has_product WHERE id='$edit_id'");
          if ($res->num_rows == 1) {
               for ($i = 0; $i < $res->num_rows; $i++) {
                    $data = $res->fetch_assoc();
                    $date_range_id = $data["discount_date_range_id"];
                    Databases::iud("UPDATE discount_date_range SET start_date='$start_date', end_date='$end_date' WHERE id='$date_range_id'");
                    try {
                         Databases::iud("UPDATE discount_date_range_has_product SET discount_pre='$percentage' WHERE id='$edit_id'");
                    } catch (\Throwable $th) {
                         echo ("Ignore the error. You may have typed too many characters. Try typing less.");
                    }
               }
?>
               <script>
                    alert("Updated successfully.");
               </script>
<?php
          } else {
               echo "Invalid edit ID.";
          }
     } else {
         ?>
         <script>
          alert("Please add new batch first. There you can add a start date, end date, and percentage.");
         </script>
         <?php
     }
}
?>
<script>
     let previousUrl = document.referrer;
     window.location = previousUrl;
</script>