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

                <div class="body-wrapper">
                    <?php
                    require "nav.php";
                    ?>

                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex flex-row justify-content-center">

                                    <div class="col-12 col-md-6 order-2 order-md-1 mt-3 mt-md-0 text-center">
                                        <img src="../admin-panel/assets-admin/images/contact/invoice-check.svg"
                                            class="img-fluid" width="400px">
                                    </div>

                                    <div class="col-12 col-md-6 text-center d-flex flex-row align-items-center justify-content-center order-1 order-lg-2">
                                        <div class="row d-flex flex-row justify-content-center">
                                            <div class="col-8 shadow p-3 border position-relative">
                                                <div class="position-absolute top-0 start-0 notification bg-dark rounded-circle m-3">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-end pe-4 pt-1">
                                                        <img src="../assets/img/avatar.svg" class="img-fluid" width="90px" alt="">
                                                    </div>
                                                    <div class="col-12 mt-3 ps-4 text-start">
                                                        <div class="mb-2"><span class="h4 mb-9 fw-semibold">Invoices</span></div>
                                                        <div><span class="mb-9 text-dark-emphasis">Manage your Invoices here</span></div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <button class="btn fw-bold col-8 btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal"><i class="fa-solid fa-receipt"></i> Show Invoices</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Invoice Management Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i
                                                        class="fa-solid fa-receipt"></i>&nbsp; Invoice Management</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row p-2 d-flex flex-row justify-content-end">
                                                    <div class="col-12 col-lg-6">
                                                        <form action="">
                                                            <div class="input-group rounded border rounded-5">
                                                                <input type="search" class="form-control border-0 border-end"
                                                                    placeholder="Search by Invoice Id" aria-label="Search"
                                                                    aria-describedby="search-addon" id="keyword" />
                                                                <span class="input-group-text btn border-0"
                                                                    id="search-addon" onclick="SearchInvoice();">
                                                                    <i class="fas fa-search"></i>
                                                                </span>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <section>
                                                    <div class="gradient-custom-1 h-100">
                                                        <div class="mask d-flex align-items-center h-100">
                                                            <div class="container" id="UserResult">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-12">
                                                                        <div class="table-responsive bg-white">
                                                                            <table class="table mb-0">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope="col"></th>
                                                                                        <th scope="col">Invoice ID</th>
                                                                                        <th scope="col">Customer Name</th>
                                                                                        <th scope="col">Total Price</th>
                                                                                        <th scope="col">Date</th>
                                                                                        <th scope="col">Download</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <!-- Sample Data -->
                                                                                    <tr>
                                                                                        <td>1</td>
                                                                                        <td>INV12345</td>
                                                                                        <td>John Doe</td>
                                                                                        <td>LKR 150.00</td>
                                                                                        <td>2025-02-05</td>
                                                                                        <td><a href="../invoice.php" target="_blank" class="btn x py-1 px-3 rounded-1"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>2</td>
                                                                                        <td>INV12346</td>
                                                                                        <td>Jane Smith</td>
                                                                                        <td>LKR 200.00</td>
                                                                                        <td>2025-02-04</td>
                                                                                        <td><a href="../invoice.php" target="_blank" class="btn x py-1 px-3 rounded-1"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                                                                                    </tr>

                                                                                    <!-- Add more rows for other invoices -->
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Management Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="assets-admin/libs/jquery/dist/jquery.min.js"></script>
            <script src="assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="assets-admin/js/sidebarmenu.js"></script>
            <script src="assets-admin/js/app.min.js"></script>
            <script src="assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
            <script src="assets-admin/libs/simplebar/dist/simplebar.js"></script>
            <script src="assets-admin/js/dashboard.js"></script>
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