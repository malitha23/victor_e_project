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
            <title>Vicstore Admin Panel – Manage Your Store with Ease</title>
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

                <div class="body-wrapper">
                    <?php
                    require "nav.php";
                    ?>

                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex flex-row justify-content-center">

                                    <div class="col-12 col-md-6 order-2 order-md-1 mt-3 mt-md-0 text-center">
                                        <img src="../admin-panel/assets-admin/images/contact/invoice-check.svg" class="img-fluid" width="400px">
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
                                                        <button class="btn fw-bold col-8 btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-receipt"></i> Show Invoices</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Invoice Management Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i class="fa-solid fa-receipt"></i>&nbsp; Invoice Management</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row p-2 d-flex flex-row justify-content-end">
                                                    <div class="col-12 col-lg-6">
                                                        <form action="">
                                                            <div class="input-group rounded border rounded-5">
                                                                <input type="search" class="form-control border-0 border-end" placeholder="Search by Invoice Id" aria-label="Search" aria-describedby="search-addon" id="keyword" />
                                                                <span class="input-group-text btn border-0" id="search-addon" onclick="SearchInvoice();">
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
                                                                                    <?php
                                                                                    $invoice = Databases::Search("SELECT * FROM `invoice`");
                                                                                    $invoicenum = $invoice->num_rows;
                                                                                    for ($i = 0; $i < $invoicenum; $i++) {
                                                                                        $invoicedata = $invoice->fetch_assoc();
                                                                                        $useri = Databases::Search("SELECT * FROM `user` WHERE `email`='" . $invoicedata["user_email"] . "' ");
                                                                                        $userid = $useri->fetch_assoc();
                                                                                        $batch = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $invoicedata["batch_id"] . "' ");
                                                                                        $batchdata = $batch->fetch_assoc();
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo $i + 1 ?></td>
                                                                                            <td><?php echo $invoicedata["uni_code"] ?></td>
                                                                                            <td><?php echo $userid["fname"] ?></td>
                                                                                            <td>selling_price : LKR <?php echo $batchdata["selling_price"] ?></td>
                                                                                            <td><?php echo $invoicedata["date_time"] ?></td>
                                                                                            <td>
                                                                                                <button onclick="downloardin(<?php echo $invoicedata["id"] ?>)" class="btn btn-primary py-1 px-3 rounded-1 view-invoice-btn" data-invoiceid="<?php echo $invoicedata['id']; ?>" data-targetdiv="invoice-details-content-<?php echo $i ?>">
                                                                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                                                                </button>
                                                                                            </td>
                                                                                        </tr>

                                                                                        <!-- Invoice Modal -->
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                                <!-- Place this script AFTER the table -->
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
        <script>
            function downloardin(invoiceId) {
                // Optional: Disable button or show loading
                const button = document.querySelector(`[data-invoiceid='${invoiceId}']`);
                button.disabled = true;
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

                // Create a new XMLHttpRequest
                var req = new XMLHttpRequest();

                // Set up the request
                req.open('POST', 'process/invicedown.php', true);
                req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                // Handle the response
                req.onload = function() {
                    if (req.status === 200) {
                      
                       document.getElementById("exampleModal").innerHTML =req.responseText;
                    } else {
                        // Handle error if status is not 200
                        alert("Download failed. Please try again.");
                    }
                };

                // Handle any error that might occur during the request
                req.onerror = function() {
                    alert("Error in sending request. Please try again.");
                };

                // Send the request with the invoice ID
                req.send('id=' + encodeURIComponent(invoiceId));
            }
        </script>

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