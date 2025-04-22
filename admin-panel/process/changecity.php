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

                $q1 = "SELECT city.city_id,city.`name`,delivery_fee.fee FROM city
                        INNER JOIN city_has_distric ON city.city_id = city_has_distric.city_city_id
                        INNER JOIN distric ON distric.distric_id = city_has_distric.distric_distric_id
                        LEFT JOIN delivery_fee ON delivery_fee.city_city_id = city.city_id
                        WHERE distric.distric_id ='" . $did . "' ORDER BY city.`name` ASC ";
                $qs = Databases::search($q1);

                for($n=1;$n<$qs->num_rows;$n++){
                    $data = $qs->fetch_assoc();
?>
                    <tr class="">
                        <td><?php echo $n; ?></td>
                        <td class="px-md-3 px-lg-5"><?php echo $data['name']; ?></td>
                        <td class="px-md-3 px-lg-5 text-center"><input type="number" value="<?php echo $data['fee']; ?>" id="<?php echo $data['city_id']; ?>" data-original="<?php echo $data['fee']; ?>" class="ps-1 form-control p-1 rounded-0"></td>
                    </tr>
<?php
                }
            } else {
                echo "Please select a District.";
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