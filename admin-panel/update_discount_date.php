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
          // ADD new entry
          // Insert into discount_date_range table
          Databases::iud("INSERT INTO discount_date_range (start_date, end_date) VALUES ('$start_date', '$end_date')");
          $date_range_id = Database::$connection->insert_id;

          // Insert into discount_date_range_has_product
          Databases::iud("INSERT INTO discount_date_range_has_product 
            (discount_date_range_id, discount_pre, discount_group_id, qty, batch_id) 
            VALUES ('$date_range_id', '$percentage', '$discount_group_id', 0, 0)");

          echo "Saved successfully.";
     }
}
?>
<script>
     let previousUrl = document.referrer;
     window.location = previousUrl;
</script>