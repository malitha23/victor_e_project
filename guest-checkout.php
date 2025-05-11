<?php
session_start();
include "connection.php";

$encrypted_price = isset($_GET['total_price']) ? $_GET['total_price'] : 0;
$encrypted_fee = isset($_GET['weigdeliveryfee']) ? $_GET['weigdeliveryfee'] : 0;

// Decrypt the parameters using base64_decode
$total_price = base64_decode($encrypted_price);
$weigdeliveryfee = base64_decode($encrypted_fee);

$email = '';
if (isset($_SESSION["user_vec"])) {
    require_once "connection.php";

    $email = $_SESSION["user_vec"]["email"];

    $query = "SELECT 
                user.email, user.mail, user.fname, user.lname, user.mobile, user.bod, 
                user.status, user.password, user.date, user.adress_id, user.v_code,
                address.line_1, address.line_2, address.city_city_id, address.distric_distric_id,
                city.name AS city_name,
                distric.name AS district_name
              FROM user
              LEFT JOIN address ON user.adress_id = address.address_id
              LEFT JOIN city ON address.city_city_id = city.city_id
              LEFT JOIN distric ON address.distric_distric_id = distric.distric_id
              WHERE user.email = '$email'";

    $user_row = Database::Search($query);

    if ($user_row->num_rows > 0) {
        $user_data = $user_row->fetch_assoc();
    } else {
        $user_data = [];
    }
}
$cart_items = []; // Array to store cart items

?>

<!DOCTYPE html>
<html lang="en" class="color-two font-exo">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Secure Checkout – Complete Your Purchase</title>
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
                    <form id="placeOdersForm" class="pe-xl-5">
                        <div class="row gy-3">
                            <input type="hidden" id="userEmail" value="<?php echo htmlspecialchars($email); ?>">

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="first-name">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="common-input" id="first-name" name="fname" value="<?php echo isset($user_data['fname']) ? htmlspecialchars($user_data['fname']) : ''; ?>" required>
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="last-name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="common-input" id="last-name" name="lname" value="<?php echo isset($user_data['lname']) ? htmlspecialchars($user_data['lname']) : ''; ?>" required>
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="common-input" id="uemail" name="uemail" value="<?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : ''; ?>" required>
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                <input type="tel" class="common-input" id="mobile" name="mobile" value="<?php echo isset($user_data['mobile']) ? htmlspecialchars($user_data['mobile']) : ''; ?>">
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="district">District <span class="text-danger">*</span></label>
                                <select onchange="lordcityg();" id="district" name="district" class="common-input">
                                    <option value="" disabled selected>Select District</option>
                                    <?php if (isset($user_data['district_name']) && !empty($user_data['district_name'])) : ?>
                                        <option value="<?php echo $user_data['district_name']; ?>" selected>
                                            <?php echo $user_data['district_name']; ?>
                                        </option>
                                    <?php endif; ?>
                                    <?php
                                    $dis = Database::Search("SELECT * FROM `distric` ");
                                    $dis_num  = $dis->num_rows;
                                    for ($i = 0; $i < $dis_num; $i++) {
                                        $dis_data = $dis->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $dis_data["name"] ?>"><?php echo $dis_data["name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="city">City <span class="text-danger">*</span></label>
                                <select id="city" name="city" class="common-input">
                                    <option value="" disabled selected>Select City</option>
                                    <?php if (isset($user_data['city_name']) && !empty($user_data['city_name'])) : ?>
                                        <option value="<?php echo $user_data['city_name']; ?>" selected>
                                            <?php echo $user_data['city_name']; ?>
                                        </option>
                                    <?php endif; ?>
                                    <?php
                                    $dis = Database::Search("SELECT * FROM `city` ");
                                    $dis_num  = $dis->num_rows;
                                    for ($i = 0; $i < $dis_num; $i++) {
                                        $dis_data = $dis->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $dis_data["name"] ?>"><?php echo $dis_data["name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>


                            <div class="col-12 col-lg-6 mb-24">
                                <label for="address-line-1">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" class="common-input" id="address-line-1" name="address1" value="<?php echo isset($user_data['line_1']) ? htmlspecialchars($user_data['line_1']) : ''; ?>">
                            </div>

                            <div class="col-12 col-lg-6 mb-24">
                                <label for="address-line-2">Address Line 2</label>
                                <input type="text" class="common-input" id="address-line-2" name="address2" value="<?php echo isset($user_data['line_2']) ? htmlspecialchars($user_data['line_2']) : ''; ?>">
                            </div>

                            <div class="col-12 mb-24">
                                <label for="additional-info">Additional Information</label>
                                <input type="text" class="common-input" id="additional-info" name="additional_info" placeholder="Enter Additional Information (Optional)">
                            </div>

                            <!-- <div class="mb-40">
                                <div class="row">
                                    <div class="text-end text-decoration-underline">Have a coupon code?</div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <div
                                            class="flex-between flex-wrap gap-16 my-16 pb-10 px-10 border border-gray-100 rounded-8">
                                            <div class="flex-align gap-16" style="margin-top: 10px !important;">
                                                <input type="text" class="common-input" name="coupon"
                                                    placeholder="Coupon Code">
                                                <button type="submit" class="btn btn-main py-18 w-100 rounded-8">Apply
                                                    Coupon</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                    </form>

                </div>
                <div class="col-lg-5">
                    <div class="checkout-sidebar">
                        <div class="bg-color-three rounded-8 p-24 text-center">
                            <span class="text-gray-900 text-xl fw-semibold">Your Billing</span>
                        </div>

                        <div class="border border-gray-100 rounded-8 px-24 py-40 mt-24">
                            <!-- <div class="mb-32 pb-32 border-bottom border-gray-100 flex-between gap-8">
                                <span class="text-gray-900 fw-medium text-xl font-heading-two">Product</span>
                                <span class="text-gray-900 fw-medium text-xl font-heading-two">Subtotal</span>
                            </div>

                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook
                                        With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                            class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div>
                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook
                                        With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                            class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div>
                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook
                                        With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                            class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div>
                            <div class="flex-between gap-24 mb-32">
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 fw-normal text-md font-heading-two w-144">HP Chromebook
                                        With Intel Celeron</span>
                                    <span class="text-gray-900 fw-normal text-md font-heading-two"><i
                                            class="ph-bold ph-x"></i></span>
                                    <span class="text-gray-900 fw-semibold text-md font-heading-two">1</span>
                                </div>
                                <span class="text-gray-900 fw-bold text-md font-heading-two">Rs 250.00</span>
                            </div> -->


                            <div class="border-top border-gray-100 pt-30  mt-30">
                                <div class="mb-0 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Subtotal</span>
                                    <span class="text-gray-900 font-heading-two text-md fw-bold">Rs
                                        <?php echo htmlspecialchars($total_price); ?></span>
                                </div>
                                <div class="mb-0 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Discount</span>
                                    <span class="text-success-900 font-heading-two text-md fw-bold" id="disPrice">- Rs
                                        0.00</span>
                                </div>
                                <div class="mb-32 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Delivery</span>
                                    <span class="text-danger-900 font-heading-two text-md fw-bold">+ Rs
                                        <?php echo htmlspecialchars($weigdeliveryfee); ?></span>
                                </div>
                                <div class="mb-0 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two text-xl fw-semibold">Total</span>
                                    <span class="text-gray-900 font-heading-two text-md fw-bold" id="totalPrice">Rs
                                        <?php echo htmlspecialchars($total_price + $weigdeliveryfee); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-between flex-wrap gap-16 mt-16" style="justify-content: center; display: none;">
                            <div class="flex-align gap-16" style="margin: auto;">
                                <input type="text" id="couponCode" class="common-input" placeholder="Coupon Code">
                                <button type="submit" class="btn btn-main py-18 w-100 rounded-8" id="applyCoupon">Apply
                                    Coupon</button>
                            </div>
                            <p id="couponMessage" style="color: red;"></p>
                        </div>

                        <div class="mt-32">
                            <div class="payment-item">
                                <div class="form-check common-check common-radio py-16 mb-0">
                                    <input class="form-check-input" type="radio" name="payment" id="payment2" checked>
                                    <label class="form-check-label fw-semibold text-neutral-600" for="payment2">Credit
                                        or Debit</label>
                                </div>
                                <div class="payment-item__content px-16 py-24 rounded-8 bg-main-50 position-relative">
                                    <p class="text-gray-800">Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order will not be shipped until
                                        the funds have cleared in our account.</p>
                                </div>
                            </div>
                            <div class="payment-item">
                                <div class="form-check common-check common-radio py-16 mb-0">
                                    <input class="form-check-input" type="radio" name="payment" id="payment3">
                                    <label class="form-check-label fw-semibold text-neutral-600" for="payment3">Cash on
                                        delivery</label>
                                </div>
                                <div class="payment-item__content px-16 py-24 rounded-8 bg-main-50 position-relative">
                                    <p class="text-gray-800">Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order will not be shipped until
                                        the funds have cleared in our account.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-0 pt-32 border-top border-gray-100">
                            <p class="text-gray-500">Your personal data will be used to process your order.</p>
                        </div>

                        <a class="btn btn-main mt-10 py-18 w-100 rounded-8 mt-56" id="placeOders">Place
                            Order</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================================= Checkout Page End ===================================== -->

    <?php require_once "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="assets/js/guest-checkout.js"></script>
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



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const citySelect = document.getElementById("city");
            const deliverySpan = document.querySelector(".text-danger-900"); // Delivery fee span
            const totalPriceSpan = document.getElementById("totalPrice");
            const disPriceSpan = document.getElementById("disPrice");

            // Initial Subtotal from PHP (dynamically passed from PHP backend)
            const subtotal = parseFloat(<?php echo $total_price; ?>);
            const baseDeliveryFee = parseFloat(<?php echo $weigdeliveryfee; ?>);
            let totaldeliveryFee = 0.0;
            let discount = 0;
            let deliveryFee = 0.0;

            document.getElementById("applyCoupon").addEventListener("click", function() {
                const couponInput = document.getElementById("couponCode");
                const couponCode = couponInput.value.trim();
                const couponMessage = document.getElementById("couponMessage");

                if (!couponCode) {
                    couponMessage.textContent = "Please enter a coupon code!";
                    return;
                }

                fetch(`placeOdersBackend/checkCoupon.php?code=${encodeURIComponent(couponCode)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            couponMessage.style.color = "green";
                            couponMessage.textContent = `Coupon applied! Discount: ${data.discount}%`;
                            discount = data.discount;
                            updateTotalPrice(deliveryFee, discount);
                        } else {
                            couponMessage.style.color = "red";
                            couponMessage.textContent = data.message;
                        }
                    })
                    .catch(error => console.error("API Error:", error));
            });


            // Function to update the delivery fee based on city selection
            function updateDeliveryFee(city) {
                if (city) {
                    fetch(`placeOdersBackend/get_city_fee.php?city=${encodeURIComponent(city)}`)
                        .then(response => response.json())
                        .then(data => {
                            // Check if the API response is successful and retrieve delivery fee
                            deliveryFee = data.success ? parseFloat(data.fee) : 0;

                            // Call the updateTotalPrice function to update delivery fee and total price
                            updateTotalPrice(deliveryFee, discount);
                        })
                        .catch(error => console.error("API Error:", error));
                }
            }

            function updateTotalPrice(deliveryFee, discount) {
                // Calculate total delivery fee by adding base delivery fee to the city-specific fee
                totalDeliveryFee = baseDeliveryFee + deliveryFee;

                // Update the delivery fee in the UI
                deliverySpan.textContent = `+ Rs ${totalDeliveryFee.toFixed(2)}`;
                let newTotal = subtotal + totalDeliveryFee;
                // Calculate the new total price (subtotal + total delivery fee)
                if (discount > 0) {
                    disPriceSpan.textContent = `Rs ${((subtotal / 100) * discount).toFixed(2)}`;
                    newTotal = (subtotal - ((subtotal / 100) * discount)) + totalDeliveryFee;
                }

                // Update the total price in the UI
                totalPriceSpan.textContent = `Rs ${newTotal.toFixed(2)}`;
            }

            // Event listener to handle city change
            citySelect.addEventListener("change", function() {
                updateDeliveryFee(this.value);
            });

            // On load, check if a city is already selected and update the delivery fee accordingly
            if (citySelect.value) {
                updateDeliveryFee(citySelect.value);
            }
        });
    </script>






</body>
<script src="sahan.js"></script>
</html>