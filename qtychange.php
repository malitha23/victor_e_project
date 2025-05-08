<?php
session_start();
include "connection.php";
if (isset($_POST["id"]) && isset($_POST["qty"])) {
    $id = $_POST["id"];
    $qty = $_POST["qty"];

    // Validate input to ensure it's an integer greater than or equal to zero
    if (!is_numeric($qty) || $qty < 0) {
        echo "Error: Invalid quantity.";
        exit();
    }

    if (!isset($_SESSION["user_vec"])) {
        // Update session cart instead of database
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['id'] == $id) {

                    if ($cartItem["discount"] == 0) {
                        $batch = Database::Search("SELECT * FROM `batch` WHERE `id` = '" . $cartItem["batch_id"] . "'");
                        $batch_data = $batch->fetch_assoc();
                        if ($qty > $batch_data["batch_qty"]) {
                            echo 0;
                        } elseif ($qty == 0) {
                            echo 0;
                        } else {
                            $cartItem['qty'] = $qty; // Update quantity in session
                            include "refreshcart.php";
                        }
                    } else {
                        $dis = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `batch_id`='" . $cartItem["batch_id"] . "' ");
                        $disdata = $dis->fetch_assoc();
                        if ($disdata["qty"] >= $qty) {
                            $batch = Database::Search("SELECT * FROM `batch` WHERE `id` = '" . $cartItem["batch_id"] . "'");
                            $batch_data = $batch->fetch_assoc();
                            if ($qty > $batch_data["batch_qty"]) {
                                echo 0;
                            } elseif ($qty == 0) {
                                echo 0;
                            } else {
                                $cartItem['qty'] = $qty; // Update quantity in session
                                include "refreshcart.php";
                            }
                        } else {
                            echo 0;
                        }
                    }
                }
            }
        }
        //  echo "Error: Cart item not found in session.";
        exit();
    } else {
        $email = $_SESSION["user_vec"]["email"];
        $cart = Database::Search("SELECT * FROM `cart` WHERE `user_email` = '" . $email . "' AND `id`='" . $id . "' ");
        $cartnum = $cart->num_rows;

        if ($cartnum > 0) {
            $cardata = $cart->fetch_assoc();
            if ($cardata["discount"] == 0) {
                if ($qty == 0) {
                    echo 0;
                    exit();
                }
                $batch = Database::Search("SELECT * FROM `batch` WHERE `id` = '" . $cardata["batch_id"] . "'");
                $batch_data = $batch->fetch_assoc();
                if ($batch_data["batch_qty"] < $qty) {
                    echo 0;
                } else {
                    Database::IUD("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `id`='" . $id . "' ");
                    $cartresult = Database::Search("SELECT * FROM  `cart` WHERE `user_email` = '" . $email . "' AND `id`='" . $id . "'");
                    $cartresultd = $cartresult->fetch_assoc();
                    if ($cartresultd["qty"] == $qty) {
                        include "refreshcart.php";
                    }
                }
            } else {
                $dis = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `batch_id`='" . $cardata["batch_id"] . "' ");
                $disdata = $dis->fetch_assoc();
                if ($disdata["qty"] >= $qty) {
                    $batch = Database::Search("SELECT * FROM `batch` WHERE `id` = '" . $cardata["batch_id"] . "'");
                    $batch_data = $batch->fetch_assoc();
                    if ($qty > $batch_data["batch_qty"]) {
                        echo 0;
                    } elseif ($qty == 0) {
                        echo 0;
                    } else {
                        Database::IUD("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `id`='" . $id . "' ");
                        $cartresult = Database::Search("SELECT * FROM  `cart` WHERE `user_email` = '" . $email . "' AND `id`='" . $id . "'");
                        $cartresultd = $cartresult->fetch_assoc();
                        if ($cartresultd["qty"] == $qty) {
                            include "refreshcart.php";
                        }
                    }
                } else {
                    echo 0;
                }
            }
        } else {
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as &$cartItem) {
                    if ($cartItem['id'] == $id) {

                        if ($cartItem["discount"] == 0) {
                            $batch = Database::Search("SELECT * FROM `batch` WHERE `id` = '" . $cartItem["batch_id"] . "'");
                            $batch_data = $batch->fetch_assoc();
                            if ($qty > $batch_data["batch_qty"]) {
                                echo "Error: Not enough stock available. Maximum available: " . $batch_data["batch_qty"];
                            } elseif ($qty == 0) {
                                echo "Error: Quantity cannot be zero.";
                            } else {
                                $cartItem['qty'] = $qty; // Update quantity in session
                                include "refreshcart.php";
                            }
                        } else {
                            $dis = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `batch_id`='" . $cartItem["batch_id"] . "' ");
                            $disdata = $dis->fetch_assoc();
                            if ($disdata["qty"] >= $qty) {
                                $batch = Database::Search("SELECT * FROM `batch` WHERE `id` = '" . $cartItem["batch_id"] . "'");
                                $batch_data = $batch->fetch_assoc();
                                if ($qty > $batch_data["batch_qty"]) {
                                    echo "Error: Not enough stock available. Maximum available: " . $batch_data["batch_qty"];
                                } elseif ($qty == 0) {
                                    echo "Error: Quantity cannot be zero.";
                                } else {
                                    $cartItem['qty'] = $qty; // Update quantity in session
                                    include "refreshcart.php";
                                }
                            } else {
                                echo 0;
                            }
                        }
                    }
                }
            }
            ///   echo "Error: Cart item not found.";
        }
    }
} else {
    echo "Error: Missing required parameters.";
}
