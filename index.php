<?php
include_once "connection.php";
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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
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
    <!-- <div class="preloader">
        <img src="assets/images/icon/preloader.gif" alt="">
    </div> -->
    <!--==================== Preloader End ====================-->

    <?php require_once "index_header.php"; ?>

    <!-- ============================ Banner Section start =============================== -->

    <div class="banner-two">
        <div class="container container-lg">
            <div class="banner-two-wrapper d-flex align-items-start">

                <div class="w-265 d-lg-block d-none flex-shrink-0">
                    <div class="responsive-dropdown style-two common-dropdown nav-submenu p-0 submenus-submenu-wrapper shadow-none border border-gray-100 position-relative border-top-0">
                        <button type="button" class="close-responsive-dropdown rounded-circle text-xl position-absolute inset-inline-end-0 inset-block-start-0 mt-4 me-8 d-lg-none d-flex"> <i class="ph ph-x"></i> </button>

                        <div class="logo px-16 d-lg-none d-block">
                            <a href="index.php" class="link">
                                <img src="assets/images/logo/logo.png" alt="Logo">
                            </a>
                        </div>

                        <ul class="responsive-dropdown__list scroll-sm p-0 py-8 overflow-y-auto">
                            <?php
                            $category = Database::Search("SELECT * FROM `category`");
                            $category_num = $category->num_rows;
                            for ($i = 0; $i < $category_num; $i++) {
                                $category_data = $category->fetch_assoc();
                            ?>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span><?php echo $category_data["name"]; ?></span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>

                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title"><?php echo $category_data["name"]; ?></h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">

                                            <?php
                                            $subcategory = Database::Search("SELECT * FROM `sub_category` WHERE `category_id` ='" . $category_data["id"] . "' ");
                                            $subcategory_num = $subcategory->num_rows;
                                            for ($j = 0; $j < $subcategory_num; $j++) {
                                                $subcategory_data = $subcategory->fetch_assoc();
                                            ?>
                                                <li>
                                                    <a href="shop.php?category_id=<?php echo $category_data['id']; ?>&sub_categoryid=<?php echo $subcategory_data['id']; ?>">
                                                        <?php echo $subcategory_data["name"]; ?>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>

                                        </ul>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="banner-item-two-wrapper rounded-24 overflow-hidden position-relative arrow-center flex-grow-1 mb-0">

                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <!-- Carousel indicators -->
                        <div class="carousel-indicators">
                            <?php
                            $slider = Database::Search("SELECT * FROM `main_slider`");
                            $slidernum = $slider->num_rows;
                            for ($bb = 0; $bb < $slidernum; $bb++) {
                                if ($bb == 0) {
                            ?>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <?php
                                } else {
                                ?>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $bb; ?>" aria-label="Slide <?php echo $bb; ?>"></button>
                            <?php
                                }
                            }
                            ?>
                        </div>

                        <!-- Carousel items -->
                        <div class="carousel-inner">

                            <?php
                            $slider->data_seek(0);
                            for ($mains = 0; $mains < $slidernum; $mains++) {
                                $sliderd = $slider->fetch_assoc();
                                $fg = "assets/images/thumbs/banner-two-img.png";
                            ?>
                                <div class="carousel-item <?php if ($mains == 0) {
                                                                echo "active";
                                                            } ?>">
                                    <div class="d-flex align-items-center w-100 min-vh-50 p-4 slide-bg" style="background-image: url('assets/images/bg/banner-two-bg.png'); background-size: cover; background-position: center;">
                                        <div class="container">
                                            <div class="row align-items-center text-white px-5">
                                                <div class="order-1 order-md-0 col-md-6 text-center text-md-start d-flex justify-content-center justify-content-md-start mb-68 mb-md-0">
                                                    <div class="banner-item-two__content ">
                                                        <span class="text-white mb-8 h6  bounceInDown"><?php echo $sliderd["title"]; ?></span>
                                                        <h2 class="banner-item-two__title bounce text-white  bounceInLeft"><?php echo $sliderd["description"]; ?></h2>
                                                        <a href="shop.php" class="btn btn-outline-white d-inline-flex align-items-center rounded-pill gap-8 mt-12 bounceInUp" style="z-index: 2;">
                                                            Shop Now<span class="icon text-xl d-flex"><i class="ph ph-shopping-cart-simple"></i> </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class=" col-md-6 text-center order-0 order-md-1" style="padding: 50px 0 50px 0;">
                                                    <img src="<?php echo "admin-panel/process/" . $sliderd["sub_path"]; ?>" class="img-fluid" style="width: 90%; border-radius: 15px;" alt="Banner Image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>

                        <style>
                            .cb {
                                background-color: transparent !important;
                                color: #fff !important;
                                font-size: 900 !important;
                            }
                        </style>

                        <!-- Carousel controls -->
                        <button class="carousel-control-prev " type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon cb" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next " type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon cb" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>


                <!-- Slider Script -->




            </div>
        </div>
    </div>
    <!-- ============================ Banner Section End =============================== -->

    <!-- ============================ promotional banner Start ========================== -->
    <section class="promotional-banner mt-32">
        <div class="container container-lg">
            <div class="row gy-4">
                <?php
                $adver = Database::Search("SELECT * FROM `advertisment`");
                $advernum = $adver->num_rows;
                for ($ia = 0; $ia < $advernum; $ia++) {
                    $adverdata = $adver->fetch_assoc();
                    if ($adverdata["add_p"] == 0) {
                        $bimgA = "assets/images/bg/promo-bg-img1.png";
                    } elseif ($adverdata["add_p"] == 1) {
                        $bimgA = "assets/images/bg/promo-bg-img2.png";
                    } else {
                        $bimgA = "assets/images/bg/promo-bg-img3.png";
                    }
                    if (empty($adverdata["path"])) {
                        $adimgpath = "assets/images/thumbs/promo-img1.png";
                    } else {
                        $adimgpath = "admin-panel/process/" . $adverdata["path"];
                    }
                ?>
                    <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="position-relative rounded-16 overflow-hidden z-1 p-32">
                            <img src="<?php echo $bimgA; ?>" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                            <div class="flex-between flex-wrap ">
                                <div class="col-6 col-md-7">
                                    <span class="text-heading text-sm mb-8"><?php echo $adverdata["title"] ?></span>
                                    <h6 class="mb-0"><?php echo $adverdata["description"] ?></h6>
                                    <a href="shop.php" class="d-inline-flex align-items-center gap-8 mt-16 text-heading text-md fw-medium border border-top-0 border-end-0 border-start-0 border-gray-900 hover-text-main-two-600 hover-border-main-two-600">
                                        Shop Now
                                        <span class="icon text-md d-flex"><i class="ph ph-plus"></i></span>
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 d-flex justify-content-end pe-xxl-4">
                                    <img src="<?php echo $adimgpath ?>" style="border-radius: 15px;" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!-- ============================ promotional banner End ========================== -->

    <!-- ========================= Seasonal Offers ================================ -->
    <?php
    $offers = Database::Search("SELECT * FROM `discount_group` WHERE `status`='1' ");
    $offers_num = $offers->num_rows;
    for ($i = 0; $i < $offers_num; $i++) {
        $offers_details = $offers->fetch_assoc();
        $phgd = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $offers_details["id"] . "' ");
        $phgdd = $phgd->fetch_assoc();
        $phdate = Database::Search("SELECT * FROM `discount_date_range` WHERE `id`='" . $phgdd["discount_date_range_id"] . "' ");
        $phdatedeta = $phdate->fetch_assoc();

        $currentDate = (new DateTime())->format("Y-m-d");
        $endDate =  $phdatedeta["end_date"];

        if (!($currentDate > $endDate)) {
    ?>
            <section class="deals-weeek pt-80 overflow-hidden" id="parent_countdown<?php echo $i; ?>">
                <div class="container container-lg">
                    <div class="border border-gray-100 p-24 rounded-16">
                        <div class="section-heading mb-24">
                            <div class="flex-between flex-wrap gap-8">
                                <h5 class="mb-0 wow bounceInLeft"><?php echo $offers_details["title"] ?></h5>
                                <div class="flex-align gap-16 wow bounceInRight">
                                    <a href="shop.php" class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">View All Deals</a>
                                    <div class="flex-align gap-8">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="deal-week-box rounded-16 overflow-hidden flex-between position-relative z-1 mb-24">
                            <img src="assets/images/bg/week-deal-bg.png" alt="" class="position-absolute inset-block-start-0 inset-block-start-0 w-100 h-100 z-n1 object-fit-cover">
                            <div class="d-lg-block d-none ps-32 flex-shrink-0" data-aos="zoom-in">
                                <img src="assets/images/thumbs/Adobe Express - file (2).jpg" style="border-radius: 10px;" alt="">
                            </div>
                            <div class="deal-week-box__content px-sm-4 d-block w-100 text-center">
                                <h6 class="mb-20 wow bounceIn"><?php echo strip_tags($offers_details["description"]); ?></h6>
                                <?php

                                ?>
                                <div class="countdown mt-20" id="countdown<?php echo $i; ?>">
                                    <ul class="countdown-list style-four flex-center flex-wrap">
                                        <li class="countdown-list__item flex-align flex-column text-sm fw-medium text-white rounded-circle bg-neutral-600">
                                            <span class="days"></span>Days
                                        </li>
                                        <li class="countdown-list__item flex-align flex-column text-sm fw-medium text-white rounded-circle bg-neutral-600">
                                            <span class="hours"></span>Hour
                                        </li>
                                        <li class="countdown-list__item flex-align flex-column text-sm fw-medium text-white rounded-circle bg-neutral-600">
                                            <span class="minutes"></span>Min
                                        </li>
                                        <li class="countdown-list__item flex-align flex-column text-sm fw-medium text-white rounded-circle bg-neutral-600">
                                            <span class="seconds"></span>Sec
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-lg-block d-none flex-shrink-0 pe-xl-5" data-aos="zoom-in">
                                <div class="me-xxl-5">
                                    <img src="assets/images/thumbs/Adobe Express - file (3).jpg" alt="">
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    initializeCountdown("countdown<?php echo $i; ?>", "<?php echo $phdatedeta["end_date"] ?>");
                                });
                            </script>

                        </div>

                        <div class="deals-week-slider arrow-style-two">

                            <?php
                            $dpro = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id` = '" . $offers_details["id"] . "' ");
                            $dpro_num = $dpro->num_rows;
                            for ($i = 0; $i < $dpro_num; $i++) {
                                $dpro_data = $dpro->fetch_assoc();
                                $BA = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $dpro_data["batch_id"] . "' ");
                                $bad = $BA->fetch_assoc();
                                $discountid = $dpro_data["id"];
                            ?>
                                <!-- product card start -->
                                <div data-aos="fade-up" data-aos-duration="200">
                                    <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                        <a href="product-details.php?batch_id=<?php echo $dpro_data['batch_id']; ?>&discount_id=<?php echo $discountid; ?>" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                                            <span class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">
                                                <?php echo  $dpro_data["discount_pre"]; ?>% Off
                                            </span>
                                            <?php
                                            $pr = Database::Search("SELECT * FROM `product` WHERE `id`='" . $bad["product_id"] . "' ");
                                            $pr =  $pr->fetch_assoc();
                                            $pic = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $pr["id"] . "' AND `name`='Image 1' ");
                                            $pic_d = $pic->fetch_assoc();
                                            $imgSrc = empty($pic_d["path"]) ? "assets/images/thumbs/product-two-img2.png" : "admin-panel/" . $pic_d["path"];
                                            ?>
                                            <img src="<?php echo $imgSrc; ?>" alt="Product Image" class="product-card-img img-fluid">
                                        </a>
                                        <style>
                                            .product-card-img {
                                                width: 100%;
                                                height: 220px;
                                                /* You can adjust this based on your card layout */
                                                object-fit: cover;
                                                border-radius: 8px;
                                            }
                                        </style>
                                        <div class="product-card__content mt-16 w-100 col-4">
                                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                                <a href="product-details.php" class="link text-line-2" tabindex="0"><?php echo $pr["title"]; ?></a>
                                            </h6>
                                            <div class="mt-8">
                                                <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-tertiary-600 rounded-pill" style="width: 35%; background-color: rgb(250,104,0) !important;"></div>
                                                </div>
                                                <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                            </div>

                                            <div class="product-card__price my-20">
                                                <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> Rs <?php echo $bad["selling_price"]; ?></span>
                                                <?php
                                                $batch_id = $dpro_data["batch_id"];
                                                $sprice = $bad["selling_price"];
                                                $discountpercentage = $dpro_data["discount_pre"];
                                                $nowprice = $sprice - ($sprice * $discountpercentage / 100);
                                                ?>
                                                <span class="text-heading text-md fw-semibold ">Rs <?php echo $nowprice; ?> <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                                <div class="col-12 small" style="color: rgb(255, 143, 68);">Only <?php echo $dpro_data["qty"] ?> items left at this special price!</div>
                                            </div>

                                            <a onclick="adtocart(<?= $sprice ?>, <?= $discountpercentage ?>, <?= $batch_id ?>);" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium" tabindex="0">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- product card end -->
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </section>
        <?php
        }

        ?>
    <?php
    }
    ?>
    <!-- ========================= Seasonal offers End ================================ -->


    <!-- ========================= Top Selling Products Start ================================ -->
    <section class="top-selling-products pt-80 overflow-hidden">
        <div class="container container-lg">
            <div class="border border-gray-100 p-24 rounded-16">
                <div class="section-heading mb-24">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0 wow bounceInLeft">Top Selling Products</h5>
                        <div class="flex-align gap-16 wow bounceInRight">
                            <a href="shop.php" class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">View All Deals</a>
                            <div class="flex-align gap-8">
                                <button type="button" id="top-selling-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                                    <i class="ph ph-caret-left"></i>
                                </button>
                                <button type="button" id="top-selling-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                                    <i class="ph ph-caret-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-12">
                    <div class="col-md-4" data-aos="zoom-in" data-aos-duration="800">
                        <div class="position-relative rounded-16 overflow-hidden p-28 z-1 text-center bg-white shadow-lg">

                            <?php
                            // Get the highest sold quantity and batch ID
                            $tss = Database::Search("SELECT batch_id, qty FROM `invoice` ORDER BY qty DESC LIMIT 1");
                            if ($tss->num_rows > 0) {
                                $tssd = $tss->fetch_assoc();
                                $max_qty = $tssd["qty"];

                                // Fetch products with the same highest quantity
                                $in = Database::Search("SELECT batch_id FROM `invoice` WHERE `qty`='$max_qty'");
                                $inn = $in->num_rows;

                                if ($inn > 0) {
                            ?>
                            <?php
                                }
                            } else {
                                echo "<h6 class='text-muted'>No sales data available.</h6>";
                            }
                            ?>

                            <!-- Background & CTA Section -->
                            <?php
                            $top = Database::Search("SELECT * FROM `top_selling_add`");
                            $topn = $top->num_rows;
                            if ($topn > 0) {
                                $topd = $top->fetch_assoc();
                            ?>
                                <img src="assets/images/bg/deal-bg.png" alt="Background Image" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100">
                                <div class="py-xl-4">
                                    <h5 class="mb-4 fw-semibold"><?php echo $topd["title"] ?></h5>
                                    <a href="shop.php" class="btn text-heading border-neutral-600 hover-bg-neutral-600 hover-text-white py-16 px-24 d-inline-flex align-items-center rounded-pill gap-8 fw-medium">
                                        Shop Now <i class="ph ph-shopping-cart text-xl d-flex"></i>
                                    </a>
                                </div>

                                <!-- Promotional Image -->
                                <div class="d-md-block d-none mt-36">
                                    <img src="admin-panel/<?php echo $topd["path"]; ?>" alt="Promotion" class="img-fluid" style="width: 200px; height: 150px;">
                                </div>
                            <?php
                            } else {
                            ?>
                                <img src="assets/images/bg/deal-bg.png" alt="Background Image" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100">
                                <div class="py-xl-4">
                                    <h6 class="mb-4 fw-semibold">Customer Favorites</h6>
                                    <h5 class="mb-40 fw-semibold">Hot Picks Just for You</h5>
                                    <a href="cart.php" class="btn text-heading border-neutral-600 hover-bg-neutral-600 hover-text-white py-16 px-24 d-inline-flex align-items-center rounded-pill gap-8 fw-medium">
                                        Shop Now <i class="ph ph-shopping-cart text-xl d-flex"></i>
                                    </a>
                                </div>

                                <!-- Promotional Image -->
                                <div class="d-md-block d-none mt-36">
                                    <img src="assets/images/thumbs/3d-illustration-laptop-with-shopping-basket-paper-bags-online-shopping-e-commerce-concept-min.jpg" class="img-fluid shadow" style="width: 303px; height: 213px; object-fit: cover; border-radius: 10px !important;" alt="Promotion">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!-- CSS Styling -->
                    <style>
                        .carousel-content {
                            text-align: center;
                            padding: 15px;
                            background: rgba(0, 0, 0, 0.6);
                            color: white;
                            border-radius: 10px;
                        }

                        .carousel-text {
                            font-size: 18px;
                            font-weight: bold;
                            margin-top: 10px;
                        }

                        .carousel-image {
                            max-width: 100px;
                            height: auto;
                            border-radius: 10px;
                            margin-bottom: 10px;
                        }

                        .carousel-control-prev-icon,
                        .carousel-control-next-icon {
                            background-color: black;
                            border-radius: 50%;
                            padding: 10px;
                        }
                    </style>


                    <div class="col-md-8">
                        <div class="top-selling-product-slider arrow-style-two">
                            <?php


                            $tsi = Database::Search("SELECT * FROM `invoice`");
                            $tsin = $tsi->num_rows;
                            for ($i = 0; $i < $tsin; $i++) {
                                $tsid = $tsi->fetch_assoc();
                                $tbatch = Database::Search("SELECT * FROM `batch` 
                                INNER JOIN `product` ON `batch`.`product_id` = `product`.`id` 
                                WHERE `batch`.`id` = '" . $tsid["batch_id"] . "' 
                                ORDER BY `product`.`date` 
                                LIMIT 1");
                                $tbatchd = $tbatch->fetch_assoc();
                                $tproduct = Database::Search("SELECT * FROM `product` WHERE `id`='" . $tbatchd["product_id"] . "' ");
                                $tproductd = $tproduct->fetch_assoc();
                                $tpic = Database::Search("SELECT * FROM `picture` WHERE `product_id`='" . $tproductd["id"] . "' AND `name`='Image 1' ");
                                $tpicd = $tpic->fetch_assoc();
                            ?>
                                <div data-aos="fade-up" data-aos-duration="200">
                                    <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                                        <!-- IMAGE AREA -->
                                        <a href="product-details.php?batch_id=<?php echo $tbatchd["id"]; ?>&discount_id=<?php echo 0; ?>" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative" style="height: 200px; overflow: hidden;">
                                            <img src="admin-panel/<?php echo $tpicd["path"]; ?>" alt="Product Image" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                        </a>

                                        <!-- CONTENT AREA -->
                                        <div class="product-card__content mt-16 w-100">
                                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                                <a href="product-details.php?batch_id=<?php echo $tbatchd["id"]; ?>&discount_id=<?php echo 0; ?>" class="link text-line-2" tabindex="0"><?php echo htmlspecialchars($tproductd["title"]); ?></a>
                                            </h6>

                                            <div class="mt-8">
                                                <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-tertiary-600 rounded-pill" style="width:fit-content"></div>
                                                </div>
                                                <span class="text-gray-900 text-xs fw-medium mt-8">Sold: <?php echo $tsid["qty"]; ?>/<?php echo $tbatchd["batch_qty"]; ?></span>
                                            </div>

                                            <div class="product-card__price my-20">
                                                <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">Rs <?php echo $tsid["price"] - 10; ?></span>
                                                <span class="text-heading text-md fw-semibold">Rs <?php echo $tsid["price"]; ?> <span class="text-gray-500 fw-normal">/Qty</span></span>
                                            </div>

                                            <a onclick="adtocart(<?= $tsid["price"] ?>, <?= 0 ?>, <?= $tbatchd["id"] ?>);" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium" tabindex="0">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ========================= Top Selling Products End ================================ -->


    <!-- ========================= New Products Start ================================ -->
    <section class="featured-products overflow-hidden pt-80">
        <div class="container container-lg">
            <div class="row g-4 flex-wrap-reverse">
                <div class="col-xxl-8">
                    <div class="border border-gray-100 p-24 rounded-16">
                        <div class="section-heading mb-24">
                            <div class="flex-between flex-wrap gap-8">
                                <h5 class="mb-0 wow bounceInLeft">New Products </h5>
                                <div class="flex-align gap-16 wow bounceInRight">
                                    <a href="shop.php" class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">View All Deals</a>
                                    <div class="flex-align gap-8">
                                        <button type="button" id="featured-products-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                                            <i class="ph ph-caret-left"></i>
                                        </button>
                                        <button type="button" id="featured-products-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                                            <i class="ph ph-caret-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            .product-image {
                                width: 100%;
                                height: 140px;
                            }
                        </style>

                        <div class="row gy-4 featured-product-slider">
                            <?php
                            $bach = Database::Search("SELECT * FROM `batch` 
                           INNER JOIN `product` ON `batch`.`product_id` = `product`.`id` 
                           ORDER BY `batch`.`date` ASC");
                            $bach_n = $bach->num_rows;
                            $col_2 = ceil($bach_n / 2);
                            for ($i = 0; $i < $col_2; $i++) {
                                if ($bach_n >= 2) {
                                    $b_times = 2;
                                } else {
                                    $b_times = 1;
                                }
                            ?>
                                <div class="col-xxl-6">
                                    <div class="featured-products__sliders">

                                        <?php
                                        for ($j = 0; $j < $b_times; $j++) {
                                            $bach_d = $bach->fetch_assoc();
                                            $pr = Database::Search("SELECT * FROM `product` WHERE `id`='" . $bach_d["product_id"] . "' ");
                                            $pr =  $pr->fetch_assoc();
                                            $discountid = 0;
                                        ?>
                                            <div class="" data-aos="fade-up" data-aos-duration="800">
                                                <div class="mt-24 product-card d-flex gap-16 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                                    <a href="product-details.php?batch_id=<?php echo $bach_d['id']; ?>&discount_id=<?php echo $discountid; ?>" class="product-card__thumb flex-center h-unset rounded-8 bg-gray-50 position-relative w-unset flex-shrink-0 p-24" tabindex="0">
                                                        <?php
                                                        $pic = Database::Search("SELECT * FROM `picture` WHERE `product_id`='" . $pr["id"] . "' AND `name`='Image 1' ");
                                                        $pic_d = $pic->fetch_assoc();
                                                        if (empty($pic_d["path"])) {
                                                        ?>
                                                            <img src="assets/images/thumbs/product-two-img2.png" alt="" class="product-image w-auto max-w-unset">
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="admin-panel/<?php echo $pic_d["path"]; ?>" alt="" class="product-image ">
                                                        <?php
                                                        }
                                                        ?>
                                                    </a>
                                                    <div class="product-card__content my-20 flex-grow-1">
                                                        <h6 class="title text-lg fw-semibold mb-12">
                                                            <a href="product-details.php" class="link text-line-2" tabindex="0"><?php echo $pr["title"] ?></a>
                                                        </h6>
                                                        <div class="product-card__price my-20">
                                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> Rs <?php echo $bach_d["selling_price"] + 20 ?></span>
                                                            <span class="text-heading text-md fw-semibold ">Rs <?php echo $bach_d["selling_price"] ?> <span class="text-gray-500 fw-normal">/Qty</span> <?php echo $bach_d["batch_qty"] ?></span>
                                                        </div>
                                                        <?php
                                                        $sprice = $bach_d["selling_price"];
                                                        $discountpercentage = 0;
                                                        $batch_id = $bach_d["id"];
                                                        ?>
                                                        <a onclick="adtocart(<?= $sprice ?>, <?= $discountpercentage ?>, <?= $batch_id ?>);" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium" tabindex="0">
                                                            Add To Cart <i class="ph ph-shopping-cart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            $bach_n = $bach_n - 1;
                                        }
                                        ?>

                                    </div>
                                </div>
                            <?php

                            }
                            ?>
                        </div>




                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- Custom Div -->
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />

    <section>
        <div class="container-fluid mt-80">

            <div class="row justify-content-center g-5 px-20 py-5" data-aos="fade-up" data-aos-duration="1000" id="aboutUsContainer"></div>

            <script>
                const aboutUsSections = [{
                        title1: "Who We Are",
                        title2: "Creative team from Lanka",
                        image: "assets/images/man-with-beer-svgrepo-com.svg",
                        href: "file-1.php"
                    },
                    {
                        title1: "What We Do",
                        title2: "Building online store platforms",
                        image: "assets/images/man-with-beer-svgrepo-com.svg",
                        href: "file-2.php"
                    },
                    {
                        title1: "Our Mission",
                        title2: "Empowering Lankan businesses",
                        image: "assets/images/man-with-beer-svgrepo-com.svg",
                        href: "file-3.php"
                    },
                    {
                        title1: "Why Choose Us",
                        title2: "Trusted by locals, built global",
                        image: "assets/images/man-with-beer-svgrepo-com.svg",
                        href: "file-4.php"
                    },
                    {
                        title1: "Our Vision",
                        title2: "Smart commerce for everyone",
                        image: "assets/images/man-with-beer-svgrepo-com.svg",
                        href: "file-5.php"
                    }
                ];

                const aboutUsContainer = document.getElementById("aboutUsContainer");

                aboutUsSections.forEach(section => {
                    aboutUsContainer.innerHTML += `
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <a href="${section.href}" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm hover-pop text-center c-card p-5">
            <div class="row">
              <div class="col-12 d-flex justify-content-center p-5">
                <img src="${section.image}" width="100px" style="margin-top: 20px;" alt="${section.title1}">
              </div>
            </div>
            <div class="card-body">
              <span class="text-heading text-sm mb-8">${section.title1}</span>
              <h6 class="mb-0">${section.title2}</h6>
              <div class="col-12">
              <a href="${section.href}" class="d-inline-flex align-items-center mt-16 text-heading text-md fw-medium border border-top-0 border-end-0 border-start-0 border-gray-900 hover-text-main-two-600 hover-border-main-two-600">
                View More
                <span class="icon text-md d-flex"><i class="ph ph-plus"></i></span>
              </a>
              </div>
            </div>
          </div>
        </a>
      </div>
    `;
                });
            </script>

        </div>
    </section>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- Hover Animation CSS -->
    <style>
        .hover-pop {
            transition: transform 0.3s ease;
        }

        .hover-pop:hover {
            transform: scale(1.05);
        }

        .c-card {
            background-image: url("assets/images/bgbgbg.jpg") !important;
            background-position: center !important;
            background-size: cover !important;
            /* background-color: #CAD6FF !important; */
            border-radius: 15px !important;
        }
    </style>



    <!-- ========================= Popular Categories Start ================================ -->
    <section class="popular-products pt-80 overflow-hidden">
        <div class="container container-lg">
            <div class="border border-gray-100 p-24 rounded-16">
                <div class="section-heading mb-24">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0 wow bounceInLeft">Popular Categories</h5>
                    </div>
                </div>

                <div class="popular-products-box rounded-16 overflow-hidden flex-between position-relative z-1 mb-24">
                    <img src="assets/images/bg/expensive-offer-bg.png" alt="" class="position-absolute inset-block-start-0 inset-block-start-0 w-100 h-100 z-n1">
                    <div class="d-lg-block d-none " data-aos="zoom-in" data-aos-duration="800">
                        <img src="assets/images/thumbs/34545.jpg" alt="">
                    </div>
                    <div class="popular-products-box__content px-sm-4 d-block w-100 text-center py-20">
                        <div class="flex-align gap-16 justify-content-center" data-aos="zoom-in" data-aos-duration="800">
                            <h6 class="mb-0">Shop Our Most Popular Categories Today!</h6>
                        </div>
                    </div>
                    <div class="d-lg-block d-none" data-aos="zoom-in" data-aos-duration="800">
                        <img src="assets/images/thumbs/23454.jpg" alt="">
                    </div>
                </div>

                <div class="row gy-4 d-flex justify-content-center">
                    <?php
                    $category = Database::Search("SELECT * FROM `category` LIMIT 6");
                    $category_num = $category->num_rows;

                    for ($i = 0; $i < $category_num; $i++) {
                        $category_data = $category->fetch_assoc();
                    ?>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 col-xs-6 wow bounceIn">
                            <div class="product-card h-100 d-flex gap-16 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 d-flex justify-content-start align-items-center">
                                <a href="product-details.php" class="product-card__thumb flex-center h-unset rounded-8 bg-white position-relative w-unset flex-shrink-0" tabindex="0">

                                    <img src="admin-panel/process/<?php echo $category_data["image_path"]; ?>" data-src="<?php echo $category_data['image_path']; ?>" alt="" class="lazyload img-fluid w-auto max-w-unset" loading="lazy" style="width: 100%; height: 120px; object-fit: cover; border-radius: 15px; background-position-y: top;">
                                </a>
                                <div class="product-card__content flex-grow-1">
                                    <h6 class="title text-lg fw-semibold mb-12">
                                        <a href="shop.php" class="link text-line-2" tabindex="0"><?php echo $category_data["name"]; ?></a>
                                    </h6>
                                    <?php
                                    // Fetch subcategories for the current category
                                    $subcategory = Database::Search("SELECT * FROM `sub_category` WHERE `category_id` = '" . $category_data["id"] . "' LIMIT 3");
                                    $subcategory_num = $subcategory->num_rows;

                                    for ($j = 0; $j < $subcategory_num; $j++) {
                                        $sub_data = $subcategory->fetch_assoc();
                                    ?>
                                        <span class="text-gray-600 text-sm mb-4"><?php echo $sub_data["name"]; ?></span><br>
                                    <?php
                                    }
                                    ?>

                                    <a href="shop.php" class="text-tertiary-600 flex-align gap-8 mt-24">
                                        All Categories
                                        <i class="ph ph-arrow-right d-flex"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                </div>



            </div>
        </div>
    </section>
    <!-- ========================= Popular Categories End ================================ -->


    <!-- =========================== Top Vendor Section Start ========================== -->
    <section class="top-vendor pt-80 overflow-hidden">
        <div class="container container-lg">
            <div class="p-24 rounded-16">
                <div class="row gy-4 vendor-card-wrapper d-flex justify-content-center">
                    <?php
                    $g = Database::Search("SELECT * FROM `group` LIMIT 6");
                    $gn = $g->num_rows;
                    for ($i = 0; $i < $gn; $i++) {
                        $gd = $g->fetch_assoc();
                    ?>
                        <div class="col-xxl-3 col-lg-4 col-sm-6 wow bounceIn">
                            <div class="vendor-card text-center px-16 pb-24">
                                <div class="">
                                    <img src="admin-panel/process/<?php echo $gd["image_path"]; ?>" alt="" class="vendor-card__logo m-12" style="width: 66px; height: 64px; border-radius: 15px;">
                                    <h6 class="title mt-32 text-lg"><?php echo $gd["group_name"]; ?></h6>
                                </div>
                                <div class="position-relative slick-arrows-style-three">
                                    <div class="vendor-card__list style-two mt-22">
                                        <?php
                                        $c = Database::search("SELECT * FROM `category` WHERE `group_id`='" . $gd["id"] . "' ");
                                        $cn = $c->num_rows;
                                        for ($ic = 0; $ic <  $cn; $ic++) {
                                            $cd = $c->fetch_assoc();
                                        ?>
                                            <div class="">
                                                <div>
                                                    <span><?php echo $cd["name"] ?></span>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================== Top Vendor Section End ========================== -->


    <!-- ================================== Day Sale Section Start =================================== -->
    <!-- <section class="day-sale">
        <div class="container container-lg">
            <div class="day-sale-box rounded-16 overflow-hidden flex-between position-relative mb-24 z-1">

                <img src="assets/images/bg/day-sale-bg.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 cover-img">
                <div class="d-xl-block d-none" data-aos="zoom-in" data-aos-duration="800">
                    <img src="assets/images/thumbs/day-sale-img1.png" alt="">
                </div>
                <div class="day-sale-box__content d-block w-100 text-start py-32 ps-lg-0 ps-24">
                    <h3 class="text-white fw-medium mb-24">CYBER MONDAY SALE</h3>
                    <h6 class="text-white fw-medium mb-8">UP TO 30% OFF</h6>
                    <h6 class="text-white fw-medium mb-0">COMPUTER & MOBILE ACCESSORIES</h6>
                    <a href="shop.php" class="btn btn-outline-white flex-align d-inline-flex rounded-pill gap-8 mt-28" tabindex="0">
                        Shop Now <i class="ph ph-plus text-xl d-flex"></i>
                    </a>
                </div>
                <div class="d-md-block d-none pe-xxl-5 pe-md-4" data-aos="zoom-in" data-aos-duration="800">
                    <img src="assets/images/thumbs/day-sale-img2.png" alt="">
                </div>
            </div>
        </div>
    </section> !-->
    <!-- ================================== Day Sale Section End =================================== -->

    <!-- ============================== Top Brand Section Start ==================================== -->
    <div class="top-brand pt-40 pb-80">
        <div class="container container-lg">
            <div class="p-24 rounded-16">
                <div class="section-heading mb-24">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Top Brands</h5>
                    </div>
                </div>
            </div>

            <div class="top-brand__slider">
                <?php
                $brand = database::Search("SELECT * FROM `brand`");
                $brandnum = $brand->num_rows;
                for ($i = 0; $i < $brandnum; $i++) {
                    $branddata = $brand->fetch_assoc();
                    $bimgpath = empty($branddata["img_path"]) ? "assets/images/thumbs/top-brand-img1.png" : "admin-panel/process/" . $branddata["img_path"];
                ?>
                    <div class="top-brand__wrapper" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>">
                        <div class="top-brand__item flex-center rounded-8 transition-1 px-8" style="width: 100px; height: 100px; object-fit: contain;">
                            <img src="<?php echo $bimgpath; ?>" alt="<?php echo $branddata["name"]; ?>">
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>

        </div>
    </div>
    </div>
    <!-- ============================== Top Brand Section End ==================================== -->

    <!-- ========================== Shipping Section Start ============================ -->
    <section class="shipping my-80" id="shipping">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        function initializeCountdown(elementId, endDate) {
            const second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;

            const countDown = new Date(endDate).getTime();

            const interval = setInterval(function() {
                const now = new Date().getTime(),
                    distance = countDown - now;

                const daysElement = document.querySelector(`#${elementId} .days`);
                const hoursElement = document.querySelector(`#${elementId} .hours`);
                const minutesElement = document.querySelector(`#${elementId} .minutes`);
                const secondsElement = document.querySelector(`#${elementId} .seconds`);

                if (daysElement && hoursElement && minutesElement && secondsElement) {
                    daysElement.innerText = Math.floor(distance / day);
                    hoursElement.innerText = Math.floor((distance % day) / hour);
                    minutesElement.innerText = Math.floor((distance % hour) / minute);
                    secondsElement.innerText = Math.floor((distance % minute) / second);
                }

                //do something later when date is reached
                if (distance < 0) {
                    const countdownElement = document.querySelector(`#${elementId}`);
                    if (countdownElement) {
                        countdownElement.style.display = "none";
                        document.getElementById("parent_" + elementId).style.display = "none";
                    }
                    clearInterval(interval);
                }
            }, 1000);
        }

        AOS.init({
            duration: 800,
            easing: "ease-in-out",
            once: true,
        });
    </script>



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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>