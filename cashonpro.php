<?php
session_start();
include_once "connection.php";
if (isset($_SESSION["user_vec"])) {
    unset($_SESSION['cart']);
    class cashonpro
    {
        private $firstName, $lastName, $email, $mobile, $district, $city, $address1, $address2;

        public function __construct()
        {
            $this->address1 = $_POST['address1'] ?? '';
            $this->address2 = $_POST['address2'] ?? '';
            $this->firstName = $_POST['firstName'] ?? '';
            $this->lastName = $_POST['lastName'] ?? '';
            $this->email = $_POST['email'] ?? '';
            $this->mobile = $_POST['mobile'] ?? '';
            $this->district = $_POST['district'] ?? '';
            $this->city = $_POST['city'] ?? '';
        }

        public function getCashOnPro()
        {
            $VALI = new Validate();
            $user_data = [
                'firstName' => $this->firstName,
                'lastName'  => $this->lastName,
                'email'     => $this->email,
                'mobile'    => $this->mobile,
                'district'  => $this->district,
                'city'      => $this->city,
                'address1'  => $this->address1,
                'address2'  => $this->address2
            ];
            $validationResult = $VALI->get($user_data);
            if ($validationResult === 1) {
                $sql = new sql();
                return  $sql->sql($user_data);
            } else {
                return $validationResult;
            }
        }
    }

    class sql
    {
        public function sql($user_data)
        {
            $email  = $user_data['email'];
            $mobile = $user_data['mobile'];
            $address1 = $user_data['address1'];
            $address2 = $user_data['address2'];
            $firstName = $user_data['firstName'];
            $lastName = $user_data['lastName'];
            $district = $user_data['district'];
            $city = $user_data['city'];

            $cityQuery = "SELECT city_id FROM city WHERE name = '$city'";
            $cityResult = Database::Search($cityQuery);

            if ($cityResult->num_rows === 0) {
                $insertCityQuery = "INSERT INTO city (name) VALUES (?)";
                Database::IUD($insertCityQuery, [$city], "s");
                $city_id = Database::$connection->insert_id;
            } else {
                $cityRow = $cityResult->fetch_assoc();
                $city_id = $cityRow['city_id'];
            }

            // Insert or get District ID
            $districtQuery = "SELECT distric_id FROM distric WHERE name = '$district'";
            $districtResult = Database::Search($districtQuery);

            if ($districtResult->num_rows === 0) {
                $insertDistrictQuery = "INSERT INTO distric (name) VALUES (?)";
                Database::IUD($insertDistrictQuery, [$district], "s");
                $district_id = Database::$connection->insert_id;
            } else {
                $districtRow = $districtResult->fetch_assoc();
                $district_id = $districtRow['distric_id'];
            }

            // address1 and address2 handling
            $query = "SELECT adress_id FROM user WHERE email = '$email'";
            $result = Database::Search($query);

            $user = $result->fetch_assoc();
            if (!empty($user['adress_id'])) {
                $existing_address_id = $user['adress_id'];
            } else {
                $existing_address_id = null;
            }


            // 🔹 Step 2: Insert or Update Address
            if ($existing_address_id) {
                // Update existing address
                $updateAddressQuery = "UPDATE address SET line_1 = ?, line_2 = ?, city_city_id = ?, distric_distric_id = ? WHERE address_id = ?";
                Database::IUD($updateAddressQuery, [$address1, $address2, $city_id, $district_id, $existing_address_id], "ssiii");
                $address_id = $existing_address_id;
            } else {
                // Insert new address
                $insertAddressQuery = "INSERT INTO address (line_1, line_2, city_city_id, distric_distric_id) VALUES (?, ?, ?, ?)";
                Database::IUD($insertAddressQuery, [$address1, $address2, $city_id, $district_id], "ssii");
                $address_id = Database::$connection->insert_id;
            }

            // 🔹 Step 3: Update User
            $updateUserQuery = "UPDATE user SET fname = ?, lname = ?, mobile = ?, adress_id = ? WHERE email = ?";
            Database::IUD($updateUserQuery, [$firstName, $lastName, $mobile, $address_id, $email], "sssis");

            $cart = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "' ");
            $cartnum = $cart->num_rows;
            $deliveryfee = 0.00;

            if ($cartnum > 0) {
                $u = Database::Search("SELECT * FROM `user` WHERE `email`='" . $email . "' ");
                if ($u->num_rows == 1) {
                    $ud = $u->fetch_assoc();
                    if (!empty($ud["adress_id"])) {
                        $ad = Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $ud["adress_id"] . "'");
                        if ($ad->num_rows == 1) {
                            $add = $ad->fetch_assoc();
                            $df = Database::Search("SELECT * FROM `delivery_fee` WHERE `city_city_id`='" . $add["city_city_id"] . "' ");
                            if ($df->num_rows == 1) {
                                $dfd = $df->fetch_assoc();
                                $deliveryfee = floatval($dfd["fee"]);
                            }
                        }
                    }
                }

                $cart->data_seek(0);
                $cartdatafull = [];
                while ($row = $cart->fetch_assoc()) {
                    $cartdatafull[] = $row;
                }

                $price_tot = 0;
                foreach ($cartdatafull as $cartdata) {
                    $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $cartdata["batch_id"] . "' ");
                    if ($batch->num_rows == 1) {
                        $batch_data = $batch->fetch_assoc();
                        $price = floatval($batch_data["selling_price"]);
                        $discountpre = floatval($cartdata["discount"]);
                        $qty = intval($cartdata["qty"]);
                        $discountAmount = ($price * $discountpre) / 100;
                        $finalPricePerItem = $price - $discountAmount;
                        $item_total = $finalPricePerItem * $qty;
                        $price_tot += $item_total;


                        $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batch_data["product_id"] . "' ");
                        $product_data = $product->fetch_assoc();
                        if ($product_data["weight"] > 0) {
                            $product_weight = $product_data["weight"];
                            $dw = Database::Search("SELECT * FROM `weight`");
                            $dwn = $dw->num_rows;
                            for ($i = 0; $i < $dwn; $i++) {
                                $dwd = $dw->fetch_assoc();
                                if ($dwd["weight"] == $product_weight) {
                                    $final_product_weight = $dwd["weight"];
                                    $dfw = Database::Search("SELECT * FROM `delivery_fee_for_weight` WHERE `weight_id`='" . $dwd["id"] . "' ");
                                    $dfwn = $dfw->num_rows;
                                    if ($dfwn == 1) {
                                        $dfwd = $dfw->fetch_assoc();
                                        $weigdeliveryfee = $dfwd["fee"];
                                    } else {
                                        $weigdeliveryfee = 0;
                                    }
                                } else {
                                    $weigdeliveryfee = 0;
                                }
                            }
                        } else {
                            $weigdeliveryfee = 0;
                        }

                        try {

                            $delivery_total_fee = $weigdeliveryfee + $deliveryfee;
                            $price = number_format($item_total, 2, '.', '');
                            $totalprice = number_format($item_total + $delivery_total_fee, 2, '.', '');


                            $UNI = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
                            Database::IUD("INSERT INTO `cashond` (`delivery_fee`,`price`,`totalprice`, `discount_pre`, `qty`, `uniq_id`, `product_id`, `batch_id`, `email`, `cashon_status_id`)
                    VALUES ('" . $delivery_total_fee . "','" . $price . "','" . $totalprice . "', '$discountpre', '$qty', '$UNI', '" . $batch_data["product_id"] . "', '" . $cartdata["batch_id"] . "', '$email', '1');");
                            $out = [
                                'email' => $email
                            ];
                            Database::IUD("DELETE FROM `cart` WHERE `user_email` = '$email' AND `batch_id` = '" . $cartdata["batch_id"] . "'");
                            return $out;
                        } catch (Exception $e) {
                            return "Error inserting cashond order: " . $e->getMessage();
                            exit();
                        }
                    }
                }

                $price_tot += $deliveryfee;
                $price_tot_formatted = number_format($price_tot, 2);

                // Optional: Clear cart
                // Database::IUD("DELETE FROM `cart` WHERE `user_email` = '$email'");
            } else {
                echo 0;
            }
            //    return "User details updated successfully.";
        }
    }
    class Validate
    {
        public function get($user_data)
        {
            if (empty($user_data['email'])) {
                return "Please enter your email";
            } elseif (!filter_var($user_data['email'], FILTER_VALIDATE_EMAIL)) {
                return "Invalid email format";
            } elseif (strlen($user_data['email']) > 101) {
                return "Email is too long";
            } elseif (empty($user_data['mobile'])) {
                return "Please enter your mobile number";
            } elseif (!$this->validateMobile($user_data['mobile'])) {
                return "Invalid mobile number format. It should be 10 digits.";
            } elseif (strlen($user_data['address1']) > 60) {
                return "Address line 1 is too long. Maximum 60 characters allowed.";
            } else {
                return 1;
            }
        }

        private function validateMobile($mobile)
        {
            return preg_match('/^\d{10}$/', $mobile);
        }
    }

    // Run the logic
    $handler = new cashonpro();
    $out = $handler->getCashOnPro();
    if (is_array($out)) {
        echo $out['email'];
    } else {
        echo $out; // Output the error message
    }
} else {

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

        $address1 = $_POST['address1'] ?? '';
        $address2 = $_POST['address2'] ?? '';
        $fname = $_POST['firstName'] ?? '';
        $lname = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $district = $_POST['district'] ?? '';
        $city = $_POST['city'] ?? '';

        $VALI = new Validate();
        $user_data = [
            'firstName' => $fname,
            'lastName'  => $lname,
            'email'     => $email,
            'mobile'    => $mobile,
            'district'  => $district,
            'city'      => $city,
            'address1'  => $address1,
            'address2'  => $address2
        ];
        $validationResult = $VALI->get($user_data);
        if ($validationResult != 1) {
            echo $validationResult;
            exit();
        }

        // Insert or get City ID
        $cityQuery = "SELECT city_id FROM city WHERE name = '$city'";
        $cityResult = Database::Search($cityQuery);

        if ($cityResult->num_rows === 0) {
            $insertCityQuery = "INSERT INTO city (name) VALUES (?)";
            Database::IUD($insertCityQuery, [$city], "s");
            $city_id = Database::$connection->insert_id;
        } else {
            $cityRow = $cityResult->fetch_assoc();
            $city_id = $cityRow['city_id'];
        }

        // Insert or get District ID
        $districtQuery = "SELECT distric_id FROM distric WHERE name = '$district'";
        $districtResult = Database::Search($districtQuery);

        if ($districtResult->num_rows === 0) {
            $insertDistrictQuery = "INSERT INTO distric (name) VALUES (?)";
            Database::IUD($insertDistrictQuery, [$district], "s");
            $district_id = Database::$connection->insert_id;
        } else {
            $districtRow = $districtResult->fetch_assoc();
            $district_id = $districtRow['distric_id'];
        }

        // Insert new address
        $insertAddressQuery = "INSERT INTO address (line_1, line_2, city_city_id, distric_distric_id) VALUES (?, ?, ?, ?)";
        Database::IUD($insertAddressQuery, [$address1, $address2, $city_id, $district_id], "ssii");
        $address_id = Database::$connection->insert_id;

        $generatedPassword = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);

        try {
            $insertUserQuery = "INSERT INTO user (email, fname, lname, mobile, status, password, date, adress_id) VALUES (?, ?, ?, ?, 1, ?, NOW(), ?)";
            Database::IUD($insertUserQuery, [$email, $fname, $lname, $mobile, $generatedPassword, $address_id], "sssssi");
        } catch (\Throwable $th) {
            echo ("You are already registered or have invalid details.");
            Database::IUD("DELETE FROM `address` WHERE (`address_id` = '".$address_id."');");
            exit();
        }

        $_SESSION["user_vec"] = array(
            "email" => $email,
            "login_time" => date("Y-m-d H:i:s"),
            "ip_address" => $_SERVER['REMOTE_ADDR'],
            "user_agent" => $_SERVER['HTTP_USER_AGENT'],
        );


        $u = Database::Search("SELECT * FROM `user` WHERE `email`='" . $email . "' ");
        $deliveryfee = 0;
        if ($u->num_rows == 1) {
            $ud = $u->fetch_assoc();
            if (!empty($ud["adress_id"])) {
                $ad = Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $ud["adress_id"] . "'");
                if ($ad->num_rows == 1) {
                    $add = $ad->fetch_assoc();
                    $df = Database::Search("SELECT * FROM `delivery_fee` WHERE `city_city_id`='" . $add["city_city_id"] . "' ");
                    if ($df->num_rows == 1) {
                        $dfd = $df->fetch_assoc();
                        $deliveryfee = floatval($dfd["fee"]);
                    }
                }
            }
        }
        $price_tot = 0;
        foreach ($_SESSION['cart'] as $item) {

            // Database::IUD("INSERT INTO `cart` (`qty`, `user_email`, `batch_id`, `discount`) 
            //             VALUES ('" . $item["qty"] . "', '" . $email . "', '" . $item['batch_id'] . "', '" . $item['discount'] . "');");

            $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $item['batch_id']  . "' ");
            $batch_data = $batch->fetch_assoc();
            $price = floatval($batch_data["selling_price"]);
            $discountpre = floatval($item['discount']);
            $qty = intval($item["qty"]);
            $discountAmount = ($price * $discountpre) / 100;
            $finalPricePerItem = $price - $discountAmount;
            $item_total = $finalPricePerItem * $qty;
            $price_tot += $item_total;


            $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $item['batch_id'] . "' ");
            $product_data = $product->fetch_assoc();
            if ($product_data["weight"] > 0) {
                $product_weight = $product_data["weight"];
                $dw = Database::Search("SELECT * FROM `weight`");
                $dwn = $dw->num_rows;
                for ($i = 0; $i < $dwn; $i++) {
                    $dwd = $dw->fetch_assoc();
                    if ($dwd["weight"] == $product_weight) {
                        $final_product_weight = $dwd["weight"];
                        $dfw = Database::Search("SELECT * FROM `delivery_fee_for_weight` WHERE `weight_id`='" . $dwd["id"] . "' ");
                        $dfwn = $dfw->num_rows;
                        if ($dfwn == 1) {
                            $dfwd = $dfw->fetch_assoc();
                            $weigdeliveryfee = $dfwd["fee"];
                        } else {
                            $weigdeliveryfee = 0;
                        }
                    } else {
                        $weigdeliveryfee = 0;
                    }
                }
            } else {
                $weigdeliveryfee = 0;
            }



            $delivery_total_fee = $weigdeliveryfee + $deliveryfee;
            $price = number_format($item_total, 2, '.', '');
            $totalprice = number_format($item_total + $delivery_total_fee, 2, '.', '');

            $UNI = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
            Database::IUD("INSERT INTO `cashond` (`delivery_fee`,`price`,`totalprice`, `discount_pre`, `qty`, `uniq_id`, `product_id`, `batch_id`, `email`, `cashon_status_id`)
                    VALUES ('" . $delivery_total_fee . "','" . $price . "','" . $totalprice . "', '$discountpre', '$qty', '$UNI', '" . $batch_data["product_id"] . "', '" . $item['batch_id'] . "', '" . $email . "', '1');");

            echo $email;

            unset($_SESSION['cart']);

            //  echo "<tr>";
            //  echo "<td>" . htmlspecialchars($item['id']) . "</td>";
            //  echo "<td>" . htmlspecialchars($item['batch_id']) . "</td>";
            //  echo "<td>" . htmlspecialchars($item['user_email']) . "</td>";
            //  echo "<td>" . htmlspecialchars($item['qty']) . "</td>";
            //  echo "<td>" . htmlspecialchars($item['discount']) . "</td>";
        }
    } else {
        echo "<p>Your cart is empty.</p>";
    }
}
