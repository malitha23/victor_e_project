<?php
require_once "connection.php";

if (isset($_POST["district_id"])) {
     $district_id = $_POST["district_id"];
     $dhc = Database::Search("SELECT * FROM `city_has_distric` WHERE `distric_distric_id`='" . $district_id . "' ");
     $dhcn = $dhc->num_rows;
     if ($dhcn == 0) {
          exit();
     }
?>
     <select id="city" class="common-input">
          <?php
          for ($i = 0; $i < $dhcn; $i++) {
               $dhcdata = $dhc->fetch_assoc();
               $dis = Database::Search("SELECT * FROM `city` WHERE `city_id`='" .  $dhcdata["city_city_id"] . "' ");
               $dis_num  = $dis->num_rows;
               $dis_data = $dis->fetch_assoc();
          ?>
               <option value="<?php echo $dis_data["city_id"] ?>"><?php echo $dis_data["name"] ?></option>
          <?php
          }
          ?>
     </select>
<?php
}
?>