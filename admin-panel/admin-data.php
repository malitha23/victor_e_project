<?php
session_start();

if (isset($_SESSION["a"])) {
    include "db.php";
    // $uemail = $_SESSION["a"]["username"];
    // $query = "SELECT * FROM `admin` WHERE `username` = ?";
    // $params = [$uemail];
    // $types = "s";
    // $u_detail = Databases::Search($query, $params, $types);
    // if ($u_detail->num_rows == 1) {
    if (1 == 1) {
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
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
            <script src="https://cdn.tiny.cloud/1/v6ya2mxbd70fn22v774qp5fw78t114ccnejem2vy8oriyj04/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        </head>

        <body>
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

                        <div class="row">
                            <div class="col-12 text-center mb-0">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Selling Details&nbsp;&nbsp;<i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can view your selling details here</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 mt-3">
                            <div class="col-12">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <div class="table-responsive bg-white border w-100" style=" overflow-x: auto;">
                                                    <table class="table mb-0 table-bordered">
                                                        <thead>
                                                            <tr style="background-color: azure;">
                                                                <th></th>
                                                                <th>IMAGE</th>
                                                                <th>NAME</th>
                                                                <th>DATE</th>
                                                                <th>SOLD</th>
                                                                <th>STOCK</th>
                                                                <th>STATUS</th>
                                                                <th>BATCH</th>
                                                                <th>DETAILS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="">

                                                            <?php {
                                                                $product = Databases::Search("SELECT * FROM `product`");
                                                                $productnum = $product->num_rows;
                                                                for ($x = 1; $x < $productnum; $x++) {
                                                                    $productdata = $product->fetch_assoc();
                                                                    $invoice = Databases::Search("SELECT * FROM `invoice` WHERE `product_id`='" . $productdata["id"] . "' ");
                                                                    $invoicenum = $invoice->num_rows;
                                                                    $iqty = 0;
                                                                    for ($i = 0; $i < $invoicenum; $i++) {
                                                                        $invoicedata = $invoice->fetch_assoc();
                                                                        $iqty =  $iqty + $invoicedata["qty"];
                                                                    }
                                                                    $batch = Databases::Search("SELECT * FROM `batch` WHERE `product_id`='" . $productdata["id"] . "' ");
                                                                    $batchnum = $batch->num_rows;
                                                                    $bqty = 0;
                                                                    for ($i = 0; $i < $batchnum; $i++) {
                                                                        $batchdata = $batch->fetch_assoc();
                                                                        $bqty = $bqty + $batchdata["batch_qty"];
                                                                    }
                                                                    $status = Databases::Search("SELECT * FROM `status` WHERE `id`='" . $productdata["status_id"] . "' ");
                                                                    $statusd = $status->fetch_assoc();
                                                            ?>
                                                                    <tr>
                                                                        <td><?php echo $x; ?></td>
                                                                        <td><img src="product_img\_6616adeba1eea.jpg" class="img-fluid" style="width: 50px; border-radius: 10px;" alt=""></td>
                                                                        <td><?php echo  $productdata["title"] ?></td>
                                                                        <td><?php echo  $productdata["date"] ?></td>
                                                                        <td><?php echo   $iqty ?></td>
                                                                        <td><?php echo   $bqty ?></td>
                                                                        <td><?php echo   $statusd["name"] ?></td>
                                                                        <td><a data-bs-toggle="modal" class="fw-bolder" style="color:rgb(54, 46, 161); cursor: pointer;" onclick="seebatche('<?php echo $productdata["id"]; ?>');">VIEW</a></td>
                                                                        <td hidden><a data-bs-toggle="modal" data-bs-target="#productDetailsModal" class="fw-bolder" style="color:rgb(25, 153, 57); cursor: pointer;" onclick="seeproducte('<?php echo $productdata["id"]; ?>');">VIEW</a></td>
                                                                    </tr>
                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function seebatche(productid) {
                                    var req = new XMLHttpRequest();
                                    var form = new FormData();
                                    form.append("productid", productid);
                                    req.open("POST", "process/batchdatam.php", true);
                                    req.onreadystatechange = function() {
                                        if (req.readyState === 4 && req.status === 200) {
                                            //alert(req.responseText); // (Optional) for debugging
                                            document.getElementById("batchDetailsContent").innerHTML = req.responseText; // Only update inner content

                                            var batchModal = new bootstrap.Modal(document.getElementById('batchDetailsModal'));
                                            batchModal.show();
                                        }
                                    };
                                    req.send(form);
                                }
                            </script>
                            <div class="col-12">
                                <div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;
                                                    Product Management</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row d-flex justify-content-center my-2">
                                                    <div class="col-12 col-lg-9 border shadow">
                                                        <div class="row m-3">

                                                            <div class="col-12 mt-3">
                                                                <div class="row d-flex justify-content-center">
                                                                    <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                                        <input type="file" class="d-none" readonly>
                                                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div">
                                                                            <img src="sample-path/image1.jpg" class="img-fluid" alt="Image 1">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                                        <input type="file" class="d-none" readonly>
                                                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100">
                                                                            <img src="sample-path/image2.jpg" class="img-fluid" alt="Image 2">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                                        <input type="file" class="d-none" readonly>
                                                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100">
                                                                            <img src="sample-path/image3.jpg" class="img-fluid" alt="Image 3">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="product-title" value="Sample Product Title" placeholder="title of the product" readonly>
                                                                    <label for="product-title">Product Title</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="category" value="Electronics" readonly>
                                                                    <label for="category">Product Category</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="group" value="Gadgets" readonly>
                                                                    <label for="group">Product Group</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="subcategory" value="Mobile Phones" readonly>
                                                                    <label for="subcategory">Product Sub-category</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="condition" value="Brand New" readonly>
                                                                    <label for="condition">Product Condition</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="brand" value="Apple" readonly>
                                                                    <label for="brand">Product Brand</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="status" value="Available" readonly>
                                                                    <label for="status">Product Status</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="input-group">
                                                                    <div class="form-floating is-invalid">
                                                                        <input id="weight" type="text" class="form-control rounded-0" value="3.450" readonly>
                                                                        <label>Product Weight (Ex: 3.450)</label>
                                                                    </div>
                                                                    <span class="input-group-text rounded-0">kg</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-3">
                                                                <div class="input-group">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control rounded-0" value="2025-04-25 10:30:00" readonly>
                                                                        <label>Added date and time</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 mt-4 mb-3">
                                                                <textarea class="form-control rounded-0" style="height: 100px" readonly>This is a sample product description. It includes features, specifications, and usage details.</textarea>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="batchDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel">
                                                    <div><i class="fa fa-list" aria-hidden="true"></i>&nbsp;Batch Management</div>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <!-- 
                ✅ We add an inner div here so we can update only this part
                -->
                                                <div id="batchDetailsContent">
                                                    Loading...
                                                </div>
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