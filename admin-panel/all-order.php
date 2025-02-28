<?php
session_start();

if (isset($_SESSION["a"])) {
    include "db.php";
    $uemail = $_SESSION["a"]["username"];
    $query = "SELECT * FROM `admin` WHERE `username` = ?";
    $params = [$uemail];
    $types = "s";
    $u_detail = Databases::Search($query, $params, $types);
    if ($u_detail->num_rows == 1) {
?>

        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>replace_title_admin</title>
            <link rel="shortcut icon" href="assets/img/logo-icon.ico" type="image/x-icon">
            <link rel="stylesheet" href="assets-admin/css/style.css" />
            <link rel="stylesheet" href="assets-admin/css/styles.min.css" />
        </head>

        <body>
            <!-- Body Wrapper -->
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                data-sidebar-position="fixed" data-header-position="fixed">
                <?php

                require "side.php";

                ?>

                <!--  Main wrapper -->
                <div class="body-wrapper">
                    <!--  Header Start -->
                    <?php
                    require "nav.php";
                    ?>
                    <!--  Header End -->

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                                <div class="mb-1">
                                    <span class="h4 mb-9 fw-semibold">Delivered Orders&nbsp;&nbsp;<i class="fa fa-check-square"
                                            aria-hidden="true"></i></span>
                                </div>
                                <div>
                                    <span class="mb-9 text-dark-emphasis">You can manage your delivered orders here</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <section>
                                <div class="gradient-custom-1 h-100">
                                    <div class="mask d-flex align-items-center h-100">
                                        <div class="container">

                                            <!-- order 1 -->
                                            <div class="row">
                                                <div class="col-12 border border-dark-subtle shadow mt-3">
                                                    <div class="row mt-2">
                                                        <div class="d-flex">
                                                            <div class="p-2 w-100">
                                                                <div><b>Name : </b> John Doe &nbsp;&nbsp;&nbsp; <span class="tex-r">* GUEST ACCOUNT</span></div>
                                                                <div><b>Mobile : </b> 123456789</div>
                                                                <div><b>Email : </b> johndoe@example.com</div>
                                                                <div><b>Address : </b> 123 Street, City, Country</div>
                                                                <div><b>Date Time : </b> 2025-02-05 10:30 AM</div>
                                                            </div>
                                                            <div class="p-2"><a class="btn btn-danger">Delivered</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <div class="col-12 px-3 pt-4 pb-5 rounded-2">
                                                            <div class="table-responsive bg-white">
                                                                <table class="table mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col"></th>
                                                                            <th></th>
                                                                            <th scope="col">ITEM</th>
                                                                            <th scope="col">DETAILS</th>
                                                                            <th scope="col">UNIT PRICE</th>
                                                                            <th scope="col">QTY</th>
                                                                            <th scope="col">TOTAL PRICE</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="table-row-with-border">
                                                                            <td>1</td>
                                                                            <th><img src="product-image.jpg" class="img-fluid rounded-3"
                                                                                    alt="Shopping item" style="width: 65px;">
                                                                            </th>
                                                                            <th scope="row">Product 1 - Meat Type - Cook Type</th>
                                                                            <td>Product Description</td>
                                                                            <td>LKR 15.00</td>
                                                                            <td>2</td>
                                                                            <td>LKR 30.00</td>
                                                                        </tr>
                                                                        <tr class="table-row-with-border">
                                                                            <td>2</td>
                                                                            <th><img src="product-image.jpg" class="img-fluid rounded-3"
                                                                                    alt="Shopping item" style="width: 65px;">
                                                                            </th>
                                                                            <th scope="row">Product 2 - Meat Type - Cook Type</th>
                                                                            <td>Product Description</td>
                                                                            <td>LKR 10.00</td>
                                                                            <td>1</td>
                                                                            <td>LKR 10.00</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- order 1 end -->

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="assets-admin/libs/jquery/dist/jquery.min.js"></script>
            <script src="assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="assets-admin/js/sidebarmenu.js"></script>
            <script src="assets-admin/js/app.min.js"></script>
            <script src="assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
            <script src="assets-admin/libs/simplebar/dist/simplebar.js"></script>
            <script src="assets-admin/js/dashboard.js"></script>

            <!-- overlay -->
            <div class="blueOverlay d-none">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-center text-white">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3">Please wait...</p>
                    </div>
                </div>
            </div>

        </body>


        </html>

<?php
    } else {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
} else {
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>