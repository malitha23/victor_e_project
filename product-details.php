<?php
session_start();
include 'connection.php'; // Include your database connection

// Get product details from URL parameters
$batch_id = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;
$discount_id = isset($_GET['discount_id']) ? intval($_GET['discount_id']) : 0;
if ($batch_id > 0) {
    $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $batch_id . "' ");
    $batchdata = $batch->fetch_assoc();
    $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "' ");
    $productdata = $product->fetch_assoc();
    $pic1 = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 1' ");
    $pic_d1 = $pic1->fetch_assoc();
    if (empty($pic_d1["path"])) {
        $picture1 = "assets/images/thumbs/product-details-two-thumb1.png";
    } else {
        $picture1 = $pic_d1["path"];
    }
    $pic2 = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 2' ");
    $pic_d2 = $pic2->fetch_assoc();
    if (empty($pic_d2["path"])) {
        $picture2 = "assets/images/thumbs/product-details-two-thumb1.png";
    } else {
        $picture2 = $pic_d2["path"];
    }
    $pic3 = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 3' ");
    $pic_d3 = $pic3->fetch_assoc();
    if (empty($pic_d3["path"])) {
        $picture3 = "assets/images/thumbs/product-details-two-thumb1.png";
    } else {
        $picture3 = $pic_d3["path"];
    }
?>


    <!DOCTYPE html>
    <html lang="en" class="color-two font-exo">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Title -->
        <title>Product Details – Everything You Need to Know</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/images/logo/favicon.png">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- select 2 -->
        <link rel="stylesheet" href="assets/css/select2.min.css">
        <!-- Slick -->
        <link rel="stylesheet" href="assets/css/slick.css">
        <!-- Jquery Ui -->
        <link rel="stylesheet" href="assets/css/jquery-ui.css">
        <!-- animate -->
        <link rel="stylesheet" href="assets/css/animate.css">
        <!-- AOS Animation -->
        <link rel="stylesheet" href="assets/css/aos.css">
        <!-- Main css -->
        <link rel="stylesheet" href="assets/css/main.css">
    </head>

    <body>

        <!--==================== Preloader Start ====================-->
        <div class="preloader">
            <img src="assets/images/icon/preloader.gif" alt="">
        </div>
        <!--==================== Preloader End ====================-->

        <?php require_once "shop_header.php"; ?>

        <!-- ========================== Product Details Two Start =========================== -->
        <section class="product-details py-80">
            <div class="container container-lg">
                <div class="row gy-4">
                    <div class="col-xl-9">
                        <div class="row gy-4">
                            <div class="col-xl-6">
                                <div class="product-details__left">

                                    <div class="product-details__thumb-slider border border-gray-100 rounded-16">
                                        <?php
                                        $picture =  Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $productdata["id"] . "' ");
                                        $picturenum = $picture->num_rows;
                                        for ($i = 0; $i < $picturenum; $i++) {
                                            $picturedata = $picture->fetch_assoc();
                                        ?>
                                            <div class="">
                                                <div class="product-details__thumb flex-center h-100">
                                                    <img src="admin-panel/<?php echo $picturedata["path"] ?>" alt="">
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="mt-24">
                                        <div class="product-details__images-slider">
                                            <?php
                                            $picture =  Database::Search("SELECT * FROM `picture` WHERE `product_id`='" . $productdata["id"] . "'");
                                            $picturenum = $picture->num_rows;
                                            for ($i = 0; $i < $picturenum; $i++) {
                                                $picturedata = $picture->fetch_assoc();
                                                if (empty($picturedata["path"])) {
                                            ?>
                                                    <div>
                                                        <div class="max-w-120 max-h-120 h-100 flex-center border border-gray-100 rounded-16 p-8">
                                                            <img src="assets/images/thumbs/product-details-two-thumb2.png" alt="">
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div>
                                                        <div class="max-w-120 max-h-120 h-100 flex-center border border-gray-100 rounded-16 p-8">
                                                            <img src="admin-panel/<?php echo $picturedata["path"] ?>" alt="">
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="product-details__content">

                                    <?php
                                    if ($discount_id == 0) {
                                        $discount_percentage  = 0;
                                    } else {
                                        // Fetch discount details based on discount_id
                                        $discount_query = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `id`='$discount_id'");
                                        if ($discount_query->num_rows > 0) {
                                            $discount_data = $discount_query->fetch_assoc();

                                            // Fetch related discount group details
                                            $disgroup_query = Database::Search("SELECT * FROM `discount_group` WHERE `id`='" . $discount_data["discount_group_id"] . "'");
                                            $disgroup_data = $disgroup_query->fetch_assoc();

                                            // Fetch date range details
                                            $daterange_query = Database::Search("SELECT * FROM `discount_date_range` WHERE `id`='" . $discount_data["discount_date_range_id"] . "'");
                                            $daterange_data = $daterange_query->fetch_assoc();

                                            if ($disgroup_data && $daterange_data) {
                                                $offer_start_date = $daterange_data["start_date"];
                                                $offer_end_date = $daterange_data["end_date"];
                                                $offer_title = $disgroup_data["title"];
                                                $offer_description = $disgroup_data["description"];
                                                $discount_percentage = $discount_data["discount_pre"]; // %

                                    ?>
                                                <div class="flex-center mb-24 flex-wrap gap-16 bg-color-one rounded-8 py-16 px-24 position-relative z-1">
                                                    <img src="assets/images/bg/details-offer-bg.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 z-n1">
                                                    <div class="flex-align gap-16">
                                                        <span class="text-white text-sm"><?php echo $offer_title; ?>:</span>
                                                    </div>

                                                    <div class="countdown" id="countdown11" data-end-time="<?php echo $offer_end_date; ?>">
                                                        <ul class="countdown-list flex-align flex-wrap">
                                                            <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="days">0</span></li>
                                                            <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="hours">0</span></li>
                                                            <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="minutes">0</span></li>
                                                            <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="seconds">0</span></li>
                                                        </ul>
                                                    </div>

                                                    <span class="text-white text-xs">Remains until the end of the offer</span>
                                                </div>

                                    <?php

                                            }
                                        }
                                    }
                                    ?>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            let countdownElement = document.getElementById("countdown11");
                                            let endTime = countdownElement.getAttribute("data-end-time");

                                            if (endTime) {
                                                let countDownDate = new Date(endTime).getTime();

                                                let x = setInterval(function() {
                                                    let now = new Date().getTime();
                                                    let distance = countDownDate - now;

                                                    if (distance < 0) {
                                                        clearInterval(x);
                                                        countdownElement.innerHTML = "<h5 class='text-danger'>Offer Expired</h5>";
                                                        return;
                                                    }

                                                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                    countdownElement.querySelector(".days").innerText = days;
                                                    countdownElement.querySelector(".hours").innerText = hours;
                                                    countdownElement.querySelector(".minutes").innerText = minutes;
                                                    countdownElement.querySelector(".seconds").innerText = seconds;
                                                }, 1000);
                                            }
                                        });
                                    </script>



                                    <h5 class="mb-12"><?php echo $productdata["title"] ?></h5>
                                    <div class="flex-align flex-wrap gap-12">
                                        <div class="flex-align gap-12 flex-wrap">
                                            <?php
                                            $invoice = Database::Search("SELECT * FROM `invoice` WHERE `batch_id`='" . $batch_id . "' ");
                                            $invoicenum = $invoice->num_rows;
                                            $inqtysell = 0;
                                            for ($i = 0; $i <  $invoicenum; $i++) {
                                                $invoicedata = $invoice->fetch_assoc();
                                                $inqtysell = $invoicedata["qty"] +  $inqtysell;
                                            }
                                            ?>
                                            <span class="text-sm fw-medium text-gray-500"><?php echo $inqtysell; ?> SOLD</span>
                                        </div>
                                        <span class="text-sm fw-medium text-gray-500">|</span>
                                        <span class="text-gray-900"> <span class="text-gray-400">SKU:</span><?php echo $batchdata["batch_code"] ?> </span>
                                    </div>

                                    <?php
                                    // Calculate discounted price
                                    $price = $batchdata["selling_price"];
                                    $discountpre = $discount_percentage;
                                    $discountAmount = ($price * $discountpre) / 100;
                                    $discount_due = $batchdata["selling_price"] * (1 - $discount_percentage / 100);
                                    ?>

                                    <span class="mt-32 pt-32 text-gray-700 border-top border-gray-100 d-block"></span>
                                    <div class="my-32 flex-align gap-16 flex-wrap" style="margin-top: 0px !important;">
                                        <div class="flex-align gap-8">
                                            <div class="flex-align gap-8 text-main-two-600">
                                                <?php
                                                if ($discount_percentage > 0) {
                                                ?>
                                                    <i hidden class="ph-fill ph-seal-percent text-xl"></i>
                                                    <?php $discount_percentage; ?>
                                                <?php
                                                } else {
                                                    $dis = (($batchdata["batch_price"] - $batchdata["selling_price"]) / $batchdata["batch_price"]) * 100
                                                ?>
                                                    <i class="ph-fill ph-seal-percent text-xl"></i>
                                                    -<?php echo number_format($dis, 0) ?>%
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <h6 class="mb-0">Rs <?php echo number_format($batchdata["selling_price"], 2); ?></h6>
                                        </div>
                                        <div class="flex-align gap-8">
                                            <span class="text-gray-700">Regular Price</span>
                                            <h6 class="text-xl text-gray-400 mb-0 fw-medium">Rs <?php echo number_format($batchdata["batch_price"], 2); ?></h6>
                                        </div>
                                    </div>
                                    <?php
                                    if ($discount_percentage > 0) {
                                    ?>
                                        <div class="my-32 flex-align gap-16 flex-wrap">
                                            <div class="row d-flex justify-content-center">
                                                <style>
                                                    .ob {
                                                        background-color: rgb(255, 199, 199);
                                                        background-image: url("assets/images/wet.PNG");
                                                        background-size: cover;
                                                        background-position: center;
                                                        background-repeat: no-repeat;
                                                        cursor: pointer;
                                                    }

                                                    .rs {
                                                        border-radius: 15px 0 0 15px;
                                                        box-shadow: 0 4px 6px rgba(255, 0, 0, 0.1);
                                                        /* bottom shadow */
                                                    }

                                                    .re {
                                                        border-radius: 0 15px 15px 0;
                                                        padding: 15px 30px 15px 0px !important;
                                                        box-shadow: 4px 0 6px rgba(255, 0, 0, 0.1);
                                                        /* right shadow */
                                                    }
                                                </style>
                                                <div class="col-4 ob rs"><img src="assets/images/thumbs/price-drop.png" class="img-fluid" alt=""></div>
                                                <div class="col-auto ob re">
                                                    <div class="small fw-bold" style="color:rgb(53, 29, 18) !important;">Special Price : </div>
                                                    <div class=" h3 pb-0 mb-0 ap" style="color:rgb(53, 29, 18) !important; font-weight: 800 !important;">Rs <?php echo $discount_due; ?></div>
                                                    <div class="h6 " style="color:rgb(255, 50, 50); font-weight: 800 !important;"><?php echo $discount_percentage; ?>% OFF</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="my-32 flex-align gap-16 flex-wrap" style="display: none;">
                                        <div class="flex-align gap-8">
                                            <div class="flex-align gap-8 text-main-two-600 discount-popup">
                                                <?php echo $discount_percentage; ?>%
                                            </div>
                                            <style>
                                                .discount-popup {
                                                    opacity: 0;
                                                    transform: scale(0.8);
                                                    animation: popupFadeIn 0.5s ease-out forwards;
                                                }

                                                @keyframes popupFadeIn {
                                                    0% {
                                                        opacity: 0;
                                                        transform: scale(0.8);
                                                    }

                                                    100% {
                                                        opacity: 1;
                                                        transform: scale(1);
                                                    }
                                                }
                                            </style>
                                            <h6 class="mb-0 text-gray-700">Normal Price: <span class="fw-bold">Rs. <?php echo number_format($batchdata["selling_price"], 2); ?></span></h6>
                                            <?php
                                            // Calculate discounted price
                                            $price = $batchdata["selling_price"];
                                            $discountpre = $discount_percentage;
                                            $discountAmount = ($price * $discountpre) / 100;
                                            $discount_due = $batchdata["selling_price"] * (1 - $discount_percentage / 100);
                                            ?>

                                            <h5 class="mb-0 text-main-two-700">Discount Price: <span class="fw-bold">Rs. <?php echo number_format($discountAmount, 2); ?></span></h5>
                                        </div>

                                        <?php
                                        // Default delivery fee
                                        if (isset($_SESSION["user_vec"])) {
                                            $user_row = Database::Search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user_vec"]["email"] . "' ");
                                            $un = $user_row->num_rows;
                                            if ($un == 1) {
                                                $ud = $user_row->fetch_assoc();
                                                if (!empty($ud["adress_id"])) {
                                                    $ad = Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $ud["adress_id"] . "'");
                                                    $add = $ad->fetch_assoc();
                                                    $df = Database::Search("SELECT * FROM `delivery_fee` WHERE `city_city_id`='" . $add["city_city_id"] . "' ");
                                                    $dfn = $df->num_rows;
                                                    if ($dfn == 1) {
                                                        $dfd = $df->fetch_assoc();
                                                        $deliveryfee = $dfd["fee"];
                                                    } else {
                                                        $deliveryfee = 00.00;
                                                    }
                                                } else {
                                                    $deliveryfee = 00.00;
                                                }
                                            }
                                        } else {
                                            $deliveryfee = 00.00;
                                        }
                                        // Default weight delivery fee
                                        $weigdeliveryfee = 0;
                                        if ($productdata["weight"] > 0) {
                                            $product_weight = $productdata["weight"];
                                            $dw = Database::Search("SELECT * FROM `weight` WHERE `weight` = '" . $product_weight . "'");
                                            if ($dw->num_rows == 1) {
                                                $dwd = $dw->fetch_assoc();
                                                $dfw = Database::Search("SELECT * FROM `delivery_fee_for_weight` WHERE `weight_id`='" . $dwd["id"] . "' ");
                                                if ($dfw->num_rows == 1) {
                                                    $dfwd = $dfw->fetch_assoc();
                                                    $weigdeliveryfee = $dfwd["fee"];
                                                }
                                            }
                                        }

                                        // Calculate final price
                                        $lastprice = $discount_due + $deliveryfee + $weigdeliveryfee;
                                        ?>

                                        <div class="flex-align gap-8">
                                            <span class="text-gray-700">Delivery Price:</span>
                                            <h6 class="text-xl text-gray-400 mb-0 fw-medium">Rs. <?php echo number_format($deliveryfee, 2); ?></h6>
                                        </div>

                                        <div class="flex-align gap-8">
                                            <span class="text-gray-700">Weight-based Additional Fee:</span>
                                            <h6 class="text-xl text-gray-400 mb-0 fw-medium">Rs. <?php echo number_format($weigdeliveryfee, 2); ?></h6>
                                        </div>

                                        <div class="flex-align gap-8 px-16 py-8 rounded-8 bg-black">
                                            <span class="text-white">Final Price:</span>
                                            <h6 class="text-2xl text-white fw-bold">Rs. <?php echo number_format($lastprice, 2); ?></h6>
                                        </div>
                                    </div>




                                    <div class="my-32 flex-align flex-wrap gap-12">
                                        <a class="px-12 py-8 text-sm rounded-8 flex-align gap-8 text-main-600 border border-gray-200 hover-border-main-600 hover-text-main-600">
                                            Guest Checkout
                                        </a>
                                        <a class="px-12 py-8 text-sm rounded-8 flex-align gap-8 text-main-600 border border-gray-200 hover-border-main-600 hover-text-main-600">
                                            IslandWild Delivery
                                        </a>
                                        <a class="px-12 py-8 text-sm rounded-8 flex-align gap-8 text-main-600 border border-gray-200 hover-border-main-600 hover-text-main-600">
                                            Best Prices
                                        </a>
                                    </div>

                                    <a href="contact.php" class="btn btn-black flex-center gap-8 rounded-8 py-16">
                                        <i class="ph ph-envelope-open text-lg"></i>
                                        Request More Information
                                    </a>

                                    <style>
                                        .pg-div {
                                            width: 277px;
                                        }
                                    </style>

                                    <div class="mt-32">
                                        <span class="fw-medium text-gray-900">100% Guarantee Safe Checkout</span>
                                        <div class="mt-10 pg-div">
                                            <img src="assets/images/thumbs/gateway-img.png" style="border-radius: 5px;" alt="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <?php
                        if (isset($_SESSION["user_vec"])) {
                            $user_row = Database::Search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user_vec"]["email"] . "' ");
                            $un = $user_row->num_rows;
                            if ($un == 1) {
                                $ud = $user_row->fetch_assoc();
                                if (!empty($ud["adress_id"])) {
                                    $ad = Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $ud["adress_id"] . "'");
                                    $add = $ad->fetch_assoc();
                                    $df = Database::Search("SELECT * FROM `delivery_fee` WHERE `city_city_id`='" . $add["city_city_id"] . "' ");
                                    $dfn = $df->num_rows;
                                    if ($dfn == 1) {
                                        $dfd = $df->fetch_assoc();
                                        $deliveryfee = $dfd["fee"];
                                    } else {
                                        $deliveryfee = 00.00;
                                    }
                                } else {
                                    $deliveryfee = 00.00;
                                }
                            }
                        ?>
                            <div class="product-details__sidebar py-40 px-32 border border-gray-100 rounded-16">
                                <div class="mb-32">
                                    <label for="delivery" class="h6 activePage mb-8 text-heading fw-semibold d-block">Delivery to</label>
                                    <div class="flex-align border border-gray-100 rounded-4 px-16">
                                        <span class="text-xl d-flex text-main-600">
                                            <i class="ph ph-map-pin"></i>
                                        </span>
                                        <?php
                                        if (!empty($ud["fname"]) && !empty($ud["lname"])) {
                                        ?>
                                            <div class="border-0 px-8 rounded-4 py-10 text-dark"><?php echo  $ud["fname"] . " " . $ud["lname"] ?></div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="border-0 px-8 rounded-4 py-10 text-dark"><a href="account.php" class="text-success text-decoration-underline small">Click Here To Update Your Profile Details.</a></div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="mb-32">
                                    <label for="stock" class="text-lg mb-8 text-heading fw-semibold d-block">Total Stock: <?php echo $batchdata["batch_qty"]; ?></label>
                                    <span class="text-xl d-flex">
                                        <i class="ph ph-location"></i>
                                    </span>
                                    <div class="d-flex rounded-4 overflow-hidden">
                                        <button type="button" class="quantity__minus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white" onclick="decreaseQty()">
                                            <i class="ph ph-minus"></i>
                                        </button>

                                        <input type="number" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-16" max="<?php echo $batchdata['batch_qty']; ?>" id="stock" value="1" min="1">

                                        <button type="button" class="quantity__plus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white" onclick="increaseQty()">
                                            <i class="ph ph-plus"></i>
                                        </button>
                                    </div>

                                </div>
                                <div class="mb-32">
                                    <?php

                                    if ($productdata["weight"] > 0) {
                                        $product_weight = $productdata["weight"];
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


                                    $price = $batchdata["selling_price"];
                                    $discountpre = $discount_percentage;
                                    $discountAmount = ($price * $discountpre) / 100;
                                    $finalPricePerItem = $price - $discountAmount;
                                    ?>
                                    <div class="flex-between flex-wrap gap-8 border-bottom border-gray-100 pb-16 mb-16">
                                        <span class="text-gray-500">Price</span>
                                        <h6 id="sellprice" class="text-lg mb-0">RS <?php echo $price; ?></h6>
                                    </div>
                                    <input id="iprice" type="hidden" value="<?php echo $price;  ?>" />
                                    <input type="hidden" id="price" value="<?php echo $finalPricePerItem; ?>">
                                    <div class="flex-between flex-wrap gap-8">
                                        <span class="text-gray-500" style="color: #FA6400 !important;">Discount -</span>
                                        <h6 class="text-lg mb-0" style="color: #FA6400 !important;">RS <?php echo $discountAmount; ?></h6>
                                    </div>
                                    <div class="flex-between flex-wrap gap-8" style="margin-top: 15px;">
                                        <span class="text-gray-500">Shipping +</span>
                                        <h6 id="shipin" class="text-lg mb-0">RS <?php echo ($deliveryfee + $weigdeliveryfee); ?></h6>
                                    </div>
                                    <a href="account.php" class="small text-decoration-underline text-secondary-emphasis">Update your shipping information to calculate the exact cost.</a>
                                    <div class="flex-between flex-wrap gap-8" style="margin-top: 15px;">
                                        <span class="text-gray-500">Total</span>
                                        <h6 id="fprice" class="text-lg mb-0">RS <?php echo $finalPricePerItem + $deliveryfee + $weigdeliveryfee; ?></h6>
                                    </div>
                                </div>
                                <script>
                                    function decreaseQty() {
                                        let stock = document.getElementById("stock");
                                        let currentQty = parseInt(stock.value);
                                        //  alert("hi");
                                        if (currentQty > 1) {
                                            currentQty--;
                                            stock.value = currentQty;

                                            let price = parseFloat(document.getElementById("price").value);
                                            let iprice = document.getElementById("iprice").value;
                                            let sellprice = document.getElementById("sellprice").innerText;
                                            let spin = parseFloat(document.getElementById("shipin").textContent.replace(/[^\d.]/g, ''));
                                            let tprice = currentQty * price;
                                            let ttprice = tprice + spin;
                                            var mol = Math.floor(iprice * (currentQty)); // simulate intdiv
                                            document.getElementById("sellprice").innerText = `RS ${mol.toFixed(2)}`;
                                            document.getElementById("fprice").innerHTML = `RS ${ttprice.toFixed(2)}`;
                                        }
                                    }

                                    function increaseQty() {
                                        let stock = document.getElementById("stock");
                                        let currentQty = parseInt(stock.value);
                                        let maxQty = parseInt(stock.max);

                                        if (currentQty < maxQty) {
                                            currentQty++;
                                            stock.value = currentQty;

                                            let price = parseFloat(document.getElementById("price").value);
                                            let iprice = document.getElementById("iprice").value;
                                            let sellprice = document.getElementById("sellprice").innerText;
                                            let spin = parseFloat(document.getElementById("shipin").textContent.replace(/[^\d.]/g, ''));
                                            let tprice = currentQty * price;
                                            let ttprice = tprice + spin;
                                            var mol = Math.floor(iprice * (currentQty)); // simulate intdiv
                                            document.getElementById("sellprice").innerText = `RS ${mol.toFixed(2)}`;
                                            document.getElementById("fprice").innerHTML = `RS ${ttprice.toFixed(2)}`;
                                        }
                                    }
                                </script>

                                <a onclick="adtocart(<?= $price ?>, <?= $discount_percentage ?>, <?= $batch_id ?>);" class="btn btn-main flex-center gap-8 rounded-8 py-16 fw-normal mt-48">
                                    <i class="ph ph-shopping-cart-simple text-lg"></i>
                                    Add To Cart
                                </a>
                                <a href="#" class="btn btn-outline-main rounded-8 py-16 fw-normal mt-16 w-100" style="display: none;">
                                    Buy Now
                                </a>

                                <div class="mt-32">
                                    <div class="px-16 py-8 bg-main-50 rounded-8 flex-between gap-24 mb-14">
                                        <span class="w-32 h-32 bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0">
                                            <i class="ph-fill ph-truck"></i>
                                        </span>
                                        <span class="text-sm text-neutral-600">Ship from <span class="fw-semibold">Vicstore</span> </span>
                                    </div>
                                </div>

                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="product-details__sidebar py-40 px-32 border border-gray-100 rounded-16">

                                <div class="mb-32">
                                    <label for="stock" class="text-lg mb-8 text-heading fw-semibold d-block">Total Stock: <?php echo $batchdata["batch_qty"]; ?></label>
                                    <span class="text-xl d-flex">
                                        <i class="ph ph-location"></i>
                                    </span>
                                    <div class="d-flex rounded-4 overflow-hidden">
                                        <button type="button" class="quantity__minus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white" onclick="decreaseQty()">
                                            <i class="ph ph-minus"></i>
                                        </button>

                                        <input type="number" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-16" max="<?php echo $batchdata['batch_qty']; ?>" id="stock" value="1" min="1">

                                        <button type="button" class="quantity__plus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white" onclick="increaseQty()">
                                            <i class="ph ph-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-32">
                                    <?php

                                    if ($productdata["weight"] > 0) {
                                        $product_weight = $productdata["weight"];
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


                                    $price = $batchdata["selling_price"];
                                    $discountpre = $discount_percentage;
                                    $discountAmount = ($price * $discountpre) / 100;
                                    $finalPricePerItem = $price - $discountAmount;
                                    ?>
                                    <div class="flex-between flex-wrap gap-8 border-bottom border-gray-100 pb-16 mb-16">
                                        <span class="text-gray-500">Price</span>
                                        <h6 id="sellprice" class="text-lg mb-0">RS <?php echo $price; ?></h6>
                                        <input id="iprice" type="hidden" value="<?php echo $price; ?>" />
                                        <input type="hidden" id="price" value="<?php echo $finalPricePerItem; ?>">
                                    </div>
                                    <div class="flex-between flex-wrap gap-8">
                                        <span class="text-gray-500" style="color: #FA6400 !important;">Discount -</span>
                                        <h6 class="text-lg mb-0" style="color: #FA6400 !important;">RS <?php echo $discountAmount; ?></h6>
                                    </div>
                                    <div class="flex-between flex-wrap gap-8" style="margin-top: 15px;">
                                        <span class="text-gray-500">Shipping +</span>
                                        <h6 id="shipin" class="text-lg mb-0">RS <?php echo ($deliveryfee + $weigdeliveryfee); ?></h6>
                                    </div>
                                    <a href="account.php" class="small text-decoration-underline text-secondary-emphasis">Please sign in or register to calculate the exact cost.</a>
                                    <div class="flex-between flex-wrap gap-8" style="margin-top: 15px;">
                                        <span class="text-gray-500">Total</span>
                                        <h6 id="fprice" class="text-lg mb-0">RS <?php echo $finalPricePerItem + $deliveryfee + $weigdeliveryfee; ?></h6>
                                    </div>
                                </div>
                                <script>
                                    function decreaseQty() {
                                        let stock = document.getElementById("stock");
                                        let currentQty = parseInt(stock.value);
                                        //  alert("hi");
                                        if (currentQty > 1) {
                                            currentQty--;
                                            stock.value = currentQty;

                                            let price = parseFloat(document.getElementById("price").value);
                                            let iprice = document.getElementById("iprice").value;
                                            let sellprice = document.getElementById("sellprice").innerText;
                                            let spin = parseFloat(document.getElementById("shipin").textContent.replace(/[^\d.]/g, ''));
                                            let tprice = currentQty * price;
                                            let ttprice = tprice + spin;
                                            var mol = Math.floor(iprice * (currentQty)); // simulate intdiv
                                            document.getElementById("sellprice").innerText = `RS ${mol.toFixed(2)}`;
                                            document.getElementById("fprice").innerHTML = `RS ${ttprice.toFixed(2)}`;
                                        }
                                    }

                                    function increaseQty() {
                                        let stock = document.getElementById("stock");
                                        let currentQty = parseInt(stock.value);
                                        let maxQty = parseInt(stock.max);

                                        if (currentQty < maxQty) {
                                            currentQty++;
                                            stock.value = currentQty;

                                            let price = parseFloat(document.getElementById("price").value);
                                            let iprice = document.getElementById("iprice").value;
                                            let sellprice = document.getElementById("sellprice").innerText;
                                            let spin = parseFloat(document.getElementById("shipin").textContent.replace(/[^\d.]/g, ''));
                                            let tprice = currentQty * price;
                                            let ttprice = tprice + spin;
                                            var mol = Math.floor(iprice * (currentQty)); // simulate intdiv
                                            document.getElementById("sellprice").innerText = `RS ${mol.toFixed(2)}`;
                                            document.getElementById("fprice").innerHTML = `RS ${ttprice.toFixed(2)}`;
                                        }
                                    }
                                </script>
                                <a onclick="beaddtocart(<?= $price ?>, <?= $discount_percentage ?>, <?= $batch_id ?>);" class="btn btn-main flex-center gap-8 rounded-8 py-16 fw-normal mt-48">
                                    <i class="ph ph-shopping-cart-simple text-lg"></i>
                                    Add To Cart
                                </a>
                                <script>
                                    function beaddtocart(price, dispre, batch_id) {
                                        var qty = document.getElementById("stock").value;
                                        for (let index = 0; index < qty; index++) {
                                            adtocart(price, dispre, batch_id);
                                        }
                                    }
                                </script>
                                <a href="#" class="btn btn-outline-main rounded-8 py-16 fw-normal mt-16 w-100" style="display: none;">
                                    Buy Now
                                </a>

                                <div class="mt-32">
                                    <div class="px-16 py-8 bg-main-50 rounded-8 flex-between gap-24 mb-14">
                                        <span class="w-32 h-32 bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0">
                                            <i class="ph-fill ph-identification-card"></i>
                                        </span>
                                        <span class="text-sm text-neutral-600 text-start"><span class="fw-semibold">Guest Checkout</span> is available.</span>
                                    </div>
                                </div>

                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="pt-80">
                    <div class="product-dContent border rounded-24">
                        <div class="product-dContent__header border-bottom border-gray-100 d-flex justify-content-end flex-wrap gap-16">

                            <a href="#" class="btn bg-color-one rounded-16 flex-align gap-8 text-main-600 hover-bg-main-600 hover-text-white">
                                <img src="assets/images/icon/satisfaction-icon.png" alt="">
                                100% Satisfaction Guaranteed
                            </a>
                        </div>
                        <div class="product-dContent__box">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
                                    <div class="mb-40">
                                        <h6 class="mb-24">Product Description</h6>
                                        <?php echo $productdata["description"];  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========================== Product Details Two End =========================== -->

        <!-- ========================== Similar Product Start ============================= -->
        <section class="new-arrival pb-80">
            <div class="container container-lg">
                <div class="section-heading">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0">You Might Also Like</h5>
                        <div class="flex-align gap-16">
                            <div class="flex-align gap-8">
                                <button type="button" id="new-arrival-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                    <i class="ph ph-caret-left"></i>
                                </button>
                                <button type="button" id="new-arrival-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                                    <i class="ph ph-caret-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="new-arrival__slider arrow-style-two">



                    <?php
                    // Get the brand and sub-category ID from the product data
                    $brandid = $productdata["brand_id"];
                    $subcatid = $productdata["sub_category_id"];

                    // Query to get products matching the brand and sub-category
                    $p1 = Database::Search("SELECT * FROM `product` WHERE `sub_category_id`='" . $subcatid . "' OR `brand_id`='" . $brandid . "' ");
                    $p1num = $p1->num_rows;

                    // Display the number of matching products
                    echo "Number of matching products: " . $p1num;

                    // Loop through the products
                    for ($io = 0; $io < $p1num; $io++) {
                        $p1d = $p1->fetch_assoc();

                        // Query to get batches for the current product
                        $b1 = Database::Search("SELECT * FROM `batch` WHERE `product_id`='" . $p1d["id"] . "' ");
                        $b1num = $b1->num_rows;

                        // Loop through the batches (you can add logic here to process batches)
                        for ($i = 0; $i < $b1num; $i++) {
                            $b1d = $b1->fetch_assoc();
                            $pr = Database::Search("SELECT * FROM `product` WHERE `id`='" . $b1d["product_id"] . "' ");
                            $pr =  $pr->fetch_assoc();
                            $discountid = 0;
                    ?>
                            <?php
                            $pic = Database::Search("SELECT * FROM `picture`  WHERE  `product_id`='" . $pr["id"] . "' AND `name`='Image 1' ");
                            $pic_d = $pic->fetch_assoc();
                            if (empty($pic_d["path"])) {
                                $path = "assets/images/thumbs/product-img7.png";
                            } else {
                                $path = 'admin-panel/' . $pic_d["path"];
                            }
                            ?>
                            <div>
                                <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="product-details.php?batch_id=<?php echo $b1d['id']; ?>&discount_id=<?php echo 0; ?>" class="product-card__thumb flex-center">
                                        <img src="<?php echo $path; ?>" alt="">
                                    </a>
                                    <div class="product-card__content p-sm-2 w-100 mt-0">
                                        <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                            <a href="product-details.php?batch_id=<?php echo $b1d['id']; ?>&discount_id=<?php echo 0; ?>" class="link text-line-2"><?php echo $pr["title"] ?></a>
                                        </h6>
                                        <div class="product-card__content mt-12">
                                            <div class="product-card__price mb-8">
                                                <span class="text-heading text-md fw-semibold ">Rs <?php echo $b1d["selling_price"] ?> <span class="text-gray-500 fw-normal"></span>
                                                    <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> Rs <?php echo $b1d["selling_price"] + 10; ?></span>
                                            </div>
                                            <a onclick="adtocart(<?= $b1d['selling_price']; ?>, <?= 0 ?>, <?= $b1d['id'] ?>);" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                                <i class="ph ph-shopping-cart-simple text-lg"></i>
                                                Add To Cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>


                </div>
            </div>
        </section>
        <!-- ========================== Similar Product End ============================= -->

        <!-- ========================== Shipping Section Start ============================ -->
        <section class="shipping mb-80" id="shipping">
            <div class="container container-lg">
                <div class="row gy-4">
                    <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="400">
                        <div class="shipping-item flex-align gap-16 rounded-16 bg-main-two-50 hover-bg-main-100 transition-2">
                            <span class="w-56 h-56 flex-center rounded-circle bg-main-two-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-car-profile"></i></span>
                            <div class="">
                                <h6 class="mb-0">IslandWild delivery</h6>
                                <span class="text-sm text-heading">IslandWild delivers right to your doorstep.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="600">
                        <div class="shipping-item flex-align gap-16 rounded-16 bg-main-two-50 hover-bg-main-100 transition-2">
                            <span class="w-56 h-56 flex-center rounded-circle bg-main-two-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-hand-heart"></i></span>
                            <div class="">
                                <h6 class="mb-0"> 100% Satisfaction</h6>
                                <span class="text-sm text-heading">100% Satisfaction Guaranteed.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="800">
                        <div class="shipping-item flex-align gap-16 rounded-16 bg-main-two-50 hover-bg-main-100 transition-2">
                            <span class="w-56 h-56 flex-center rounded-circle bg-main-two-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-credit-card"></i></span>
                            <div class="">
                                <h6 class="mb-0"> Secure Payments</h6>
                                <span class="text-sm text-heading">Secure Payments with iPay.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="1000">
                        <div class="shipping-item flex-align gap-16 rounded-16 bg-main-two-50 hover-bg-main-100 transition-2">
                            <span class="w-56 h-56 flex-center rounded-circle bg-main-two-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-chats"></i></span>
                            <div class="">
                                <h6 class="mb-0"> 24/7 Support</h6>
                                <span class="text-sm text-heading">24/7 service with IslandWild.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========================== Shipping Section End ============================ -->

        <?php require_once "footer.php"; ?>


        <script src="sahan.js"></script>
        <!-- Jquery js -->
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <!-- Bootstrap Bundle Js -->
        <script src="assets/js/boostrap.bundle.min.js"></script>
        <!-- Bootstrap Bundle Js -->
        <script src="assets/js/phosphor-icon.js"></script>
        <!-- Select 2 -->
        <script src="assets/js/select2.min.js"></script>
        <!-- Slick js -->
        <script src="assets/js/slick.min.js"></script>
        <!-- Slick js -->
        <script src="assets/js/count-down.js"></script>
        <!-- jquery UI js -->
        <script src="assets/js/jquery-ui.js"></script>
        <!-- wow js -->
        <script src="assets/js/wow.min.js"></script>
        <!-- AOS Animation -->
        <script src="assets/js/aos.js"></script>
        <!-- marque -->
        <script src="assets/js/marque.min.js"></script>
        <!-- marque -->
        <script src="assets/js/vanilla-tilt.min.js"></script>
        <!-- Counter -->
        <script src="assets/js/counter.min.js"></script>
        <!-- main js -->
        <script src="assets/js/main.js"></script>

        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>


    </body>

    </html>
<?php
}
?>