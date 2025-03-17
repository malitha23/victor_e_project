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
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
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
                                    <span class="h4 mb-9 fw-semibold">Delivered Orders&nbsp;&nbsp;<i class="fa fa-check-square" aria-hidden="true"></i></span>
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
                                            <?php
                                            $order = Databases::Search("SELECT * FROM `order` WHERE `Order_status_id`='2' ");
                                            $ordernum = $order->num_rows;
                                            for ($i = 0; $i < $ordernum; $i++) {
                                                $orderdata = $order->fetch_assoc();
                                                $invoice = Databases::Search("SELECT * FROM `invoice`WHERE `id`='" . $orderdata["invoice_id"] . "' ");
                                                $invoicedata = $invoice->fetch_assoc();
                                                $cuser = Databases::Search("SELECT * FROM `user` WHERE `email`='" . $invoicedata["user_email"] . "' ");
                                                $cuserdata = $cuser->fetch_assoc();
                                                $adress = Databases::Search("SELECT * FROM `address` WHERE `address_id`='" . $cuserdata["adress_id"] . "' ");
                                                $adressnum = $adress->num_rows;
                                                if ($adressnum == 1) {
                                                    $addressdeta = $adress->fetch_assoc();
                                                    $city = Databases::Search("SELECT * FROM `city` WHERE `city_id`='" . $addressdeta["city_city_id"] . "' ");
                                                    $citydata = $city->fetch_assoc();
                                                } else {
                                                    $addressdeta = 0;
                                                }
                                            ?>
                                                <!-- order 1 -->
                                                <div class="row">
                                                    <div class="col-12 border border-dark-subtle shadow mt-3">
                                                        <div class="row mt-2">
                                                            <div class="d-flex">
                                                                <div class="p-2 w-100">
                                                                    <div><b>Name : </b> <?php echo $cuserdata["fname"] . " " . $cuserdata["lname"] ?> &nbsp;&nbsp;&nbsp; <span class="tex-r">* USER ACCOUNT</span></div>
                                                                    <div><b>Mobile : </b> <?php echo $cuserdata["mobile"] ?></div>
                                                                    <div><b>Email : </b> <?php echo $cuserdata["email"] ?></div>
                                                                    <?php
                                                                    if ($addressdeta != 0) {
                                                                    ?>
                                                                        <div><b>Address : </b> <?php echo  $addressdeta["line_1"] . " " . $addressdeta["line_2"]; ?>, <?php echo $citydata["name"] ?>, Country</div>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <div><b>Rejister Date Time : </b> <?php echo $cuserdata["date"]; ?></div>
                                                                    <div><b>invoice Date Time : </b> <b><?php echo $invoicedata["date_time"] ?></b></div>
                                                                    <div><b>Order Date Time : </b> <b><?php echo $orderdata["date_time"] ?></b></div>
                                                                </div>
                                                                <?php
                                                                $ostatus = Databases::Search("SELECT * FROM `order_status` WHERE `id`='" . $orderdata["Order_status_id"] . "' ");
                                                                $ostatusdata = $ostatus->fetch_assoc();
                                                                ?>
                                                                <div class="p-2"><a class="btn btn-warning" data-bs-toggle="modal" ><?php echo $ostatusdata["status"]; ?></a>
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
                                                                                <th scope="col">discount</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $product = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $invoicedata["product_id"] . "' ");
                                                                            $productdata = $product->fetch_assoc();
                                                                            $ppicture = Databases::Search("SELECT * FROM `picture` WHERE `name`='Image 1' AND `product_id`='" . $invoicedata["product_id"] . "' ");
                                                                            $ppicturedata = $ppicture->fetch_assoc();
                                                                            ?>
                                                                            <tr class="table-row-with-border">
                                                                                <td>1</td>
                                                                                <th><img src="<?php echo $ppicturedata["path"]; ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                                                </th>
                                                                                <th scope="row">Product 1 - Meat Type - Cook Type</th>
                                                                                <td><?php echo $productdata["title"];  ?></td>
                                                                                <td>LKR: <?php echo $invoicedata["price"]; ?></td>
                                                                                <td><?php echo $invoicedata["qty"]; ?></td>
                                                                                <td><?php echo $invoicedata["discount"]; ?>%</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!-- status update modal -->
                                                            <!-- status update modal end -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- order 1 end -->
                                            <?php
                                            }
                                            ?>
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