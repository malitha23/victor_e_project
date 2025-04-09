<?php
require "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     // Check if an image is uploaded
     if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
          $image = $_FILES["image"];
          $img_name = uniqid("img_") . "_" . basename($image["name"]);
          $target_dir = "uploads/"; // Make sure this folder exists and is writable
          $target_file = $target_dir . $img_name;

          // Validate file type (optional but recommended)
          $allowed_types = ["image/jpeg", "image/png", "image/webp", "image/jpg"];
          if (!in_array($image["type"], $allowed_types)) {
?>
               <script>
                    alert("Invalid file type.");
               </script>
               <?php
               exit;
          }

          // Move uploaded file
          if (move_uploaded_file($image["tmp_name"], $target_file)) {
               // Determine which table to update
               $updated = false;

               if (!empty($_POST["group_id"])) {
                    $gid = $_POST["group_id"];
                    Databases::iud("UPDATE `group` SET `image_path` = '$target_file' WHERE `id` = '$gid'");
                    $updated = true;
               }

               if (!empty($_POST["category_id"])) {
                    $cid = $_POST["category_id"];
                    Databases::iud("UPDATE `category` SET `image_path` = '$target_file' WHERE `id` = '$cid'");
                    $updated = true;
               }

               if (!empty($_POST["brand_id"])) {
                    $bid = $_POST["brand_id"];
                    Databases::iud("UPDATE `brand` SET `img_path` = '$target_file' WHERE `id` = '$bid'");
                    $updated = true;
               }

               if ($updated) {
               ?>
                    <script>
                         alert("Image uploaded and saved successfully.");
                    </script>
               <?php
               } else {
               ?>
                    <script>
                         alert("No valid selection made.");
                    </script>
               <?php
               }
          } else {
               ?>
               <script>
                    alert("Failed to move uploaded file.");
               </script>
          <?php
          }
     } else {
          ?>
          <script>
               alert("No file uploaded or file error.");
          </script>
     <?php
     }
} else {
     ?>
     <script>
          alert("Invalid request.");
     </script>
<?php
}
?>
<script>
     let previousUrl = document.referrer;
     window.location = previousUrl;
</script>