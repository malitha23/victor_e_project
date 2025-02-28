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

    <?php require_once "basic_header.php"; ?>

    <!-- ========================= Breadcrumb Start =============================== -->
    <div class="breadcrumb mb-0 py-26 bg-main-two-50">
        <div class="container container-lg">
            <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                <h6 class="mb-0">Guest Checkout</h6>
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
                    <li class="text-sm text-main-600"> Checkout </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- ================================= Checkout Page Start ===================================== -->
    <section class="checkout py-80">
        <div class="container container-lg">

            <div class="row">
                <div class="col-lg-7">
                    <form action="#" class="pe-xl-5">
                        <div class="row gy-3">
                            <div class="col-12 col-lg-6 mb-24">
                                <label for="first-name" class="text-neutral-900 text-lg mb-8 fw-medium">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="common-input" id="first-name" placeholder="Enter First Name">
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="last-name" class="text-neutral-900 text-lg mb-8 fw-medium">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="common-input" id="last-name" placeholder="Enter Last Name">
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="email" class="text-neutral-900 text-lg mb-8 fw-medium">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="common-input" id="email" placeholder="Enter Email Address">
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="mobile" class="text-neutral-900 text-lg mb-8 fw-medium">Mobile <span class="text-danger">*</span></label>
                                <input type="tel" class="common-input" id="mobile" placeholder="Enter Mobile Number">
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="district" class="text-neutral-900 text-lg mb-8 fw-medium">District <span class="text-danger">*</span></label>
                                <select id="district" class="common-input">
                                    <option value="" selected disabled>Select District</option>
                                    <option value="1">Colombo</option>
                                    <option value="2">Gampaha</option>
                                    <option value="3">Kandy</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="city" class="text-neutral-900 text-lg mb-8 fw-medium">City <span class="text-danger">*</span></label>
                                <select id="city" class="common-input">
                                    <option value="" selected disabled>Select District</option>
                                    <option value="1">Colombo</option>
                                    <option value="2">Gampaha</option>
                                    <option value="3">Kandy</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="address-line-1" class="text-neutral-900 text-lg mb-8 fw-medium">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" class="common-input" id="address-line-1" placeholder="Enter Address Line 1">
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="address-line-2" class="text-neutral-900 text-lg mb-8 fw-medium">Address Line 2</label>
                                <input type="text" class="common-input" id="address-line-2" placeholder="Enter Address Line 2 (Optional)">
                            </div>

                            <div class="col-12 mb-24">
                                <label for="address-line-2" class="text-neutral-900 text-lg mb-8 fw-medium">Additional Information</label>
                                <input type="text" class="common-input" id="address-line-2" placeholder="Enter Additional Information (Optional)">
                            </div>

                            <div class=" mb-40">
                                <div class="row ">
                                <div class="text-end text-decoration-underline">Have a coupon code ?</div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="flex-between flex-wrap gap-16 my-16 pb-10 px-10 border border-gray-100 rounded-8 ">
                                            <div class="flex-align gap-16" style="margin-top: 10px !important;">
                                                <input type="text" class="common-input" placeholder="Coupon Code">
                                                <button type="submit" class="btn btn-main py-18 w-100 rounded-8">Apply Coupon</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="checkout-sidebar">
                        <div class="bg-color-three rounded-8 p-24 text-center">
                            <span class="text-gray-900 text-xl fw-semibold">Your Orders</span>
                        </div>

                        <div class="border border-gray-100 rounded-8 px-24 py-40 mt-24">
                            <div class="mb-32 pb-32 border-bottom border-gray-100 flex-between gap-8">
                                <span class="text-gray-900 fw-medium text-xl font-heading-two">Product</span>
                                <span class="text-gray-900 fw-medium text-xl font-heading-two">Subtotal</span>
                            </div>

                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div>
                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div>
                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div>
                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div>


                            <div class="border-top border-gray-100 pt-30  mt-30">
                                <div class="mb-0 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Subtotal</span>
                                    <span class="text-gray-900 font-heading-two text-md fw-bold">Rs 859.00</span>
                                </div>
                                <div class="mb-0 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Discount</span>
                                    <span class="text-success-900 font-heading-two text-md fw-bold">- Rs 859.00</span>
                                </div>
                                <div class="mb-32 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Delivery</span>
                                    <span class="text-danger-900 font-heading-two text-md fw-bold">+ Rs 859.00</span>
                                </div>
                                <div class="mb-0 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Total</span>
                                    <span class="text-gray-900 font-heading-two text-md fw-bold">Rs 859.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-32">
                            <div class="payment-item">
                                <div class="form-check common-check common-radio py-16 mb-0">
                                    <input class="form-check-input" type="radio" name="payment" id="payment2" checked>
                                    <label class="form-check-label fw-semibold text-neutral-600" for="payment2">Credit or Debit</label>
                                </div>
                                <div class="payment-item__content px-16 py-24 rounded-8 bg-main-50 position-relative">
                                    <p class="text-gray-800">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                                </div>
                            </div>
                            <div class="payment-item">
                                <div class="form-check common-check common-radio py-16 mb-0">
                                    <input class="form-check-input" type="radio" name="payment" id="payment3">
                                    <label class="form-check-label fw-semibold text-neutral-600" for="payment3">Cash on delivery</label>
                                </div>
                                <div class="payment-item__content px-16 py-24 rounded-8 bg-main-50 position-relative">
                                    <p class="text-gray-800">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-0 pt-32 border-top border-gray-100">
                            <p class="text-gray-500">Your personal data will be used to process your order.</p>
                        </div>

                        <a href="guest-checkout.php" class="btn btn-main mt-10 py-18 w-100 rounded-8 mt-56">Place Order</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================= Checkout Page End ===================================== -->

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