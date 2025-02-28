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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <img src="assets/images/icon/preloader.gif" alt="">
    </div>
    <!--==================== Preloader End ====================-->

    <?php require_once "shop_header.php"; ?>

    <!-- ========================= Breadcrumb Start =============================== -->
    <div class="breadcrumb mb-0 py-26 bg-main-two-50">
        <div class="container container-lg">
            <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                <h6 class="mb-0">Shop</h6>
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
                    <li class="text-sm text-main-600"> Product Shop </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- =============================== Shop Section Start ======================================== -->
    <section class="shop py-80">
        <div class="container container-lg">
            <div class="row">

                <!-- Sidebar Start -->
                <div class="col-lg-3">
                    <div class="shop-sidebar">
                        <button type="button" class="shop-sidebar__close d-lg-none d-flex w-32 h-32 flex-center border border-gray-100 rounded-circle hover-bg-main-600 position-absolute inset-inline-end-0 me-10 mt-8 hover-text-white hover-border-main-600">
                            <i class="ph ph-x"></i>
                        </button>
                        <div class="shop-sidebar__box border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Product Category</h6>
                            <ul class="max-h-540 overflow-y-auto scroll-sm">
                                <?php
                                for ($i = 0; $i < 10; $i++) {
                                ?>
                                    <li class="mb-24">
                                        <a href="product-details.php" class="text-gray-900 hover-text-main-600">Mobile & Accessories (12)</a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Filter by Price</h6>
                            <div class="row">
                                <div class="flex-align gap-16" style="margin-top: 10px !important;">
                                    <input type="number" class="common-input" placeholder="From" value="">
                                    <input type="number" class="common-input" placeholder="To" value="">
                                </div>
                            </div>
                            <div class="row justify-content-center" style="margin-top: 15px;">
                            <button type="button" class="btn btn-main h-40 flex-align col-auto">Filter </button>
                            </div>
                        </div>


                        <div class="shop-sidebar__box rounded-8 p-5">
                            <img src="assets/images/thumbs/advertise-img1.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- Sidebar End -->

                <!-- Content Start -->
                <div class="col-lg-9">
                    <!-- Top Start -->
                    <div class="flex-between gap-16 flex-wrap mb-40 ">
                        <span class="text-gray-900">Showing 1-20 of 85 result</span>
                        <div class="position-relative flex-align gap-16 flex-wrap">
                            <div class="list-grid-btns flex-align gap-16">
                                <button type="button" class="w-44 h-44 flex-center border border-gray-100 rounded-6 text-2xl list-btn">
                                    <i class="ph-bold ph-list-dashes"></i>
                                </button>
                                <button type="button" class="w-44 h-44 flex-center border border-main-600 text-white bg-main-600 rounded-6 text-2xl grid-btn">
                                    <i class="ph ph-squares-four"></i>
                                </button>
                            </div>
                            <div class="position-relative text-gray-500 flex-align gap-4 text-14">
                                <label for="sorting" class="text-inherit flex-shrink-0">Sort by: </label>
                                <select class="form-control common-input px-14 py-14 text-inherit rounded-6 w-auto" id="sorting">
                                    <option value="1" selected>Popular</option>
                                    <option value="1">Latest</option>
                                    <option value="1">Trending</option>
                                    <option value="1">Matches</option>
                                </select>
                            </div>
                            <button type="button" class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn"><i class="ph-bold ph-funnel"></i></button>
                        </div>
                    </div>
                    <!-- Top End -->

                    <div class="list-grid-wrapper">

                        <div class="row">
                            <?php
                            for ($i = 0; $i < 3; $i++) {
                            ?>
                                <div class="col-6 col-md-4">
                                    <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                        <a href="product-details.php" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                                            <img src="assets/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset">
                                        </a>
                                        <div class="product-card__content mt-16">
                                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                                <a href="product-details.php" class="link text-line-2" tabindex="0">Taylor Farms Broccoli Florets Vegetables</a>
                                            </h6>
                                            <div class="mt-8">
                                                <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-main-two-600 rounded-pill" style="width: 35%"></div>
                                                </div>
                                                <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                            </div>

                                            <div class="product-card__price my-20">
                                                <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> Rs 28.99</span>
                                                <span class="text-heading text-md fw-semibold ">Rs 14.99 <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                            </div>

                                            <a href="cart.html" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium" tabindex="0">
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


                    <!-- Pagination Start -->
                    <ul class="pagination flex-center flex-wrap gap-16">
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100" href="#">
                                <i class="ph-bold ph-arrow-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100" href="#">01</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100" href="#">02</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100" href="#">03</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100" href="#">
                                <i class="ph-bold ph-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Pagination End -->
                </div>
                <!-- Content End -->

            </div>
        </div>
    </section>
    <!-- =============================== Shop Section End ======================================== -->

    <!-- ========================== Shipping Section Start ============================ -->
    <section class="shipping mb-24" id="shipping">
        <div class="container container-lg">
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="400">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-car-profile"></i></span>
                        <div class="">
                            <h6 class="mb-0">IslandWild Delivery</h6>
                            <span class="text-sm text-heading">IslandWild delivers right to your doorstep.</span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="600">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-hand-heart"></i></span>
                        <div class="">
                            <h6 class="mb-0"> 100% Satisfaction</h6>
                            <span class="text-sm text-heading">100% Satisfaction Guaranteed.</span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="800">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-credit-card"></i></span>
                        <div class="">
                            <h6 class="mb-0"> Secure Payments</h6>
                            <span class="text-sm text-heading">Secure Payments with iPay.</span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="shipping-item flex-align gap-16 rounded-16 bg-main-50 hover-bg-main-100 transition-2">
                        <span class="w-56 h-56 flex-center rounded-circle bg-main-600 text-white text-32 flex-shrink-0"><i class="ph-fill ph-chats"></i></span>
                        <div class="">
                            <h6 class="mb-0"> 24/7 Support</h6>
                            <span class="text-sm text-heading">We're here whenever you need us.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================== Shipping Section End ============================ -->


    <?php require_once "footer.php"; ?>



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