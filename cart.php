<?php
session_start();
include "connection.php";
if (isset($_SESSION["user_vec"])) {
    require_once "connection.php";
    $user_row = Database::Search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user_vec"]["email"] . "' ");
    $user_data = $user_row->fetch_assoc();

    $carto = 1;
    if ($carto > 0) {
?>


        <!DOCTYPE html>
        <html lang="en" class="color-two font-exo">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Title -->
            <title>replace_title</title>
            <!-- Favicon -->
            <link rel="shortcut icon" href="assets/images/logo/favicon.png">
            <!-- Include SweetAlert2 CSS and JS -->
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

            <!--==================== Overlay Start ====================-->
            <div class="overlay"></div>
            <!--==================== Overlay End ====================-->

            <!--==================== Sidebar Overlay End ====================-->
            <div class="side-overlay"></div>
            <!--==================== Sidebar Overlay End ====================-->

            <!-- ==================== Scroll to Top End Here ==================== -->
            <div class="progress-wrap">
                <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                    <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
                </svg>
            </div>
            <!-- ==================== Scroll to Top End Here ==================== -->

            <?php require_once "header.php"; ?>

            <!-- ========================= Breadcrumb Start =============================== -->
            <div class="breadcrumb mb-0 py-26 bg-main-two-50">
                <div class="container container-lg">
                    <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                        <h6 class="mb-0">Cart</h6>
                        <ul class="flex-align gap-8 flex-wrap">
                            <li class="text-sm">
                                <a href="index.php" class="text-gray-900 flex-align gap-8 hover-text-main-600">
                                    <i class="ph ph-house"></i>
                                    Home
                                </a>
                            </li>
                            <li class="flex-align">
                                <i class="ph ph-caret-right"></i>
                            </li>
                            <li class="text-sm text-main-600"> Product Cart </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- ========================= Breadcrumb End =============================== -->

            <!-- ================================ Cart Section Start ================================ -->
            <section class="cart py-80">
                <div class="container container-lg">
                    <div class="row gy-4">
                        <div class="col-xl-9 col-lg-8">
                            <div class=" border border-gray-100 rounded-8 px-40 py-48">

                                <?php
                                $cart = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_data["email"] . "' ");
                                $cartnum = $cart->num_rows;

                                for ($i = 0; $i < $cartnum; $i++) {
                                    $cartdata = $cart->fetch_assoc();
                                    $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $cartdata["batch_id"] . "' ");
                                    $batch_data = $batch->fetch_assoc();
                                    $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batch_data["product_id"] . "' ");
                                    $product_data = $product->fetch_assoc();
                                ?>
                                    <div class="row position-relative border border-gray-100 rounded-8 px-4 py-5" style="margin-top: 10px !important;">
                                        <div class="col-12 col-md-2 d-flex align-items-center justify-content-center">
                                            <a class="table-product__thumb flex-center ">
                                                <?php
                                                $pic = Database::Search("SELECT * FROM `picture` WHERE `id`='" . $product_data["picture_id"] . "' ");
                                                $pic_num = $pic->num_rows;
                                                if ($pic_num > 0) {
                                                    $pic_d = $pic->fetch_assoc();
                                                ?>
                                                    <img src="<?php echo $pic_d["path"] ?>" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="assets/images/thumbs/product-two-img1.png" alt="">
                                                <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                        <div class="col-12 col-md-10 d-flex align-items-center justify-content-center">
                                            <div class="row">
                                                <?php
                                                $qty = $cartdata["qty"];
                                                $price = $batch_data["selling_price"];
                                                $discountpre = $cartdata["discount"];
                                                $discountAmount = ($price * $discountpre) / 100;
                                                $finalPricePerItem = $price - $discountAmount;
                                                $calprice = $finalPricePerItem * $qty;
                                                ?>
                                                <div class="col-12 col-md-4 d-flex flex-column text-center ">
                                                    <a class="title text-dark fw-semibold text-line-2" tabindex="0"><?php $product_data["title"] ?></a>
                                                    <span id="s_price" class="text-13 text-secondary mb-0">Rs <?php echo $batch_data["selling_price"] ?></span>
                                                    <small>discount <?php echo $discountpre; ?>%</small>
                                                </div>
                                                <div class="col-6 col-md-4 d-flex flex-row justify-content-between align-items-center">
                                                    <button onclick="minprice(<?php echo $cartdata["qty"]; ?>,<?php echo $cartdata["id"]; ?>);" type="button" class="quantity__minus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-minus"></i>
                                                    </button>
                                                    <input id="qtyp" readonly type="number" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-4" value="<?php echo $cartdata["qty"]; ?>" min="1" max="<?php echo $cartdata["qty"]; ?>">
                                                    <button onclick="plusprice(<?php echo $cartdata["qty"]; ?>,<?php echo $cartdata["id"]; ?>);" type="button" class="quantity__plus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-6 col-md-3 d-flex flex-row align-items-center">
                                                    <span class="text-lg h6 mb-0 fw-semibold text-dark" id="allprice">Rs <?php echo $calprice; ?></span>
                                                </div>
                                                <div class="col-1 d-flex flex-row align-items-center justify-content-end">
                                                    <!-- Delete Icon -->
                                                    <i class="ph ph-x-circle text-2xl d-flex hover" style="position: absolute; top: 0; right: 0; cursor: pointer; margin: 8px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="flex-between flex-wrap gap-16 mt-16">
                                    <div class="flex-align gap-16" style="margin-top: 10px !important;">
                                        <input type="text" class="common-input" placeholder="Coupon Code">
                                        <button type="submit" class="btn btn-main py-18 w-100 rounded-8">Apply Coupon</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4">
                            <div class="cart-sidebar border border-gray-100 rounded-8 px-24 py-40">
                                <h6 class="text-xl mb-32">Cart Totals</h6>
                                <?php
                                $u = Database::Search("SELECT * FROM `user` WHERE `email`='" . $user_data["email"] . "' ");
                                $un = $u->num_rows;
                                if ($un == 1) {
                                    $ud = $u->fetch_assoc();
                                    if (!empty($ud["adress_id"])) {
                                        $ad =  Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $ud["adress_id"] . "'");
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
                                #
                                $cart = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_data["email"] . "' ");
                                $cartnum = $cart->num_rows;
                                if ($cartnum > 0) {
                                    $price_tot = 0;
                                    for ($i = 0; $i < $cartnum; $i++) {
                                        $cartdata = $cart->fetch_assoc();
                                        $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $cartdata["batch_id"] . "' ");
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
                                        }
                                    }
                                }
                                #
                                ?>
                                <?php
                                $cart = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_data["email"] . "' ");
                                $cartnum = $cart->num_rows;
                                if ($cartnum > 0) {
                                    $price_tot = 0;
                                    for ($i = 0; $i < $cartnum; $i++) {
                                        $cartdata = $cart->fetch_assoc();
                                        $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $cartdata["batch_id"] . "' ");
                                        $batch_data = $batch->fetch_assoc();
                                        $price = $batch_data["selling_price"];
                                        $discountpre = $cartdata["discount"];
                                        $discountAmount = ($price * $discountpre) / 100;
                                        $finalPricePerItem = $price - $discountAmount;
                                        $price_tot = ($finalPricePerItem * $cartdata["qty"]) + $price_tot;
                                    }
                                }
                                ?>
                                <div class="bg-color-three rounded-8 p-24">
                                    <div class="mb-32 flex-between gap-8">
                                        <span class="text-gray-900 font-heading-two">Subtotal</span>
                                        <span class="text-gray-900 fw-semibold"><?php echo $price_tot + $deliveryfee + $weigdeliveryfee; ?></span>
                                    </div>
                                    <div class="flex-between mb-3 text-center">
                                        <a href="profile.php" class=" font-heading-two text-success text-decoration-underline">Change Delivery Address</a>
                                    </div>
                                    <div class="mb-32 flex-between gap-8">
                                        <span class="text-gray-900 font-heading-two">Delivery Fee</span>
                                        <span class="text-gray-900 fw-semibold"><?php echo $deliveryfee ?></span>
                                    </div>
                                    <div class="mb-0 flex-between gap-8">
                                        <span class="text-gray-900 font-heading-two">Tax</span>
                                        <span class="text-gray-900 fw-semibold">00.00</span>
                                    </div>
                                </div>
                                <div class="bg-color-three rounded-8 p-24 mt-24">
                                    <div class="flex-between gap-8">
                                        <span class="text-gray-900 text-xl fw-semibold">Total</span>
                                        <span class="text-gray-900 text-xl fw-semibold"><?php echo $price_tot; ?></span>
                                    </div>
                                </div>
                                <a href="guest-checkout.php" class="btn btn-main mt-40 py-18 w-100 fw-bold h6 rounded-8 ">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ================================ Cart Section End ================================ -->

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


            <?php require "footer.php"; ?>


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



        </body>

        </html>
<?php
    }
}
?>