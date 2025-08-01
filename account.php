<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="color-two font-exo">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Your Account – Manage Your Orders & Info</title>
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
<?php
if (isset($_SESSION["user_vec"])) {
    require_once "connection.php";
    $user_row = Database::Search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user_vec"]["email"] . "' ");
    $user_data = $user_row->fetch_assoc();
?>

    <body>

        <!--==================== Preloader Start ====================-->
        <div class="preloader">
            <img src="assets/images/icon/preloader.gif" alt="">
        </div>
        <!--==================== Preloader End ====================-->

        <?php require_once "basic_header.php"; ?>

        <!-- ========================= Breadcrumb Start =============================== -->
        <div class="breadcrumb mb-0 py-26 bg-main-two-50">
            <div class="container container-lg">
                <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                    <h6 class="mb-0">User Details</h6>
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
                        <li class="text-sm text-main-600"> User Details </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ========================= Breadcrumb End =============================== -->

        <!-- ============================== Vendor Two Details Start =============================== -->
        <section class="vendor-two-details py-80">
            <div class="container container-lg">
                <div class="row">
                    <!-- Shop Sidebar Start -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="d-flex flex-column gap-12 px-lg-0 px-3 py-lg-0 py-4">
                            <div class="bg-neutral-600 rounded-8 p-24">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="w-80 h-80 flex-center bg-white rounded-8 flex-shrink-0">
                                        <img src="assets/images/thumbs/user-svgrepo-com.svg" alt="">
                                    </span>
                                    <div class="d-flex flex-column gap-24">
                                        <button onclick="signout();" type="button" class="text-uppercase group border border-white px-16 py-8 rounded-pill text-white text-sm hover-bg-main-two-600 hover-text-white hover-border-main-two-600 transition-2 flex-center gap-8 w-100">
                                            Sign Out
                                            <span class="text-xl d-flex text-main-two-600 group-item-white transition-2"> <i class="ph ph-sign-out"></i></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-32">
                                    <h6 class="text-white fw-semibold mb-12">
                                        <a href="vendor-two-details.html" class=""><?php echo $user_data["fname"]; ?></a>
                                    </h6>
                                    <span class="text-xs text-white mb-12">Joined on <?php echo $user_data["date"]; ?></span>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-medium "><a href="" class="text-decoration-underline" style="color: #FA6800;">Go to Home</a></span>
                                    </div>
                                </div>
                                <div class="mt-32 d-flex flex-column gap-8">
                                    <a id="btnFirst" onclick="toggleDivs('first')" class="btn px-16 py-12 border text-white border-neutral-500 w-100 rounded-4 hover-bg-main-600 hover-border-main-600 btn-main">My Orders</>
                                        <a id="btnSecond" onclick="toggleDivs('seconds')" class="btn px-16 py-12 border text-white border-neutral-500 w-100 rounded-4 hover-bg-main-600 hover-border-main-600">Details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Shop Sidebar End -->

                    <!-- details 1 -->
                    <div class="col-12 col-md-6 col-lg-8" id="firstDiv">
                        <div class="border border-gray-100 rounded-16 px-24 py-40">
                            <h6 class="text-center text-main mb-48">My Orders</h6>



                            <?php
                            $order = Database::Search("SELECT * FROM `order` WHERE `user_email`='" . $user_data["email"] . "' ");
                            $ordernum = $order->num_rows;
                            for ($i = 0; $i < $ordernum; $i++) {
                                $orderdata = $order->fetch_assoc();
                                if ($orderdata["Order_status_id"] == 1 || $orderdata["Order_status_id"] == 0) {
                                } else {
                                    $trans = Database::Search("SELECT * FROM `transactions` WHERE `order_id`='" . $orderdata["id"] . "' ");
                                    $transnum = $trans->num_rows;
                                    if ($transnum == 1) {
                            ?>
                                        <div class="row border rounded-16 p-3 mt-10 hover-border-main-600 transition-1">
                                            <div class="col-12">
                                                <div class="row mt-10">
                                                    <!-- Left Side: Product Details -->
                                                    <div class="col-8 text-sm">
                                                        <p class="mb-0"><strong>Order ID : </strong><?php echo $orderdata["id"] ?></p>
                                                        <p class="mb-0"><strong>Date : </strong><?php echo $orderdata["date_time"] ?></p>
                                                    </div>
                                                    <?php
                                                    $ostatus = Database::Search("SELECT * FROM `order_status` WHERE `id`='" . $orderdata["Order_status_id"] . "' ");
                                                    $ostatusnum = $ostatus->num_rows;
                                                    for ($i = 0; $i < $ostatusnum; $i++) {
                                                        $osdata = $ostatus->fetch_assoc();
                                                    ?>
                                                        <!-- Right Side: Delivery Status Button -->
                                                        <?php

                                                        if ($transnum == 1) {
                                                            $transdata = $trans->fetch_assoc();
                                                            if ($transdata["transaction_status"] == 2) {
                                                        ?>
                                                                <div class="col-4 text-end">
                                                                    <button class="btn p-18 btn-main"><?php echo  $osdata["status"] ?></button>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="col-4 text-end">
                                                                    <button class="btn p-18 btn-main">ORDER Failed</button>
                                                                </div>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <div class="col-4 text-end">
                                                                <button class="btn p-18 btn-main">ORDER Failed</button>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="row px-10">
                                                    <?php
                                                    $invoice  = Database::Search("SELECT * FROM `invoice` WHERE `id`='" . $orderdata["invoice_id"] . "' ");
                                                    $invoicenum = $invoice->num_rows;
                                                    for ($x = 0; $x < $invoicenum; $x++) {
                                                        $invoicedata = $invoice->fetch_assoc();
                                                        $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $invoicedata["product_id"] . "' ");
                                                        $productdata = $product->fetch_assoc();
                                                    ?>
                                                        <!-- Order Item Start -->
                                                        <div class="col-12 d-flex align-items-center p-10 border-bottom">
                                                            <?php
                                                            $pic = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 1' ");
                                                            $pic_d = $pic->fetch_assoc();
                                                            if (empty($pic_d["path"])) {
                                                                $pth = "assets/images/thumbs/vendors-two-icon1.png";
                                                            } else {
                                                                $pth = "admin-panel/" . $pic_d["path"];
                                                            }
                                                            ?>
                                                            <img src="<?php echo $pth ?>" alt="Product Image" class="rounded me-10 img-fluid" width="80">
                                                            <div class="flex-grow-1">
                                                                <p class="mb-1 text-gray-500"><?php echo $productdata["title"]; ?></p>
                                                                <p class="mb-1 text-gray-500 text-sm">
                                                                    <span class="text-main me-10">Rs <?php echo $invoicedata["price"]; ?></span>
                                                                    <span class="text-success"><?php echo $invoicedata["qty"]; ?></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!-- Order Item End -->
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                            <!-- cash on delivery !-->
                            <?php
                            $cashon = Database::Search("SELECT * FROM `cashond` WHERE `email`='" . $user_data["email"] . "' ");
                            $cashon_num = $cashon->num_rows;
                            if ($cashon_num > 0) {
                                $corderdata = $cashon->fetch_assoc();

                            ?>
                                <div class="row border rounded-16 p-3 mt-10 hover-border-main-600 transition-1">
                                    <div class="col-12">
                                        <div class="row mt-10">
                                            <h5>cash on delivery</h5>
                                        </div>
                                        <div class="row mt-10">
                                            <!-- Left Side: Product Details -->
                                            <div class="col-8 text-sm">
                                                <p class="mb-0"><strong>Order ID : </strong><?php echo $corderdata["uniq_id"] ?></p>
                                                <p class="mb-0"><strong>Date : </strong><?php echo $corderdata["date"] ?></p>
                                            </div>
                                            <?php
                                            $costatus = Database::Search("SELECT * FROM `cashon_status` WHERE `id`='" . $corderdata["cashon_status_id"] . "' ");
                                            $costatusnum = $costatus->num_rows;
                                            for ($i = 0; $i < $costatusnum; $i++) {
                                                $cosdata = $costatus->fetch_assoc();
                                                $cancel = "Cancel Order";
                                            ?>
                                                <!-- Right Side: Delivery Status Button -->
                                                <div class="col-4 text-end">
                                                    <button class="btn p-18 btn-main"><?php echo  $cosdata["name"] ?></button>
                                                    <button class="btn p-18 btn-main unique-animation-class" onclick="confirmCancelOrder('<?php echo $corderdata["uniq_id"] ?>');"><?php echo $cancel ?></button>
                                                </div>
                                                <style>
                                                    .unique-animation-class {
                                                        opacity: 0;
                                                        transform: translateY(20px);
                                                        /* Start 20px below its final position */
                                                        animation: slideUp 0.6s ease-out forwards;
                                                    }

                                                    @keyframes slideUp {
                                                        from {
                                                            opacity: 0;
                                                            transform: translateY(20px);
                                                        }

                                                        to {
                                                            opacity: 1;
                                                            transform: translateY(0);
                                                        }
                                                    }
                                                </style>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="row px-10">
                                            <?php
                                            $cproduct = Database::Search("SELECT * FROM `product` WHERE `id`='" . $corderdata["product_id"] . "' ");
                                            $cproductdata = $cproduct->fetch_assoc();
                                            ?>
                                            <!-- Order Item Start -->
                                            <div class="col-12 d-flex align-items-center p-10 border-bottom">
                                                <?php
                                                $cpic = Database::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $cproductdata["id"] . "' AND `name`='Image 1' ");
                                                $cpic_d = $cpic->fetch_assoc();
                                                if (empty($cpic_d["path"])) {
                                                    $cpth = "assets/images/thumbs/vendors-two-icon1.png";
                                                } else {
                                                    $cpth = "admin-panel/" . $cpic_d["path"];
                                                }
                                                ?>
                                                <img src="<?php echo $cpth ?>" alt="Product Image" class="rounded me-10 img-fluid" width="80">
                                                <div class="flex-grow-1">
                                                    <p class="mb-1 text-gray-500"><?php echo $cproductdata["title"]; ?></p>
                                                    <p class="mb-1 text-gray-500 text-sm">
                                                        <span class="text-main me-10">Rs <?php echo $corderdata["totalprice"]; ?></span>
                                                        <span class="text-success"><?php echo $corderdata["qty"]; ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Order Item End -->

                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <!-- cash on delivery !-->
                        </div>
                    </div>


                    <!-- details 2 -->
                    <div class="col-12 col-md-6 col-lg-8 d-none" id="secondDiv">
                        <div class="border border-gray-100 hover-border-main-600 transition-1 rounded-16 px-24 py-40">
                            <h6 class="text-center text-main mb-48">User Details</h6>

                            <div class="row">
                                <div class="col-12 col-lg-6 mb-24">
                                    <label for="first-name" class="text-neutral-900 text-lg mb-8 fw-medium">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="common-input" id="first-name" placeholder="Enter First Name" value="<?php echo $user_data["fname"]; ?>">
                                </div>

                                <div class="col-12 col-lg-6 mb-24">
                                    <label for="last-name" class="text-neutral-900 text-lg mb-8 fw-medium">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="common-input" id="last-name" placeholder="Enter Last Name" value="<?php echo $user_data["lname"]; ?>">
                                </div>

                                <div class="col-12 col-lg-6 mb-24">
                                    <label for="mobile" class="text-neutral-900 text-lg mb-8 fw-medium">Mobile <span class="text-danger">*</span></label>
                                    <input type="tel" class="common-input" id="mobile" placeholder="Enter Mobile Number" value="<?php echo $user_data["mobile"]; ?>">
                                </div>

                                <div class="col-12 col-lg-6 mb-24">
                                    <label for="birthday" class="text-neutral-900 text-lg mb-8 fw-medium">Birthday <span class="text-danger">*</span></label>
                                    <input type="date" class="common-input" id="birthday" value="<?php echo $user_data["bod"]; ?>">
                                </div>
                                <?php
                                if (empty($user_data["adress_id"])) {
                                ?>
                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="district" class="text-neutral-900 text-lg mb-8 fw-medium">District <span class="text-danger">*</span></label>
                                        <select onchange="lordcity();" id="district" class="common-input">
                                            <option value="" selected disabled>Select District</option>
                                            <?php
                                            $dis = Database::Search("SELECT * FROM `distric` ");
                                            $dis_num  = $dis->num_rows;
                                            for ($i = 0; $i < $dis_num; $i++) {
                                                $dis_data = $dis->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $dis_data["distric_id"] ?>"><?php echo $dis_data["name"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="city" class="text-neutral-900 text-lg mb-8 fw-medium">City <span class="text-danger">*</span></label>
                                        <select id="city" class="common-input">
                                            <option value="" selected disabled>Select city</option>
                                            <?php
                                            $dis = Database::Search("SELECT * FROM `city` ");
                                            $dis_num  = $dis->num_rows;
                                            for ($i = 0; $i < $dis_num; $i++) {
                                                $dis_data = $dis->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $dis_data["city_id"] ?>"><?php echo $dis_data["name"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php
                                } else {
                                    $m = Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $user_data["adress_id"] . "' ");
                                    $mm = $m->fetch_assoc();
                                    $dis = Database::Search("SELECT * FROM `distric` WHERE `distric_id`='" . $mm["distric_distric_id"] . "' ");
                                    $distric = $dis->fetch_assoc();
                                ?>
                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="district" class="text-neutral-900 text-lg mb-8 fw-medium">District <span class="text-danger">*</span></label>
                                        <select onchange="lordcity();" id="district" class="common-input">
                                            <option value="<?php echo $distric["distric_id"] ?>" selected><?php echo $distric["name"] ?></option>
                                            <?php
                                            $dis = Database::Search("SELECT * FROM `distric` ");
                                            $dis_num  = $dis->num_rows;
                                            for ($i = 0; $i < $dis_num; $i++) {
                                                $dis_data = $dis->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $dis_data["distric_id"] ?>"><?php echo $dis_data["name"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                    $mn = Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $user_data["adress_id"] . "' ");
                                    $mmn = $mn->fetch_assoc();
                                    $city = Database::Search("SELECT * FROM `city` WHERE `city_id`='" . $mmn["city_city_id"] . "' ");
                                    $city_a = $city->fetch_assoc();
                                    ?>
                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="city" class="text-neutral-900 text-lg mb-8 fw-medium">City <span class="text-danger">*</span></label>
                                        <select id="city" class="common-input">
                                            <option value="<?php echo $city_a["city_id"]  ?>" selected><?php echo $city_a["name"]  ?></option>
                                            <?php
                                            $dis = Database::Search("SELECT * FROM `city` ");
                                            $dis_num  = $dis->num_rows;
                                            for ($i = 0; $i < $dis_num; $i++) {
                                                $dis_data = $dis->fetch_assoc();
                                            ?>
                                                <option value="<?php echo $dis_data["city_id"] ?>"><?php echo $dis_data["name"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php

                                ?>

                                <?php
                                $x = Database::Search("SELECT * FROM `address` WHERE `address_id`='" . $user_data["adress_id"] . "' ");
                                $xd = $x->fetch_assoc();
                                $xnum = $x->num_rows;
                                if ($xnum == 0) {
                                ?>
                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="address-line-1" class="text-neutral-900 text-lg mb-8 fw-medium">Address Line 1 <span class="text-danger">*</span></label>
                                        <input type="text" class="common-input" id="address-line-1" placeholder="Enter Address Line 1">
                                    </div>

                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="address-line-2" class="text-neutral-900 text-lg mb-8 fw-medium">Address Line 2</label>
                                        <input type="text" class="common-input" id="address-line-2" placeholder="Enter Address Line 2 (Optional)">
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="address-line-1" class="text-neutral-900 text-lg mb-8 fw-medium">Address Line 1 <span class="text-danger">*</span></label>
                                        <input type="text" class="common-input" id="address-line-1" placeholder="Enter Address Line 1" value="<?php echo $xd["line_1"] ?>">
                                    </div>

                                    <div class="col-12 col-lg-6 mb-24">
                                        <label for="address-line-2" class="text-neutral-900 text-lg mb-8 fw-medium">Address Line 2</label>
                                        <input type="text" class="common-input" id="address-line-2" placeholder="Enter Address Line 2 (Optional)" value="<?php echo $xd["line_2"] ?>">
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="mb-24">
                                    <label for="email" class="text-neutral-900 text-lg mb-8 fw-medium">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" readonly class="common-input" id="email" placeholder="Enter Email Address" value="<?php echo $user_data["email"] ?>">
                                </div>

                                <div class="mb-24">
                                    <label for="password" class="text-neutral-900 text-lg mb-8 fw-medium">Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input readonly type="password" class="common-input" id="password" placeholder="Enter Password" value="<?php echo $user_data["password"] ?>">
                                        <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash" onclick="togglePasswordVisibility('password')"></span>
                                    </div>
                                </div>

                                <div class="mb-24">
                                    <p class="text-gray-500">Your personal data will be used to process your order.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-48">
                                <button type="submit" class="btn btn-main py-18 px-40" onclick="updatepro();">Update</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- ============================== Vendor Two Details End =============================== -->

        <?php require_once "footer.php"; ?>



        <script src="assets/js/main.js"></script>
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
        <script src="sahan.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmCancelOrder(orderId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to cancel this order? This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, now send the XMLHttpRequest
                        sendCancellationRequest(orderId);
                    }
                });
            }

            function sendCancellationRequest(orderId) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "cashoordercan.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Handle the response from cashoordercan.php
                        var response = this.responseText;
                        if (response === "success") { // Assuming "success" is returned by PHP on success
                            Swal.fire(
                                'Cancelled!',
                                'Your order has been cancelled.',
                                'success'
                            ).then(() => {
                                // Optional: Reload the page or update UI after successful cancellation
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue cancelling your order: ' + response,
                                'error'
                            );
                        }
                    } else if (this.readyState == 4 && this.status != 200) {
                        Swal.fire(
                            'Error!',
                            'Failed to connect to the server. Please try again.',
                            'error'
                        );
                    }
                };

                // Send the orderId to cashoordercan.php
                xhr.send("uniq_id=" + orderId);
            }
        </script>
    </body>
<?php
} else {
?>
    <script>
        window.location.href = "register.php";
    </script>
<?php
}
?>

</html>