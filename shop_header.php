<!--==================== Overlay Start ====================-->
<div class="overlay"></div>
<!--==================== Overlay End ====================-->

<!--==================== Sidebar Overlay End ====================-->
<div class="side-overlay"></div>
<!--==================== Sidebar Overlay End ====================-->

<!-- ==================== Scroll to Top End Here ==================== -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- ==================== Scroll to Top End Here ==================== -->

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
                        </select>
                        <div class="search-form__wrapper position-relative d-md-flex">
                            <input id="searchtext" oninput="advancesearch();" type="text" class="search-form__input common-input py-13 ps-16 pe-18 rounded-0 border-0" placeholder="Type here">
                        </div>
                        <button onclick="advancesearch();" type="submit" class="bg-main-two-600 flex-center text-xl text-white flex-shrink-0 w-48 hover-bg-main-two-700 d-md-flex d-none"><i class="ph ph-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            <!-- form Category start -->

            <!-- Header Middle Right start -->
            <div class="header-right flex-align d-lg-block d-none">
                <div class="header-two-activities flex-align flex-wrap gap-32">
                    <button type="button" class="flex-align search-icon d-lg-none d-flex gap-4 item-hover-two">
                        <span class="text-2xl text-white d-flex position-relative item-hover__text">
                            <i class="ph ph-magnifying-glass"></i>
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
            <!-- Header Middle Right End  -->
        </nav>
    </div>
</header>
<!-- ======================= Middle Header Two End ========================= -->

<!-- ==================== Header Two Start Here ==================== -->
<header class="header bg-white border-bottom border-gray-100">
    <div class="container container-lg">
        <nav class="header-inner d-flex justify-content-between gap-8">
            <div class="flex-align menu-category-wrapper">

                <!-- Category Dropdown Start -->
                <div class="category d-block on-hover-item bg-main-600 text-white">
                    <button type="button" class="category__button flex-align gap-8 fw-medium p-16 border-end border-start border-gray-100 text-white">
                        <span class="icon text-2xl d-xs-flex d-none"><i class="ph ph-dots-nine"></i></span>
                        <span class="d-sm-flex d-none">All</span> Categories
                        <span class="arrow-icon text-xl d-flex"><i class="ph ph-caret-down"></i></span>
                    </button>

                    <div class="responsive-dropdown on-hover-dropdown common-dropdown nav-submenu p-0 submenus-submenu-wrapper">
                        <button type="button" class="close-responsive-dropdown rounded-circle text-xl position-absolute inset-inline-end-0 inset-block-start-0 mt-4 me-8 d-lg-none d-flex"> <i class="ph ph-x"></i> </button>
                        <div class="logo px-16 d-lg-none d-block">
                            <a href="index.php" class="link">
                                <img src="assets/images/logo/logo.png" alt="Logo">
                            </a>
                        </div>
                        <ul class="scroll-sm p-0 py-8 w-300 max-h-400 overflow-y-auto">
                            <?php
                            $group = Database::Search("SELECT * FROM `group`");
                            $groupnum = $group->num_rows;
                            for ($g = 0; $g < $groupnum; $g++) {
                                $groupdata = $group->fetch_assoc();
                            ?>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-brandy"></i></span>
                                        <span onclick="gcs('<?php echo $groupdata["id"]; ?>', 0, 0);">
                                            <?php echo $groupdata["group_name"]; ?>
                                        </span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>
                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title"><?php echo $groupdata["group_name"]; ?></h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <?php
                                            $category = Database::Search("SELECT * FROM `category` WHERE `group_id`='" . $groupdata["id"] . "' ");
                                            $categorynum = $category->num_rows;
                                            for ($c = 0; $c < $categorynum; $c++) {
                                                $categorydata = $category->fetch_assoc();
                                            ?>
                                                <li>
                                                    <a onclick="gcs('<?php echo $groupdata["id"]; ?>','<?php echo $categorydata["id"]; ?>', 0);" href="javascript:void(0)"><?php echo $categorydata["name"]; ?></a>
                                                    <ul>
                                                        <?php
                                                        $subcategory = Database::Search("SELECT * FROM `sub_category` WHERE `category_id`='" . $categorydata["id"] . "' ");
                                                        $subcategorynum = $subcategory->num_rows;
                                                        for ($s = 0; $s < $subcategorynum; $s++) {
                                                            $subcategorydata = $subcategory->fetch_assoc();
                                                        ?>
                                                            <li>
                                                                <a onclick="gcs('<?php echo $groupdata["id"]; ?>','<?php echo $categorydata["id"]; ?>','<?php echo $subcategorydata["id"]; ?>');" href="javascript:void(0)"><?php echo $subcategorydata["name"]; ?></a>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
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
                <!-- Category Dropdown End  -->

            </div>

            <!-- Header Right start -->
            <div class="header-right flex-align">

                <div class="me-8 d-lg-none d-block">
                    <div class="header-two-activities flex-align flex-wrap gap-32">
                        <button type="button" class="flex-align search-icon d-md-none d-flex gap-4 item-hover-two">
                            <span class="text-2xl text-white d-flex position-relative item-hover__text">
                                <i class="ph ph-magnifying-glass"></i>
                            </span>
                        </button>
                        <a href="cart.php" class="flex-align flex-column gap-8 item-hover-two">
                            <span class="text-2xl text-white d-flex position-relative me-6 mt-6 item-hover__text">
                                <i class="ph ph-shopping-cart-simple"></i>
                                <span class="w-16 h-16 flex-center rounded-circle bg-main-two-600 text-white text-xs position-absolute top-n6 end-n4">2</span>
                            </span>
                            <span class="text-md text-white item-hover__text d-none d-lg-flex">Cart</span>
                        </a>
                        <a href="account.php" class="flex-align flex-column gap-8 item-hover-two">
                            <span class="text-2xl text-white d-flex position-relative item-hover__text">
                                <i class="ph ph-user"></i>
                            </span>
                            <span class="text-md text-white item-hover__text d-none d-lg-flex">Profile</span>
                        </a>

                    </div>
                </div>

            </div>
            <!-- Header Right End  -->
        </nav>
    </div>
</header>
<!-- ==================== Header End Here ==================== -->