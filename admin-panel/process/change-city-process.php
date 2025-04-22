<?php

require "../db.php";
session_start();

if (isset($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["username"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset($_POST["did"])) {

            if (!empty($_POST["did"]) && $_POST["did"] != 0) {

                $did = $_POST["did"];

                $q1 = "SELECT city.city_id,city.`name` AS city_name FROM `city` INNER JOIN city_has_distric ON city.city_id=city_has_distric.city_city_id
INNER JOIN distric ON distric.distric_id=city_has_distric.distric_distric_id WHERE `distric_id`='" . $did . "' ";
                $qs = Databases::search($q1);

                while ($data = $qs->fetch_assoc()) {
?>
                    <option value="<?php echo $data['city_id'] ?>" >
                        <?php echo $data['city_name'] ?>
                    </option>
<?php
                }
            } else {
                echo "Please select a ditsrict.";
            }
        } else {
            echo "Error";
        };
    } else {
        echo "Error";
    };
} else {
    echo "Error";
}

?>