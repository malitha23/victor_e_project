<?php require_once "connection.php"; ?>
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
    <?php
    if (isset($_GET['search']) && isset($_GET['subcategory'])) {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $subcategoryId = isset($_GET['subcategory']) ? $_GET['subcategory'] : '0';
        if ($subcategoryId != 0) {
            $isb = Database::Search("SELECT * FROM `sub_category` WHERE `id`='" . $subcategoryId . "' ");
            $isbd = $isb->fetch_assoc();

            $mhc = Database::Search("SELECT * FROM `category` WHERE `id`='" . $isbd["category_id"] . "' ");
            $mhcd = $mhc->fetch_assoc();

            $icatid = $mhcd["id"];

            $mhg = Database::Search("SELECT * FROM `group` WHERE `id`='" . $mhcd["group_id"] . "' ");
            $mhgd = $mhg->fetch_assoc();

            $igroupid = $mhgd["id"];
        } else {
            $icatid = 0;
            $igroupid = 0;
        }
    ?>
        <input id="igroupid" type="hidden" value="<?php echo $igroupid;  ?>" />
        <input id="icatid" type="hidden" value="<?php echo $icatid;  ?>" />
        <input id="isearch" type="hidden" value="<?php echo $searchTerm  ?>" />
        <input id="subid" type="hidden" value="<?php echo $subcategoryId  ?>" />
        <script>
            get();

            function get() {
                var igroupid = document.getElementById("igroupid").value;
                var icatid = document.getElementById("icatid").value;
                var search = document.getElementById("isearch").value;
                var subid = document.getElementById("subid").value;

                document.getElementById('searchtext').value = search;
                document.getElementById('groupset').value = igroupid;
                document.getElementById('catgoryset').value = icatid;
                document.getElementById('subcatagoryset').value = subid;
                advancesearch();
                {
                    document.getElementById('searchtext').value = "";
                    document.getElementById('groupset').value = "";
                    document.getElementById('catgoryset').value = "";
                    document.getElementById('subcatagoryset').value = "";
                } {
                    document.getElementById("igroupid").value = "";
                    document.getElementById("icatid").value = "";
                    document.getElementById("isearch").value = "";
                    document.getElementById("subid").value = "";
                } {
                    window.history.replaceState(null, null, window.location.pathname);
                }
            }
        </script>
    <?php
    }
    ?>

    <?php
    if (isset($_GET['category_id']) && isset($_GET['sub_categoryid'])) {
        $category_id = $_GET['category_id'];
        $sub_categoryid = $_GET['sub_categoryid'];

        $mhc = Database::Search("SELECT * FROM `category` WHERE `id`='" . $category_id . "' ");
        $mhcd = $mhc->fetch_assoc();

        $mhg = Database::Search("SELECT * FROM `group` WHERE `id`='" . $mhcd["group_id"] . "' ");
        $mhgd = $mhg->fetch_assoc();
    ?>
        <input id="mhc" type="hidden" value="<?php echo $category_id; ?>">
        <input id="mhsc" type="hidden" value="<?php echo $sub_categoryid; ?>">
        <input id="mhg" type="hidden" value="<?php echo $mhgd["id"]; ?>">

        <script>
            function mhfs() {
                const mhg = document.getElementById("mhg").value;
                const cid = document.getElementById("mhc").value;
                const scid = document.getElementById("mhsc").value;
                document.getElementById('groupset').value = mhg;
                document.getElementById('catgoryset').value = cid;
                document.getElementById('subcatagoryset').value = scid;
                advancesearch();
                {
                    document.getElementById('groupset').value = "";
                    document.getElementById('catgoryset').value = "";
                    document.getElementById('subcatagoryset').value = "";
                    document.getElementById("mhg").value = "";
                    document.getElementById("mhc").value = "";
                    document.getElementById("mhsc").value = "";
                } {
                    window.history.replaceState(null, null, window.location.pathname);
                }
            }
        </script>
    <?php
    }
    ?>


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
    <input type="number" value="0" readonly hidden id="groupset" />
    <input type="number" value="0" readonly hidden id="catgoryset" />
    <input type="number" value="0" readonly hidden id="subcatagoryset" />
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

                        <!-- Brand List Container -->
                        <div class="shop-sidebar__box border border-gray-100 rounded-8 p-3 mb-4">
                            <h6 class="text-xl border-bottom border-gray-100 pb-2 mb-3">Product Brands</h6>
                            <ul class="list-unstyled max-h-540 overflow-y-auto scroll-sm" id="brandList">
                                <?php
                                $brand = Database::Search("SELECT * FROM `brand` LIMIT 6");
                                $brandnum = $brand->num_rows;

                                for ($i = 0; $i < $brandnum; $i++) {
                                    $branddata = $brand->fetch_assoc();
                                ?>
                                    <li class="mb-2">
                                        <input onclick="advancesearch();" type="checkbox" id="brand<?php echo $branddata["id"]; ?>" value="<?php echo $branddata["id"]; ?>" />
                                        <button class="text-gray-900 hover-text-main-600">
                                            <?php echo $branddata["name"]; ?>
                                        </button>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                            <b id="mgb"></b>
                            <!-- See More Button -->
                            <div class="text-center mt-3">
                                <button class="btn btn-primary" id="seeMoreBtn" data-offset="6">See More</button>
                            </div>
                        </div>

                        <!-- Include jQuery -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <!-- AJAX Script to Load More Brands -->
                        <script>
                            $(document).ready(function() {
                                $('#seeMoreBtn').click(function() {
                                    var offset = $(this).data('offset');

                                    $.ajax({
                                        url: 'load_brands.php',
                                        type: 'POST',
                                        data: {
                                            offset: offset
                                        },
                                        success: function(response) {
                                            if (response == '<div class="text-center text-muted">No more brands available.</div>') {
                                                document.getElementById("mgb").innerHTML = response;
                                            } else {
                                                $('#brandList').append(response);
                                                $('#seeMoreBtn').data('offset', offset + 6);
                                            }
                                        }
                                    });
                                });
                            });
                        </script>

                        <!-- Condition Filter Section -->
                        <div class="border border-gray-100 rounded-8 p-4 mb-4 shadow-sm">
                            <h6 class="text-xl mb-3">Product Conditions</h6>
                            <?php
                            $condition = Database::Search("SELECT * FROM `condition`");
                            $conditionnum = $condition->num_rows;

                            for ($i = 0; $i < $conditionnum; $i++) {
                                $conditiondata = $condition->fetch_assoc();
                            ?>
                                <div class="form-check mb-2 fade-in" style="animation: fadeIn 0.5s;">
                                    <input onclick="advancesearch();" class="form-check-input" type="checkbox" value="<?php echo $conditiondata["id"]; ?>" id="condition_<?php echo $conditiondata["id"]; ?>" data-id="<?php echo $conditiondata["id"]; ?>" name="condition[]">
                                    <label class="form-check-label" for="condition_<?php echo $conditiondata["id"]; ?>">
                                        <?php echo $conditiondata["name"]; ?>
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                            <button onclick="check();">check condition</button>
                        </div>
                        <script>

                        </script>
                        <!-- Include Bootstrap CSS (Optional if already included) -->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

                        <!-- Animation CSS -->
                        <style>
                            @keyframes fadeIn {
                                0% {
                                    opacity: 0;
                                    transform: translateY(-10px);
                                }

                                100% {
                                    opacity: 1;
                                    transform: translateY(0);
                                }
                            }

                            .fade-in {
                                animation: fadeIn 0.5s ease-in-out;
                            }

                            .form-check-input:checked {
                                background-color: #0d6efd;
                                /* Bootstrap Primary Color */
                                border-color: #0d6efd;
                            }

                            .form-check-label {
                                transition: color 0.3s;
                            }

                            .form-check-input:checked+.form-check-label {
                                color: #0d6efd;
                            }
                        </style>

                        <div class="dis border border-gray-100 rounded-8 p-4 mb-4 shadow-sm">
                            <h6 class="dis-h text-xl mb-3">Product Discount</h6>
                            <div class="form-check mb-2 fade-in" style="animation: fadeIn 0.5s;">
                                <input onclick="advancesearch();" class="dis-check form-check-input" type="checkbox" id="discount" />
                                <label class="dis-label form-check-label" for="discount">
                                    Only show discounted products
                                </label>
                            </div>
                        </div>
                        <style>
                            /* Animation Keyframes */
                            @keyframes disColorChange {
                                0% {
                                    color: #00b894;
                                    text-shadow: 0 0 8px #ff7675;
                                }

                                33% {
                                    color: navy;
                                    text-shadow: 0 0 8px #0984e3;
                                }

                                66% {
                                    color: #00b894;
                                    text-shadow: 0 0 8px #00cec9;
                                }

                                100% {
                                    color: #e17055;
                                    text-shadow: 0 0 8px #d63031;
                                }
                            }

                            @keyframes disFadeIn {
                                0% {
                                    opacity: 0;
                                    transform: translateY(-20px);
                                }

                                100% {
                                    opacity: 1;
                                    transform: translateY(0);
                                }
                            }

                            /* Applying Animations */
                            .dis {
                                animation: disFadeIn 0.7s ease-out;
                                border-color: #e0e0e0;
                                background: linear-gradient(145deg, #ffffff, #f0f0f0);
                                border-radius: 12px;
                                padding: 20px;
                                transition: all 0.4s ease;
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                            }

                            .dis:hover {
                                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                                transform: translateY(-4px);
                            }

                            .dis-h {
                                animation: disColorChange 4s infinite alternate;
                                font-weight: 600;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                            }

                            .dis-check {
                                transition: all 0.3s;
                                cursor: pointer;
                            }

                            .dis-label {
                                transition: color 0.3s, text-shadow 0.3s;
                                cursor: pointer;
                            }

                            .dis-check:checked+.dis-label {
                                color: #0d6efd;
                                font-weight: bold;
                                text-shadow: 0 0 5px #00b894, 0 0 8px #0984e3;
                            }
                        </style>

                        <div class="border border-gray-100 rounded-8 p-32 mb-32">
                            <h6 class="text-xl border-bottom border-gray-100 pb-24 mb-24">Filter by Price</h6>
                            <div class="row">
                                <div class="flex-align gap-16" style="margin-top: 10px !important;">
                                    <input oninput="advancesearch();" type="number" id="minprice" class="common-input" placeholder="From" value="">
                                    <input oninput="advancesearch();" type="number" id="maxprice" class="common-input" placeholder="To" value="">
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
                                <label for="sorting" class="text-inherit flex-shrink-0">Sort by:</label>
                                <select onchange="advancesearch();" class="form-control common-input px-14 py-14 text-inherit rounded-6 w-auto" id="sorting">
                                    <option value="sort" selected>Sort by</option>
                                    <option value="Popular">Popular</option>
                                    <option value="Latest">Latest</option>
                                    <option value="Trending">Trending</option>
                                    <option value="Matches">Matches</option>
                                </select>
                            </div>
                            <button type="button" class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn"><i class="ph-bold ph-funnel"></i></button>
                        </div>
                    </div>
                    <!-- Top End -->

                    <div class="list-grid-wrapper" id="shopveiw">
                        <div class="row">
                            <?php
                            // Define items per page
                            $itemsPerPage = 20;

                            // Get the current page from URL (default to 1 if not set)
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                            // Calculate the starting point
                            $start = ($currentPage - 1) * $itemsPerPage;

                            // Get total number of products
                            $totalBatch = Database::Search("SELECT COUNT(*) as total FROM `batch`");
                            $totalBatchCount = $totalBatch->fetch_assoc()["total"];

                            // Calculate total pages
                            $totalPages = ceil($totalBatchCount / $itemsPerPage);

                            // Fetch limited product data for current page
                            $batch = Database::Search("SELECT * FROM `batch` LIMIT $start, $itemsPerPage");
                            $batchnum = $batch->num_rows;

                            for ($i = 0; $i <  $batchnum; $i++) {
                                $batchdata = $batch->fetch_assoc();
                                $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "' ");
                                $productdata = $product->fetch_assoc();
                                $picture = Database::Search("SELECT * FROM `picture` WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 1'");
                                $picturenum = $picture->num_rows;

                                if ($picturenum == 1) {
                                    $picturedata = $picture->fetch_assoc();
                                    $picturepath = $picturedata["path"];
                                } else {
                                    $picturepath = 'assets/images/thumbs/product-two-img2.png';
                                }
                            ?>
                                <div class="col-6 col-md-4">
                                    <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                        <a href="product-details.php" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative product-thumb-container">
                                            <img src="admin-panel/<?php echo $picturepath; ?>" alt="" class="product-thumb-img">
                                        </a>
                                        <div class="product-card__content mt-16">
                                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                                <a href="product-details.php" class="link text-line-2"><?php echo $productdata["title"]; ?></a>
                                            </h6>

                                            <div class="mt-8">
                                                <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-main-two-600 rounded-pill" style="width: 35%"></div>
                                                </div>
                                                <?php
                                                $invoice = Database::Search("SELECT * FROM `invoice` WHERE `product_id`='" . $productdata["id"] . "'");
                                                $invoicenum = $invoice->num_rows;
                                                ?>
                                                <span class="text-gray-900 text-xs fw-medium mt-8">Sold: <?php echo $invoicenum; ?></span>
                                            </div>

                                            <div class="product-card__price mt-3 mb-4 d-flex flex-column gap-1">
                                                <span class="text-secondary text-decoration-line-through fw-semibold fs-6">
                                                    Rs <?php echo $batchdata["selling_price"] + 10; ?>
                                                </span>
                                                <span class="text-dark fw-bold fs-5">
                                                    Rs <?php echo $batchdata["selling_price"]; ?>
                                                    <span class="text-muted fw-normal fs-6 ms-1">Quantity / <?php echo $batchdata["batch_qty"]; ?> Available</span>
                                                </span>
                                            </div>

                                            <a href="cart.html" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium">
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
                    <style>
                        .product-thumb-container {
                            height: 200px;
                            overflow: hidden;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .product-thumb-img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                            border-radius: 8px;
                        }
                    </style>
                    <!-- Pagination Start -->
                    <ul class="pagination flex-center flex-wrap gap-16 mt-4">
                        <!-- Previous Page Link -->
                        <?php if ($currentPage > 1) { ?>
                            <li class="page-item">
                                <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100" href="?page=<?php echo $currentPage - 1; ?>">
                                    <i class="ph-bold ph-arrow-left"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                                <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100" href="?page=<?php echo $i; ?>">
                                    <?php echo sprintf('%02d', $i); ?>
                                </a>
                            </li>
                        <?php } ?>

                        <!-- Next Page Link -->
                        <?php if ($currentPage < $totalPages) { ?>
                            <li class="page-item">
                                <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100" href="?page=<?php echo $currentPage + 1; ?>">
                                    <i class="ph-bold ph-arrow-right"></i>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!-- Pagination End -->

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

    <script src='sahan.js'></script>
    <?php
    if (isset($_GET['category_id']) && isset($_GET['sub_categoryid'])) {
    ?>
        <script>
            mhfs();
        </script>
    <?php
    }
    ?>
    <?php
    if (isset($_GET['search']) && isset($_GET['subcategory'])) {
    ?>
        <script>
            get();
        </script>
    <?php
    }
    ?>
</body>

</html>