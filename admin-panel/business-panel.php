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
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        </head>

        <body onload="change_branch()">
            <!--  Body Wrapper -->
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
                <?php

                require "side.php";

                ?>
                <!--  Main wrapper -->
                <div class="body-wrapper">

                    <?php
                    require "nav.php";
                    ?>

                    <div class="container-fluid px-md-5">

                        <!-- add cities -->
                        <div class="row">
                            <div class="col-12 text-center mb-0">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Add Cities&nbsp;&nbsp;<i class="fa fa-globe" aria-hidden="true"></i>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can add and edit city details here</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-1 col-10 offset-md-0 col-md-4 d-flex flex-row justify-content-center">
                                <img src="../admin-panel/assets-admin/images/contact/branch_i.svg" class="img-fluid" width="300px">
                            </div>
                            <div class="col-12 col-md-8 mb-2">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="ad_id" onchange="list_town();" aria-label="Floating label select example">
                                                        <option selected value="0" selected>Select a district</option>
                                                        <?php
                                                        $district_q1 = Databases::search("SELECT * FROM `distric` ");
                                                        while ($district1 = $district_q1->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $district1['distric_id'] ?>">
                                                                <?php echo $district1['name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="c_id">District</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="at_id" aria-label="Floating label select example">

                                                    </select>
                                                    <label for="c_id">Town</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 py-1">
                                                <button class="btn btn-lg btn-light-danger border-danger border-opacity-25 rounded-0-5 text-dark-emphasis fw-100 fs-4" onclick="add_town_col();">ADD</button>
                                            </div>
                                            <div class="col-12">
                                                <div class="row" id="town_col">

                                                </div>
                                            </div>
                                            <input type="number" value="" hidden id="num" />
                                            <div class="col-12 text-end">
                                                <button onclick="savecities();" class="btn rounded-0-5 fw-bold x"><i class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- shipping cost -->
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Delivery Charges&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can add or change your delivery charges
                                        here</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="offset-1 col-10 offset-md-0 col-md-4 d-flex flex-row justify-content-center order-md-2">
                                <img src="../admin-panel/assets-admin/images/contact/delivey_img.svg" class="img-fluid" width="300px">
                            </div>
                            <div class="col-12 col-md-8 order-md-1">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div hidden class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="c_id" onchange="list_dprice();" aria-label="Floating label select example">
                                                        <option selected value="0" selected>Select a city</option>
                                                        <?php
                                                        $district_q = DatabaseS::search("SELECT * FROM `city` ");
                                                        while ($district = $district_q->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $district['city_id'] ?>">
                                                                <?php echo $district['name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="c_id">FROM</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="c_id2" onchange="list_dprice();" aria-label="Floating label select example">
                                                        <option selected value="0" selected>Select a district</option>
                                                        <?php
                                                        $district_q = Databases::search("SELECT * FROM `city`");
                                                        while ($district = $district_q->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $district['city_id'] ?>">
                                                                <?php echo $district['name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="c_id2">TO</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control rounded-0" id="d_price" value="" placeholder="charges">
                                                    <label for="d_price">Delivery charges</label>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button class="btn rounded-0-5 fw-bold x" onclick="update_dprice();"><i class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- contact us -->
                        <div class="row">
                            <div class="col-12 text-center mb-0">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Contact Us&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can change your contact
                                        details here</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-1 col-10 offset-md-0 col-md-4 d-flex flex-row justify-content-center">
                                <img src="../admin-panel/assets-admin/images/contact/email_i.svg" class="img-fluid" width="300px">
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control rounded-0" id="contact_email" value="name@example.com" placeholder="name@example.com">
                                                <label for="floatingInput">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control rounded-0" id="contact_email" value="+947785412" placeholder="name@example.com">
                                                <label for="floatingInput">Mobile Number</label>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button class="btn rounded-0-5 fw-bold x" data-bs-toggle="modal" onclick="change_email();" data-bs-target="#exampleModal"><i class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            <script src="sahan.js"></script>
            <!-- SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

            <!-- SweetAlert2 JavaScript -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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