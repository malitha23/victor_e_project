<?php
require_once "connection.php";

if (isset($_POST["district_id"])) {
     $district_id = $_POST["district_id"];
     $dhc = Database::Search("SELECT * FROM `city_has_distric` WHERE `distric_distric_id`='" . $district_id . "' ");
     $dhcn = $dhc->num_rows;
     if ($dhcn == 0) {
          exit();
     }
     $dhcdata = $dhc->fetch_assoc();
     $city = Database::Search("SELECT * FROM `city` WHERE `city_id`='" .  $dhcdata["city_city_id"] . "' ");
     $city_a = $city->fetch_assoc();
?>
     <select id="city" class="common-input">
          <option value="<?php echo $city_a["city_id"]  ?>" selected><?php echo $city_a["name"]  ?></option>
          <?php
          $dis = Database::Search("SELECT * FROM `city` ");
          $dis_num  = $dis->num_rows;
          for ($i = 0; $i < $dis_num; $i++) {
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