<?php
session_start();
include "../connection.php";
header("Content-Type: application/json");
require '../email/emailSend.php';
include '../email/emailTemplates/emailTemplate.php';

$data = json_decode(file_get_contents("php://input"), true);
$response = [];

// Validate email
if (empty($data["uemail"])) {
    echo json_encode(["status" => "error", "message" => "Email is required."]);
    exit;
}

$email = trim($data["uemail"]);
$fname = isset($data["fname"]) ? trim($data["fname"]) : null;
$lname = isset($data["lname"]) ? trim($data["lname"]) : null;
$mobile = isset($data["mobile"]) ? trim($data["mobile"]) : null;
$address1 = isset($data["address1"]) ? trim($data["address1"]) : null;
$address2 = isset($data["address2"]) ? trim($data["address2"]) : null;
$city = isset($data["city"]) ? trim($data["city"]) : null;
$district = isset($data["district"]) ? trim($data["district"]) : null;
$total_value = isset($data["total_value"]) ? trim($data["total_value"]) : 0;



try {

    Database::SetupConnection();

    // 🔹 Step 1: Fetch user details
    $query = "SELECT adress_id FROM user WHERE email = '$email'";
    $result = Database::Search($query);

    if ($result->num_rows === 0) {
        // Generate a simple 8-character password (without hashing)
        $generatedPassword = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);

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

        $insertUserQuery = "INSERT INTO user (email, fname, lname, mobile, status, password, date, adress_id) VALUES (?, ?, ?, ?, 1, ?, NOW(), ?)";
        Database::IUD($insertUserQuery, [$email, $fname, $lname, $mobile, $generatedPassword, $address_id], "sssssi");

        $emailSend = new EmailSend();

        // Set the recipient and subject of the email
        $emailContent = getEmailContent($fname, $lname, $email, $generatedPassword);
        $emailSend->setRecipient($email, $fname);
        $emailSend->setContent('Your Login Credentials', $emailContent['html'], $emailContent['plain']);

        // Send the email
        $emailSend->send();

        finalizeProcess($email);
        exit;
    }


    $user = $result->fetch_assoc();
    $existing_address_id = $user['adress_id'];

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
    Database::IUD($updateUserQuery, [$fname, $lname, $mobile, $address_id, $email], "sssis");
    finalizeProcess($email);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}

function finalizeProcess($email)
{
    $cart_items = [];
    global $total_value;

    $_SESSION["user_vec"] = array(
        "email" => $email,
        "login_time" => date("Y-m-d H:i:s"),
        "ip_address" => $_SERVER['REMOTE_ADDR'],
        "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    );

    if (isset($_SESSION["user_vec"])) {
        $email = $_SESSION["user_vec"]["email"];

        // Fetch user details including city ID
        $query = "SELECT user.email, user.fname, user.lname, user.mobile, user.adress_id,
                     address.city_city_id 
              FROM user
              LEFT JOIN address ON user.adress_id = address.address_id
              WHERE user.email = '$email'";

        $user_row = Database::Search($query);
        $user_data = ($user_row->num_rows > 0) ? $user_row->fetch_assoc() : [];

        $city_id = $user_data["city_city_id"] ?? null;

        // Fetch delivery fee based on city ID
        $delivery_fee = 0;
        if ($city_id) {
            $df = Database::Search("SELECT * FROM `delivery_fee` WHERE `city_city_id`='" . $city_id . "'");
            if ($df->num_rows == 1) {
                $dfd = $df->fetch_assoc();
                $delivery_fee = $dfd["fee"];
            }
        }

        // Fetch cart data from the database
        $cart_query = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_data["email"] . "'");

        if ($cart_query->num_rows > 0) {
            while ($cart_item = $cart_query->fetch_assoc()) {
                $cart_item["user_email"] = $email;
                $cart_items[] = $cart_item;
            }
        } else if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // If DB cart is empty, fallback to session cart
            foreach ($_SESSION['cart'] as $item) {
                $item["user_email"] = $email;
                $cart_items[] = $item;
            }
        }
    } else {
        // Guest user: Fetch cart from session
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $item["user_email"] = $email;
                $cart_items[] = $item;
            }
        }
    }


    $invoice_ids = [];
    $orderId = "OID" . time();
    $unique_code = "INV-" . uniqid() . "-" . rand(1000, 9999);

    // Process each cart item
    foreach ($cart_items as $item) {
        $batch_id = $item["batch_id"];
        $weigdeliveryfee = 0;
        $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $batch_id . "' ");
        $batch_data = $batch->fetch_assoc();
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

        $total_delivery_fee = $delivery_fee + $weigdeliveryfee;
        // Fetch batch details from the database
        $batch_query = Database::Search("SELECT `batch_code`, `product_id`, `vendor_name`, `batch_price`, `selling_price`, `batch_qty`, `date`, `id` FROM `batch` WHERE `id` = '$batch_id'");
        $batch_data = ($batch_query->num_rows > 0) ? $batch_query->fetch_assoc() : [];

        $currentDateTime = date("Y-m-d H:i:s");
        // Insert into invoice table
        Database::IUD("INSERT INTO `invoice`(`date_time`,`uni_code`, `product_id`, `batch_id`, `price`, `discount`, `delivery_fee`, `user_email`, `qty`) 
                         VALUES ('$currentDateTime',
                                 '$unique_code', 
                                 '" . $batch_data["product_id"] . "', 
                                 '" . $batch_id . "',
                                 '" . $batch_data["selling_price"] . "', 
                                 '" . $item["discount"] . "', 
                                 '$total_delivery_fee', 
                                 '" . $item["user_email"] . "', 
                                 '" . $item["qty"] . "')");

        $invoice_id = Database::InsertID(); // Get last inserted invoice ID
        $invoice_ids[] = $invoice_id;
    }
    // Insert into order table
    Database::IUD("INSERT INTO `order`(`id`, `invoice_id`, `user_email`, `Order_status_id`) 
    VALUES ('$orderId', '$unique_code', '$email', 1)");

    if (file_exists(__DIR__ . '/.env')) {
        $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = trim($value);
        }
    }

    $merchantWebToken = $_ENV['IPAY_MERCHANT_TOKEN'] ?? '';
    $ipayUrl = $_ENV['IPAY_URL'] ?? '';
    $orderDescription = "Orders Payment";
    $baseUrl = $_ENV['BASE_URL'] ?? getenv('BASE_URL') ?? '';

    $returnUrl = $baseUrl . "cart.php?orderId=" . $orderId . "&status=success";
    $cancelUrl = $baseUrl . "cart.php?orderId=" . $orderId . "&status=failed";


    $paymentData = [
        "merchantWebToken" => $merchantWebToken,
        "orderId" => $orderId,
        "orderDescription" => $orderDescription,
        "returnUrl" => $returnUrl,
        "cancelUrl" => $cancelUrl,
        "totalAmount" => $total_value,
        "customerName" => $user_data["fname"] . " " . $user_data["lname"],
        "customerPhone" => $user_data["mobile"],
        "customerEmail" => $email,
    ];

    // 🔹 Step 5: Send JSON Response
    echo json_encode([
        "status" => "success",
        "message" => "Order placed successfully.",
        "paymentData" => $paymentData,
        "pay_url" => $ipayUrl
    ]);
}


// Close database connection after all operations
Database::CloseConnection();
