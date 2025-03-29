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
    <div class="preloader">
        <img src="assets/images/icon/preloader.gif" alt="">
    </div>
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
                                                    <a href="shop.php?category=<?php echo $category_data['id']; ?>&subcategory=<?php echo $subcategory_data['id']; ?>">
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
                    <img src="assets/images/bg/banner-two-bg.png" alt="" class="banner-img position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 z-n1 object-fit-cover rounded-24">
                    <div class="banner-item-two__slider">
                        <?php
                        $slider = Database::Search("SELECT * FROM `main_slider`");
                        $slidernum = $slider->num_rows;
                        for ($mains = 0; $mains < $slidernum; $mains++) {
                            $sliderd = $slider->fetch_assoc();
                            $fg = "assets/images/thumbs/banner-two-img.png";
                        ?>
                            <div class="banner-item-two">
                                <div class="banner-item-two__content">
                                    <span class="text-white mb-8 h6 wow bounceInDown"><?php echo $sliderd["title"]; ?></span>
                                    <h2 class="banner-item-two__title bounce text-white wow bounceInLeft"><?php echo $sliderd["description"]; ?></h2>
                                    <a href="shop.php" class="btn btn-outline-white d-inline-flex align-items-center rounded-pill gap-8 mt-48 wow bounceInUp">
                                        Shop Now<span class="icon text-xl d-flex"><i class="ph ph-shopping-cart-simple"></i> </span>
                                    </a>
                                </div>
                                <div class="banner-item-two__thumb position-absolute bottom-0 wow bounceInUp" data-wow-duration="1s" data-tilt data-tilt-max="12" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-scale="1.06">
                                    <img src="<?php echo "admin-panel/process/" . $sliderd["sub_path"]; ?>" alt="">
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
                            <img src="<?php echo $bimgA ?>" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                            <div class="flex-between flex-wrap gap-16">
                                <div class="">
                                    <span class="text-heading text-sm mb-8"><?php echo $adverdata["title"] ?></span>
                                    <h6 class="mb-0"><?php echo $adverdata["description"] ?></h6>
                                    <a href="shop.php" class="d-inline-flex align-items-center gap-8 mt-16 text-heading text-md fw-medium border border-top-0 border-end-0 border-start-0 border-gray-900 hover-text-main-two-600 hover-border-main-two-600">
                                        Shop Now
                                        <span class="icon text-md d-flex"><i class="ph ph-plus"></i></span>
                                    </a>
                                </div>
                                <div class="pe-xxl-4">
                                    <div class="row">
                                        <img src="<?php echo $adimgpath ?>" alt="">
                                    </div>
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
    $offers = Database::Search("SELECT * FROM `discount_group`");
    $offers_num = $offers->num_rows;
    for ($i = 0; $i < $offers_num; $i++) {
        $offers_details = $offers->fetch_assoc();
    ?>
        <section class="deals-weeek pt-80 overflow-hidden">
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
                            <img src="assets/images/thumbs/week-deal-img1.png" alt="">
                        </div>
                        <div class="deal-week-box__content px-sm-4 d-block w-100 text-center">
                            <h6 class="mb-20 wow bounceIn"><?php echo $offers_details["description"] ?></h6>
                            <?php
                            $phgd = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $offers_details["id"] . "' ");
                            $phgdd = $phgd->fetch_assoc();
                            $phdate = Database::Search("SELECT * FROM `discount_date_range` WHERE `id`='" . $phgdd["discount_date_range_id"] . "' ");
                            $phdatedeta = $phdate->fetch_assoc();
                            ?>
                            <div class="container text-center mt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="text-primary">Countdown Timer</h5>
                                        <span class="fw-bold text-dark"><?php echo $phdatedeta["start_date"] ?></span> -
                                        <span class="fw-bold text-danger"><?php echo $phdatedeta["end_date"] ?></span>
                                    </div>
                                    <div class="col-12">
                                        <div class="countdown mt-3 p-3 rounded bg-light shadow" id="countdown4">
                                            <ul class="countdown-list d-flex justify-content-center align-items-center gap-3">
                                                <li class="countdown-list__item d-flex flex-column align-items-center text-white  bg-dark p-3">
                                                    <span class="days fs-4 fw-bold">00</span>
                                                    <span class="fs-6"></span>
                                                </li>
                                                <li class="countdown-list__item d-flex flex-column align-items-center text-white  bg-dark p-3">
                                                    <span class="hours fs-4 fw-bold">00</span>
                                                    <span class="fs-6"></span>
                                                </li>
                                                <li class="countdown-list__item d-flex flex-column align-items-center text-white  bg-dark p-3">
                                                    <span class="minutes fs-4 fw-bold">00</span>
                                                    <span class="fs-6"></span>
                                                </li>
                                                <li class="countdown-list__item d-flex flex-column align-items-center text-white  bg-dark p-3">
                                                    <span class="seconds fs-4 fw-bold">00</span>
                                                    <span class="fs-6"></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-lg-block d-none flex-shrink-0 pe-xl-5" data-aos="zoom-in">
                            <div class="me-xxl-5">
                                <?php
                                if (empty($offers_details["image_path"])) {
                                    $disimgpath = "assets/images/thumbs/week-deal-img2.png";
                                } else {
                                    $disimgpath = "admin-panel/process/" . $offers_details["image_path"];
                                }
                                ?>
                                <div class="row d-flex align-items-end">
                                    <div class="col-3 bg-blur">
                                        <img class="img-fluid" src="<?php echo $disimgpath; ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        <span class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0"><?php echo  $dpro_data["discount_pre"]; ?> % Off </span>
                                        <?php
                                        $pr = Database::Search("SELECT * FROM `product` WHERE `id`='" . $bad["product_id"] . "' ");
                                        $pr =  $pr->fetch_assoc();
                                        ?>
                                        <?php
                                        $pic = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $pr["id"] . "' AND `name`='Image 1' ");
                                        $pic_d = $pic->fetch_assoc();
                                        if (empty($pic_d["path"])) {
                                        ?>
                                            <img src="assets/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset">
                                        <?php
                                        } else {
                                        ?>
                                            <img src="admin-panel/<?php echo $pic_d["path"]; ?>" alt="" class="w-auto max-w-unset">
                                        <?php
                                        }
                                        ?> </a>
                                    <div class="product-card__content mt-16">
                                        <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                            <a href="product-details.php" class="link text-line-2" tabindex="0"><?php echo $pr["title"]; ?></a>
                                        </h6>
                                        <div class="mt-8">
                                            <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-tertiary-600 rounded-pill" style="width: 35%"></div>
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
                                            <span class="text-heading text-md fw-semibold ">Rs <?php echo $nowprice; ?> <span class="text-gray-500 fw-normal">/Qty<?php echo $dpro_data["qty"] ?>Available for Discount</span> </span>
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
                                echo "<h6 class='fw-bold text-danger'>🔥 Maximum Sold Quantity: $max_qty</h6>";

                                // Fetch products with the same highest quantity
                                $in = Database::Search("SELECT batch_id FROM `invoice` WHERE `qty`='$max_qty'");
                                $inn = $in->num_rows;

                                if ($inn > 0) {
                            ?>
                                    <!-- Bootstrap Carousel -->
                                    <div id="topSellingCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <span class="fw-bold text-primary">🚀 Best-Selling Products</span>
                                            </div>

                                            <?php
                                            while ($ind = $in->fetch_assoc()) {
                                                $batch_id = $ind["batch_id"];
                                                $bach = Database::Search("SELECT * FROM `batch` WHERE id='$batch_id'");

                                                if ($bach->num_rows > 0) {
                                                    $batchdata = $bach->fetch_assoc();
                                                    $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "'");
                                                    $productdata = $product->fetch_assoc();
                                            ?>
                                                    <!-- Product Slide -->
                                                    <div class="carousel-item">
                                                        <div class="carousel-content text-center">
                                                            <?php
                                                            $pic = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" .  $productdata["id"] . "' AND `name`='Image 1' ");
                                                            $pic_d = $pic->fetch_assoc();
                                                            if (empty($pic_d["path"])) {
                                                                $pp = "assets/images/thumbs/deal-img.png";
                                                            } else {
                                                                $pp = "admin-panel/" . $pic_d["path"];
                                                            }
                                                            ?>
                                                            <img src="<?php echo $pp ?>" alt="Product Image" class="carousel-image">
                                                            <p class="carousel-text"><strong><?php echo $productdata["title"]; ?></strong> is a top-selling item! ✅</p>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                        <!-- Carousel Controls -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#topSellingCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#topSellingCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<h6 class='text-muted'>No sales data available.</h6>";
                            }
                            ?>

                            <!-- Background & CTA Section -->
                            <img src="assets/images/bg/deal-bg.png" alt="Background Image" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100">
                            <div class="py-xl-4">
                                <h6 class="mb-4 fw-semibold">Polaroid Now+ Gen 2 - White</h6>
                                <h5 class="mb-40 fw-semibold">Fresh Vegetables</h5>
                                <p class="text-muted">Shop top-quality products from trusted sellers. Explore unbeatable deals on electronics, fresh produce, and more—all in one place!</p>
                                <a href="cart.php" class="btn text-heading border-neutral-600 hover-bg-neutral-600 hover-text-white py-16 px-24 d-inline-flex align-items-center rounded-pill gap-8 fw-medium">
                                    Shop Now <i class="ph ph-shopping-cart text-xl d-flex"></i>
                                </a>
                            </div>

                            <!-- Promotional Image -->
                            <div class="d-md-block d-none mt-36">
                                <img src="assets/images/thumbs/deal-img.png" alt="Promotion">
                            </div>
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


                            $tsi = Database::Search("
            SELECT i.*, b.*, p.*, pic.path AS image_path 
            FROM `invoice` i
            JOIN `batch` b ON i.batch_id = b.id
            JOIN `product` p ON b.product_id = p.id
            LEFT JOIN `picture` pic ON p.id = pic.product_id AND pic.name = 'Image 1'
        ");

                            while ($id = $tsi->fetch_assoc()) {
                                $pat = !empty($id["image_path"]) ? "admin-panel/" . $id["image_path"] : "assets/images/thumbs/product-two-img7.png";

                                // Fetch total sold quantity for the batch
                                $tsic = Database::Search("SELECT SUM(qty) as total_sold FROM `invoice` WHERE `batch_id`='" . $id["batch_id"] . "'");
                                $tsicd = $tsic->fetch_assoc();
                                $tsqty = $tsicd["total_sold"] ?? 0;
                            ?>
                                <!-- Product Card Start -->
                                <div data-aos="fade-up" data-aos-duration="200">
                                    <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                        <a href="product-details.php" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                                       <div class="row">
                                       <img src="<?php echo $pat; ?>" alt="Product Image" class="w-auto max-w-unset">
                                       </div>
                                    </a>
                                        <div class="product-card__content mt-16">
                                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                                <a href="product-details.php" class="link text-line-2" tabindex="0"><?php echo htmlspecialchars($id["title"]); ?></a>
                                            </h6>
                                            <div class="mt-8">
                                                <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-tertiary-600 rounded-pill" style="width: <?php echo ($tsqty / $id["batch_qty"]) * 100; ?>%"></div>
                                                </div>
                                                <span class="text-gray-900 text-xs fw-medium mt-8">Sold: <?php echo $tsqty; ?>/<?php echo $id["batch_qty"]; ?></span>
                                            </div>

                                            <div class="product-card__price my-20">
                                                <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">Rs 28.99</span>
                                                <span class="text-heading text-md fw-semibold">Rs <?php echo $id["price"]; ?> <span class="text-gray-500 fw-normal">/Qty</span></span>
                                            </div>

                                            <a href="cart.php" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium" tabindex="0">
                                                Add To Cart <i class="ph ph-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Product Card End -->
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
    <section class="featured-products overflow-hidden">
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

                        <div class="row gy-4 featured-product-slider">
                            <?php
                            $bach = Database::Search("SELECT * FROM `batch`");
                            $bach_n = $bach->num_rows;
                            for ($i = 0; $i < $bach_n; $i++) {
                                $bach_d = $bach->fetch_assoc();
                                $pr = Database::Search("SELECT * FROM `product` WHERE `id`='" . $bach_d["product_id"] . "' ");
                                $pr =  $pr->fetch_assoc();
                                $discountid = 0;
                            ?>
                                <div class="col-xxl-6">
                                    <div class="featured-products__sliders">
                                        <div class="" data-aos="fade-up" data-aos-duration="800">
                                            <div class="mt-24 product-card d-flex gap-16 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                                <a href="product-details.php?batch_id=<?php echo $bach_d['id']; ?>&discount_id=<?php echo $discountid; ?>" class="product-card__thumb flex-center h-unset rounded-8 bg-gray-50 position-relative w-unset flex-shrink-0 p-24" tabindex="0">
                                                    <?php
                                                    $pic = Database::Search("SELECT * FROM `picture`  WHERE  `product_id`='" . $pr["id"] . "' AND `name`='Image 1' ");
                                                    $pic_d = $pic->fetch_assoc();
                                                    if (empty($pic_d["path"])) {
                                                    ?>
                                                        <img src="assets/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset">
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <div class="row">
                                                    <img  src="admin-panel/<?php echo $pic_d["path"]; ?>" alt="" class="w-auto max-w-unset">
                                                    </div>
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
                                                        <span class="text-heading text-md fw-semibold ">Rs <?php echo $bach_d["selling_price"] ?><span class="text-gray-500 fw-normal">/Qty</span><?php echo $bach_d["batch_qty"] ?></span>
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


                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4">
                    <div class="position-relative rounded-16 bg-light-purple overflow-hidden p-28 pb-0 z-1 text-center h-100" data-aos="fade-up" data-aos-duration="1000">
                        <img src="assets/images/bg/big-deal-pattern.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 cover-img">
                        <div class="py-xl-4 text-center">
                            <h4 class=" mb-20 text-dark">iPhone Smart Phone - Red</h>
                                <div class="flex-center gap-12 text-white h6 mt-3">
                                    <span class="text-dark">FROM</span>
                                    <h4 class="mb-8 text-dark">$890</h4>
                                    <span class="badge-style-two position-relative me-8 bg-main-two-600 text-white text-sm py-2 px-8 rounded-4">20% off</span>
                                </div>
                                <a href="shop.php" class="mt-16 mb-24 btn btn-main-two fw-medium d-inline-flex align-items-center rounded-pill gap-8" tabindex="0">
                                    Shop Now
                                    <span class="icon text-xl d-flex"><i class="ph ph-arrow-right"></i></span>
                                </a>
                        </div>
                        <img src="assets/images/thumbs/featured-product-img.png" alt="" class="d-xxl-inline-flex d-none wow bounceInUp">
                    </div>
                </div>
            </div>
        </div>
    </section>




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
                    <div class="d-lg-block d-none ps-32" data-aos="zoom-in" data-aos-duration="800">
                        <img src="assets/images/thumbs/expensive-offer1.png" alt="">
                    </div>
                    <div class="popular-products-box__content px-sm-4 d-block w-100 text-center py-20">
                        <div class="flex-align gap-16 justify-content-center" data-aos="zoom-in" data-aos-duration="800">
                            <h6 class="mb-0">Shop Our Most Popular Categories Today!</h6>
                        </div>
                    </div>
                    <div class="d-lg-block d-none" data-aos="zoom-in" data-aos-duration="800">
                        <img src="assets/images/thumbs/expensive-offer2.png" alt="">
                    </div>
                </div>

                <div class="row gy-4">
                    <?php
                    $category = Database::Search("SELECT * FROM `category`");
                    $category_num = $category->num_rows;

                    for ($i = 0; $i < $category_num; $i++) {
                        $category_data = $category->fetch_assoc();
                    ?>
                        <div class="col-xxl-3 col-xl-4 col-sm-6 col-xs-6 wow bounceIn">
                            <div class="product-card h-100 d-flex gap-16 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                <a href="product-details.php" class="product-card__thumb flex-center h-unset rounded-8 bg-gray-50 position-relative w-unset flex-shrink-0 p-24" tabindex="0">
                                    <img src="assets/images/thumbs/popular-img1.png" alt="" class="w-auto max-w-unset">
                                </a>
                                <div class="product-card__content flex-grow-1">
                                    <h6 class="title text-lg fw-semibold mb-12">
                                        <a href="product-details.php" class="link text-line-2" tabindex="0"><?php echo $category_data["name"]; ?></a>
                                    </h6>

                                    <?php
                                    // Fetch subcategories for the current category
                                    $subcategory = Database::Search("SELECT * FROM `sub_category` WHERE `category_id` = '" . $category_data["id"] . "'");
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
    <section class="top-vendor py-80 overflow-hidden">
        <div class="container container-lg">
            <div class=" p-24 rounded-16">

                <div class="row gy-4 vendor-card-wrapper">
                    <?php
                    $g = Database::Search("SELECT * FROM `group`");
                    $gn = $g->num_rows;
                    for ($i = 0; $i < $gn; $i++) {
                        $gd = $g->fetch_assoc();
                    ?>
                        <div class="col-xxl-3 col-lg-4 col-sm-6 wow bounceIn">
                            <div class="vendor-card text-center px-16 pb-24">
                                <div class="">
                                    <img src="assets/images/thumbs/vendor-logo1.png" alt="" class="vendor-card__logo m-12">
                                    <h6 class="title mt-32 text-lg"><?php echo $gd["group_name"]; ?></h6>
                                </div>
                                <div class="position-relative slick-arrows-style-three">

                                    <div class="vendor-card__list style-two mt-22">
                                        <?php
                                        $c = database::search("SELECT * FROM `category` WHERE `group_id`='" . $gd["id"] . "' ");
                                        $cn = $c->num_rows;
                                        for ($ic = 0; $ic <  $cn; $ic++) {
                                            $cd = $c->fetch_assoc();
                                        ?>
                                            <div class="">
                                                <div class="vendor-card__item bg-white rounded-circle flex-center">
                                                    <img src="assets/images/thumbs/vendor-two-img1.png" alt="">
                                                </div>
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
    <section class="day-sale">
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
    </section>
    <!-- ================================== Day Sale Section End =================================== -->

    <!-- ============================== Top Brand Section Start ==================================== -->
    <div class="top-brand py-80">
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
                    $bimgpath = empty($branddata["img_path"]) ? "assets/images/thumbs/top-brand-img1.png" : "admin-panel/" . $branddata["img_path"];
                ?>
                    <div class="top-brand__wrapper" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>">
                        <div class="top-brand__item flex-center rounded-8 transition-1 px-8">
                            <img src="<?php echo $bimgpath; ?>" alt="<?php echo $branddata["name"]; ?>">
                        </div>
                        <span class="brand-name"><?php echo $branddata["name"]; ?></span>
                    </div>
                <?php
                }
                ?>
            </div>
            <style>
                .top-brand__slider {
                    display: flex;
                    overflow-x: auto;
                    scroll-behavior: smooth;
                    padding: 20px 0;
                    gap: 20px;
                }

                .top-brand__wrapper {
                    text-align: center;
                    transition: transform 0.3s ease-in-out;
                }

                .top-brand__wrapper:hover {
                    transform: scale(1.1);
                }

                .top-brand__item {
                    width: 100px;
                    height: 100px;
                    background: white;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    transition: all 0.3s ease-in-out;
                }

                .top-brand__item:hover {
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                }

                .brand-name {
                    display: block;
                    margin-top: 10px;
                    font-weight: bold;
                    font-size: 14px;
                }
            </style>
        </div>
    </div>
    </div>
    <!-- ============================== Top Brand Section End ==================================== -->

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
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