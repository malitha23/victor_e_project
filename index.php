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
                        <div class="banner-item-two">
                            <div class="banner-item-two__content">
                                <span class="text-white mb-8 h6 wow bounceInDown">Starting at only $250</span>
                                <h2 class="banner-item-two__title bounce text-white wow bounceInLeft">Get The Sound You Love For Less</h2>
                                <a href="shop.php" class="btn btn-outline-white d-inline-flex align-items-center rounded-pill gap-8 mt-48 wow bounceInUp">
                                    Shop Now<span class="icon text-xl d-flex"><i class="ph ph-shopping-cart-simple"></i> </span>
                                </a>
                            </div>
                            <div class="banner-item-two__thumb position-absolute bottom-0 wow bounceInUp" data-wow-duration="1s" data-tilt data-tilt-max="12" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-scale="1.06">
                                <img src="assets/images/thumbs/banner-two-img.png" alt="">
                            </div>
                        </div>
                        <div class="banner-item-two">
                            <div class="banner-item-two__content">
                                <span class="text-white mb-8 h6 wow bounceInDown">Starting at only $250</span>
                                <h2 class="banner-item-two__title bounce text-white wow bounceInLeft">Get The Sound You Love For Less</h2>
                                <a href="shop.php" class="btn btn-outline-white d-inline-flex align-items-center rounded-pill gap-8 mt-48 wow bounceInUp">
                                    Shop Now<span class="icon text-xl d-flex"><i class="ph ph-shopping-cart-simple"></i> </span>
                                </a>
                            </div>
                            <div class="banner-item-two__thumb position-absolute bottom-0 wow bounceInUp" data-wow-duration="1s" data-tilt data-tilt-max="12" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-scale="1.06">
                                <img src="assets/images/thumbs/banner-two-img2.png" alt="">
                            </div>
                        </div>
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
                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                    <div class="position-relative rounded-16 overflow-hidden z-1 p-32">
                        <img src="assets/images/bg/promo-bg-img1.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                        <div class="flex-between flex-wrap gap-16">
                            <div class="">
                                <span class="text-heading text-sm mb-8">Latest Deal</span>
                                <h6 class="mb-0">iPhone 15 Pro Max</h6>
                                <a href="shop.php" class="d-inline-flex align-items-center gap-8 mt-16 text-heading text-md fw-medium border border-top-0 border-end-0 border-start-0 border-gray-900 hover-text-main-two-600 hover-border-main-two-600">
                                    Shop Now
                                    <span class="icon text-md d-flex"><i class="ph ph-plus"></i></span>
                                </a>
                            </div>
                            <div class="pe-xxl-4">
                                <img src="assets/images/thumbs/promo-img1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                    <div class="position-relative rounded-16 overflow-hidden z-1 p-32">
                        <img src="assets/images/bg/promo-bg-img2.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                        <div class="flex-between flex-wrap gap-16">
                            <div class="">
                                <span class="text-heading text-sm mb-8">Get 60% Off</span>
                                <h6 class="mb-0">Instax Mini 11 Camera</h6>
                                <a href="shop.php" class="d-inline-flex align-items-center gap-8 mt-16 text-heading text-md fw-medium border border-top-0 border-end-0 border-start-0 border-gray-900 hover-text-main-two-600 hover-border-main-two-600">
                                    Shop Now
                                    <span class="icon text-md d-flex"><i class="ph ph-plus"></i></span>
                                </a>
                            </div>
                            <div class="pe-xxl-4">
                                <img src="assets/images/thumbs/promo-img2.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
                    <div class="position-relative rounded-16 overflow-hidden z-1 p-32">
                        <img src="assets/images/bg/promo-bg-img3.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 w-100 h-100 object-fit-cover z-n1">
                        <div class="flex-between flex-wrap gap-16">
                            <div class="">
                                <span class="text-heading text-sm mb-8">Start From $250</span>
                                <h6 class="mb-0">Airpod Headphone</h6>
                                <a href="shop.php" class="d-inline-flex align-items-center gap-8 mt-16 text-heading text-md fw-medium border border-top-0 border-end-0 border-start-0 border-gray-900 hover-text-main-two-600 hover-border-main-two-600">
                                    Shop Now
                                    <span class="icon text-md d-flex"><i class="ph ph-plus"></i></span>
                                </a>
                            </div>
                            <div class="pe-xxl-4">
                                <img src="assets/images/thumbs/promo-img3.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
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
                            <div class="countdown mt-20" id="countdown4">
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
                                <img src="assets/images/thumbs/week-deal-img2.png" alt="">
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
                        ?>
                            <!-- product card start -->
                            <div data-aos="fade-up" data-aos-duration="200">
                                <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                    <a href="product-details.php" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                                        <span class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0"><?php echo  $dpro_data["discount_pre"]; ?> % Off </span>
                                        <?php
                                        $pr = Database::Search("SELECT * FROM `product` WHERE `id`='" . $bad["product_id"] . "' ");
                                        $pr =  $pr->fetch_assoc();
                                        ?>
                                        <?php
                                        $pic = Database::Search("SELECT * FROM `picture`  WHERE `id`='" . $pr["picture_id"] . "' ");
                                        $pic_d = $pic->fetch_assoc();
                                        if (empty($pic_d["path"])) {
                                        ?>
                                            <img src="assets/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset">
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $pic_d["path"]; ?>" alt="" class="w-auto max-w-unset">
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
                        <div class="position-relative rounded-16 overflow-hidden p-28 z-1 text-center">
                            <img src="assets/images/bg/deal-bg.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100">
                            <div class="py-xl-4">
                                <h6 class="mb-4 fw-semibold">Polaroid Now+ Gen 2 - White</h6>
                                <h5 class="mb-40 fw-semibold">Fresh Vegetables</h5>
                                <a href="cart.php" class="btn text-heading border-neutral-600 hover-bg-neutral-600 hover-text-white py-16 px-24 flex-center d-inline-flex rounded-pill gap-8 fw-medium" tabindex="0">
                                    Shop Now <i class="ph ph-shopping-cart text-xl d-flex"></i>
                                </a>
                            </div>
                            <div class="d-md-block d-none mt-36">
                                <img src="assets/images/thumbs/deal-img.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="top-selling-product-slider arrow-style-two">

                            <?php
                            for ($i = 0; $i < 5; $i++) {
                            ?>
                                <!-- product card start -->
                                <div data-aos="fade-up" data-aos-duration="200">
                                    <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                        <a href="product-details.php" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                                            <img src="assets/images/thumbs/product-two-img7.png" alt="" class="w-auto max-w-unset">
                                        </a>
                                        <div class="product-card__content mt-16">
                                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                                <a href="product-details.php" class="link text-line-2" tabindex="0">Taylor Farms Broccoli Florets Vegetables</a>
                                            </h6>
                                            <div class="mt-8">
                                                <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-tertiary-600 rounded-pill" style="width: 35%"></div>
                                                </div>
                                                <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                            </div>

                                            <div class="product-card__price my-20">
                                                <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> Rs 28.99</span>
                                                <span class="text-heading text-md fw-semibold ">Rs 14.99 <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                            </div>

                                            <a href="cart.php" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium" tabindex="0">
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
                            for ($i = 0; $i < 3; $i++) {
                            ?>
                                <div class="col-xxl-6">
                                    <div class="featured-products__sliders">

                                        <?php
                                        $bach = Database::Search("SELECT * FROM `batch`");
                                        $bach_n = $bach->num_rows;
                                        for ($j = 0; $j < $bach_n; $j++) {
                                            $bach_d = $bach->fetch_assoc();
                                            $pr = Database::Search("SELECT * FROM `product` WHERE `id`='" . $bach_d["product_id"] . "' ");
                                            $pr =  $pr->fetch_assoc();
                                        ?>
                                            <div class="" data-aos="fade-up" data-aos-duration="800">
                                                <div class="mt-24 product-card d-flex gap-16 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                                    <a href="product-details.php" class="product-card__thumb flex-center h-unset rounded-8 bg-gray-50 position-relative w-unset flex-shrink-0 p-24" tabindex="0">
                                                        <?php
                                                        $pic = Database::Search("SELECT * FROM `picture`  WHERE `id`='" . $pr["picture_id"] . "' ");
                                                        $pic_d = $pic->fetch_assoc();
                                                        if (empty($pic_d["path"])) {
                                                        ?>
                                                            <img src="assets/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset">
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="<?php echo $pic_d["path"]; ?>" alt="" class="w-auto max-w-unset">
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
                                        <?php
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
                    for ($i = 0; $i < 3; $i++) {
                    ?>
                        <div class="col-xxl-3 col-lg-4 col-sm-6 wow bounceIn">
                            <div class="vendor-card text-center px-16 pb-24">
                                <div class="">
                                    <img src="assets/images/thumbs/vendor-logo1.png" alt="" class="vendor-card__logo m-12">
                                    <h6 class="title mt-32 text-lg">Organic Market</h6>
                                </div>
                                <div class="position-relative slick-arrows-style-three">

                                    <div class="vendor-card__list style-two mt-22">
                                        <div class="">
                                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                                <img src="assets/images/thumbs/vendor-two-img1.png" alt="">
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                                <img src="assets/images/thumbs/vendor-two-img2.png" alt="">
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                                <img src="assets/images/thumbs/vendor-two-img3.png" alt="">
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                                <img src="assets/images/thumbs/vendor-two-img4.png" alt="">
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                                <img src="assets/images/thumbs/vendor-two-img5.png" alt="">
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="vendor-card__item bg-white rounded-circle flex-center">
                                                <img src="assets/images/thumbs/vendor-two-img6.png" alt="">
                                            </div>
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
                for ($i = 0; $i < 10; $i++) {
                ?>
                    <div class="wow bounceIn">
                        <div class="top-brand__item flex-center rounded-8 transition-1 px-8">
                            <img src="assets/images/thumbs/top-brand-img1.png" alt="">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>