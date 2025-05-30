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
                                    <span class="h4 mb-9 fw-semibold">Manage COD Orders&nbsp;&nbsp;<i class="fa fa-handshake-o"
                                            aria-hidden="true"></i></span>
                                </div>
                                <div>
                                    <span class="mb-9 text-dark-emphasis">You can manage your cash on delivery orders here</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <section>
                                <div class="gradient-custom-1 h-100">
                                    <div class="mask d-flex align-items-center h-100">
                                        <div class="container">

                                            <?php
                                            $ORDERS = Databases::Search("SELECT * FROM `cashond`");
                                            $ORDERSNUM = $ORDERS->num_rows;
                                            if ($ORDERSNUM == 0) {
                                                echo '<div class="text-center mt-5"><h5 class="text-danger">No orders found.</h5></div>';
                                                exit();
                                            }

                                            for ($i = 0; $i < $ORDERSNUM; $i++) {
                                                $ORDER = $ORDERS->fetch_assoc();
                                                try {
                                                    $user = Databases::Search("SELECT * FROM `user` WHERE `email` = '" . $ORDER["email"] . "'");
                                                    $userdata = $user->fetch_assoc();
                                                    try {
                                                        $adress = Databases::Search("SELECT * FROM `address` WHERE `address_id` = '" . $userdata["adress_id"] . "'");
                                                        $addressdata = $adress->fetch_assoc();
                                                        $city = Databases::Search("SELECT * FROM `city` WHERE `city_id` = '" . $addressdata["city_city_id"] . "'");
                                                        $citydata = $city->fetch_assoc();
                                                        $distric = Databases::Search("SELECT * FROM `distric` WHERE `distric_id` = '" . $addressdata["distric_distric_id"] . "'");
                                                        $districtdata = $distric->fetch_assoc();
                                                    } catch (\Throwable $th) {
                                                        exit("Error fetching address data: " . $th->getMessage());
                                                    }
                                                } catch (\Throwable $th) {
                                                    exit("Error fetching user data: " . $th->getMessage());
                                                }

                                                $formattedDate = date("Y-m-d h:i A", strtotime($ORDER["date"]));
                                                $status = Databases::Search("SELECT * FROM `cashon_status` WHERE `id` = '" . $ORDER["cashon_status_id"] . "'");
                                                $statusdata = $status->fetch_assoc();

                                                $batch = Databases::Search("SELECT * FROM batch WHERE `id` = '" . $ORDER["batch_id"] . "'");
                                                $batchdata = $batch->fetch_assoc();
                                                if ($batchdata["Delete"] == 1) {
                                                    echo '<div class="text-center mt-5"><h5 class="text-danger">Batch is not available.</h5></div>';
                                                    exit();
                                                }
                                                $product = Databases::Search("SELECT * FROM product WHERE `id` = '" . $batchdata["product_id"] . "'");
                                                $productdata = $product->fetch_assoc();
                                            ?>
                                                <!-- order start -->
                                                <div class="row">
                                                    <div class="col-12 border border-dark-subtle shadow mt-3">
                                                        <div class="row mt-2">
                                                            <div class="d-flex">
                                                                <div class="p-2 w-100">
                                                                    <div><b>Name : </b> <?php echo $userdata["fname"] . " " . $userdata["lname"] ?> <span class="tex-r">* GUEST ACCOUNT</span></div>
                                                                    <div><b>Mobile : </b> <?php echo $userdata["mobile"] ?> </div>
                                                                    <div><b>Email : </b> <?php echo $userdata["email"] ?></div>
                                                                    <div><b>Address : </b><?php echo $addressdata["line_1"] . " " . $addressdata["line_2"] . " " . $citydata["name"] . " " . $districtdata["name"] ?></div>
                                                                    <div><b>Date Time : </b><?php echo $ORDER["date"] ?></div>
                                                                </div>
                                                                <div class="p-2">
                                                                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal"
                                                                        data-order-id="<?php echo $ORDER['id']; ?>" data-order-email="<?php echo $userdata['email']; ?>">
                                                                        <?php echo $statusdata["name"] ?>
                                                                    </a>
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
                                                                                <th scope="col">1 UNIT PRICE(with discount/no)</th>
                                                                                <th scope="col">DELIVERY FEE</th>
                                                                                <th scope="col">QTY</th>
                                                                                <th scope="col">TOTAL PRICE</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $picture =  Databases::Search("SELECT * FROM `picture`  WHERE `product_id`='" . $productdata["id"] . "' ");
                                                                            $picturenum = $picture->num_rows;
                                                                            $pictured = $picture->fetch_assoc();
                                                                            ?>
                                                                            <tr class="table-row-with-border">
                                                                                <td>1</td>
                                                                                <th><img src="<?php echo $pictured["path"] ?>" class="img-fluid rounded-3" style="width: 65px;"></th>
                                                                                <th scope="row">Product <?php echo $i + 1 ?> - <?php echo $productdata["title"] ?></th>
                                                                                <td><?php echo $productdata["description"] ?></td>
                                                                                <td>LKR <?php echo $ORDER["price"] ?></td>
                                                                                <td>LKR <?php echo $ORDER["delivery_fee"] ?></td>
                                                                                <td><?php echo $ORDER["qty"] ?></td>
                                                                                <td>LKR <?php echo $ORDER["totalprice"] ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <!-- Status Update Modal (only once) -->
                                            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="modal-title fs-4 fw-bold" id="statusModalLabel">Change Order Status</div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-12 mb-3">
                                                                <div class="form-floating mb-1">
                                                                    <?php
                                                                    $order_status = Databases::Search("SELECT * FROM `cashon_status`");
                                                                    ?>
                                                                    <select class="form-select rounded-0" id="statusSelect">
                                                                        <?php while ($order_s_d = $order_status->fetch_assoc()) { ?>
                                                                            <option value="<?php echo $order_s_d["id"] ?>"><?php echo $order_s_d["name"] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <label for="statusSelect">Change this order status here.</label>
                                                                </div>
                                                                <label class="small">Order of <b id="modalEmail">example@example.com</b>.</label><br>
                                                                <label class="small text-danger">Warning: Be careful when selecting <b>CANCELED</b>.</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" onclick="saveOrderStatus()">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                let selectedOrderId = null;

                                                const statusModal = document.getElementById('statusModal');
                                                statusModal.addEventListener('show.bs.modal', function(event) {
                                                    const button = event.relatedTarget;
                                                    selectedOrderId = button.getAttribute('data-order-id');
                                                    const email = button.getAttribute('data-order-email');
                                                    document.getElementById('modalEmail').textContent = email;
                                                });

                                                function saveOrderStatus() {
                                                    const statusId = document.getElementById("statusSelect").value;

                                                    const req = new XMLHttpRequest();
                                                    req.open("POST", "process/cashonstatus.php", true);
                                                    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                    req.onreadystatechange = function() {
                                                        if (req.readyState == 4 && req.status == 200) {
                                                            alert("Order status updated successfully!");
                                                            location.reload();
                                                        }
                                                    };
                                                    req.send("status=" + encodeURIComponent(statusId) + "&id=" + encodeURIComponent(selectedOrderId));
                                                }
                                            </script>


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