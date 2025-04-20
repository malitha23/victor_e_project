<!-- ==================== Search Box Start Here ==================== -->
<form action="#" class="search-box">
    <button type="button" class="search-box__close position-absolute inset-block-start-0 inset-inline-end-0 m-16 w-48 h-48 border border-gray-100 rounded-circle flex-center text-white hover-text-gray-800 hover-bg-white text-2xl transition-1">
        <i class="ph ph-x"></i>
    </button>
    <div class="container">
        <div class="position-relative">
            <input type="text" class="form-control py-16 px-24 text-xl rounded-pill pe-64" placeholder="Type here">
            <button type="submit" class="w-48 h-48 bg-main-600 rounded-circle flex-center text-xl text-white position-absolute top-50 translate-middle-y inset-inline-end-0 me-8">
                <i class="ph ph-magnifying-glass"></i>
            </button>
        </div>
    </div>
</form>
<!-- ==================== Search Box End Here ==================== -->



<!-- ======================= Middle Header Two Start ========================= -->
<header class="header-middle style-two bg-color-neutral" style="padding-top: 20px !important; padding-bottom: 20px !important;">
    <div class="container container-lg">
        <nav class="header-inner flex-between">
            <!-- Logo Start -->
            <div class="logo">
                <a href="index.php" class="link">
                    <img src="assets/images/logo/logo-two.png" alt="Logo">
                </a>
            </div>
            <!-- Logo End  -->

            <!-- form Category Start -->
            <div class="flex-align gap-16">

                <form action="#" class="flex-align flex-wrap form-location-wrapper">
                    <div class="search-category style-two d-flex h-48 search-form d-sm-flex d-none">
                        <select class="js-example-basic-single border border-gray-200 border-end-0 rounded-0 border-0" name="state">
                            <option value="1" selected>All Categories</option>
                            <option value="1">Grocery</option>
                            <option value="1">Breakfast & Dairy</option>
                            <option value="1">Vegetables</option>
                            <option value="1">Milks and Dairies</option>
                            <option value="1">Pet Foods & Toy</option>
                            <option value="1">Breads & Bakery</option>
                            <option value="1">Fresh Seafood</option>
                            <option value="1">Fronzen Foods</option>
                            <option value="1">Noodles & Rice</option>
                            <option value="1">Ice Cream</option>
                        </select>
                        <div class="search-form__wrapper position-relative d-md-flex">
                            <input type="text" class="search-form__input common-input py-13 ps-16 pe-18 rounded-0 border-0" placeholder="Type here">
                        </div>
                        <button type="submit" class="bg-main-two-600 flex-center text-xl text-white flex-shrink-0 w-48 hover-bg-main-two-700 d-md-flex d-none"><i class="ph ph-magnifying-glass"></i></button>
                    </div>
                </form>

            </div>
            <!-- form Category start -->

            <!-- Header Middle Right start -->
            <div class="header-right flex-align d-md-block d-none">
                <div class="header-two-activities flex-align flex-wrap gap-32">
                    <button type="button" class="flex-align search-icon d-md-none d-flex gap-4 item-hover-two">
                        <span class="text-2xl text-white d-flex position-relative item-hover__text">
                            <i class="ph ph-magnifying-glass text-white"></i>
                        </span>
                    </button>
                    <?php
                    if (isset($_SESSION["user_vec"]["email"])) {
                        try {
                            $cc = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $_SESSION["user_vec"]["email"] . "'");
                            $ccn = $cc->num_rows; // corrected: should be `num_rows` not `num_row`
                        } catch (Exception $e) {
                            $ccn = "..";
                        }
                    } else {
                        $ccn = "..";
                    }
                    ?>
                    <a href="cart.php" class="flex-align flex-column gap-8 item-hover-two">
                        <span class="text-2xl text-white d-flex position-relative me-6 mt-6 item-hover__text">
                            <i class="ph ph-shopping-cart-simple text-white"></i>
                            <span class="w-16 h-16 flex-center rounded-circle bg-main-two-600 text-white text-xs position-absolute top-n6 end-n4"><?php echo $ccn; ?></span>
                        </span>
                        <span class="text-md text-white item-hover__text d-none d-lg-flex">Cart</span>
                    </a>
                    <a href="account.php" class="flex-align flex-column gap-8 item-hover-two">
                        <span class="text-2xl text-white d-flex position-relative item-hover__text">
                            <i class="ph ph-user text-white"></i>
                        </span>
                        <span class="text-md text-white item-hover__text d-none d-lg-flex">Profile</span>
                    </a>
                </div>
            </div>
            <!-- Header Middle Right End  -->
            <nav class="header-inner d-flex gap-8 justify-content-end align-items-end d-md-none">

                <!-- Header Right start -->
                <div class="header-right flex-align ">

                    <div class="me-8 d-lg-none d-block ">
                        <div class="header-two-activities flex-align flex-wrap gap-32">
                            <button type="button" class="flex-align search-icon d-lg-none d-flex gap-4 item-hover-two">
                                <span class="text-2xl text-white d-flex position-relative item-hover__text">
                                    <i class="ph ph-magnifying-glass text-white"></i>
                                </span>
                            </button>
                            <a href="cart.php" class="flex-align flex-column gap-8 item-hover-two">
                                <span class="text-2xl text-white d-flex position-relative me-6 mt-6 item-hover__text">
                                    <i class="ph ph-shopping-cart-simple text-white"></i>
                                    <span class="w-16 h-16 flex-center rounded-circle bg-main-two-600 text-white text-xs position-absolute top-n6 end-n4">2</span>
                                </span>
                                <span class="text-md text-white item-hover__text d-none d-lg-flex">Cart</span>
                            </a>
                            <a href="account.php" class="flex-align flex-column gap-8 item-hover-two">
                                <span class="text-2xl text-white d-flex position-relative item-hover__text">
                                    <i class="ph ph-user text-white"></i>
                                </span>
                                <span class="text-md text-white item-hover__text d-none d-lg-flex">Profile</span>
                            </a>

                        </div>
                    </div>

                </div>
                <!-- Header Right End  -->
            </nav>
        </nav>
    </div>
</header>
<!-- ======================= Middle Header Two End ========================= -->