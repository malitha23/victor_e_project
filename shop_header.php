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
                                <input type="text" class="search-form__input common-input py-13 ps-16 pe-18 rounded-0 border-0" placeholder="Type here">
                            </div>
                            <button type="submit" class="bg-main-two-600 flex-center text-xl text-white flex-shrink-0 w-48 hover-bg-main-two-700 d-md-flex d-none"><i class="ph ph-magnifying-glass"></i></button>
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
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-carrot"></i></span>
                                        <span>Vegetables &amp; Fruit</span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>

                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title">Vegetables &amp; Fruit</h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <li>
                                                <a href="shop.php">Potato &amp; Tomato</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Cucumber &amp; Capsicum</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Leafy Vegetables</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Root Vegetables</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Beans &amp; Okra</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Cabbage &amp; Cauliflower</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Gourd &amp; Drumstick</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Specialty</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-brandy"></i></span>
                                        <span>Beverages</span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>
                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title">Beverages</h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <li>
                                                <a href="shop.php">Soda &amp; Cocktail Mix </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Sports &amp; Energy Drinks</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Non Alcoholic Drinks</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Packaged Water </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Spring Water</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Flavoured Water </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-brandy"></i></span>
                                        <span>Meats &amp; Seafood</span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>
                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title">Meats &amp; Seafood</h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <li>
                                                <a href="shop.php"> Fresh Meat </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Frozen Meat</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Marinated Meat</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Fresh &amp; Frozen Meat</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-brandy"></i></span>
                                        <span>Breakfast &amp; Dairy</span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>
                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title">Breakfast &amp; Dairy</h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <li>
                                                <a href="shop.php"> Oats &amp; Porridge</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Kids Cereal</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Muesli</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Flakes</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Granola &amp; Cereal Bars</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Instant Noodles</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-brandy"></i></span>
                                        <span>Frozen Foods</span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>
                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title">Frozen Foods</h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <li>
                                                <a href="shop.php"> Instant Noodles </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Hakka Noodles</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Cup Noodles</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Vermicelli</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Instant Pasta</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-brandy"></i></span>
                                        <span>Biscuits &amp; Snacks</span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>
                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title">Biscuits &amp; Snacks</h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <li>
                                                <a href="shop.php"> Salted Biscuits </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Marie, Health, Digestive</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Cream Biscuits &amp; Wafers </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Glucose &amp; Milk biscuits</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Cookies</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="has-submenus-submenu">
                                    <a href="javascript:void(0)" class="text-gray-500 text-15 py-12 px-16 flex-align gap-8 rounded-0">
                                        <span class="text-xl d-flex"><i class="ph ph-brandy"></i></span>
                                        <span>Grocery &amp; Staples</span>
                                        <span class="icon text-md d-flex ms-auto"><i class="ph ph-caret-right"></i></span>
                                    </a>
                                    <div class="submenus-submenu py-16">
                                        <h6 class="text-lg px-16 submenus-submenu__title">Grocery &amp; Staples</h6>
                                        <ul class="submenus-submenu__list max-h-300 overflow-y-auto scroll-sm">
                                            <li>
                                                <a href="shop.php"> Lemon, Ginger &amp; Garlic </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Indian &amp; Exotic Herbs</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Orangic Vegetables</a>
                                            </li>
                                            <li>
                                                <a href="shop.php">Orangic Fruits </a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Orangic Dry Fruits</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Orangic Dals &amp; pulses</a>
                                            </li>
                                            <li>
                                                <a href="shop.php"> Orangic Millet &amp; Flours</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
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