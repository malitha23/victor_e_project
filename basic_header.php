



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

                    

                </div>
                <!-- form Category start -->

                <!-- Header Middle Right start -->
                <div class="header-right flex-align d-md-block d-none">
                    <div class="header-two-activities flex-align flex-wrap gap-32">
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
                                        <span class="w-16 h-16 flex-center rounded-circle bg-main-two-600 text-white text-xs position-absolute top-n6 end-n4"><?php echo  $ccn; ?></span>
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