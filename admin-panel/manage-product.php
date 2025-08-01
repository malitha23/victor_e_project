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
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.min.css" rel="stylesheet">
        </head>

        <body>
            <!--  Body Wrapper -->
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

                <?php

                require "side.php";

                ?>

                <!-- Main wrapper -->
                <div class="body-wrapper">
                    <!-- Header Start -->

                    <?php
                    require "nav.php";
                    ?>
                    <!-- Header End -->

                    <div class="container-fluid">
                        <div class="row mb-5 d-flex justify-content-end">
                            <div class="col-5 mt-3">
                                <div class="input-group">
                                    <input class="form-control border rounded-pill rounded-end-0" id="pkey" placeholder="Search by name">
                                    <button class="btn border rounded-pill rounded-start-0" onclick="SearchProduct();" type="button" id="button-addon2">
                                        <i class="fa fa-search fs-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center" id="ProductResult">

                            <!-- Example Product Card Start -->
                            <?php
                            $product = Databases::Search("SELECT * FROM `product` WHERE `delete_id`='0' ");
                            $productnum = $product->num_rows;
                            for ($im = 0; $im < $productnum; $im++) {
                                $productdata = $product->fetch_assoc();
                            ?>
                                <div class="col-sm-6 col-xl-3">
                                    <div class="card overflow-hidden rounded-2">
                                        <div class="position-relative p-4 d-flex flex-row align-items-center" style="height:12rem;">
                                            <?php
                                            $img = Databases::Search("SELECT * FROM `picture` WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 1' ");
                                            $imgnum = $img->num_rows;

                                            if ($imgnum > 0) {
                                                $imgdata = $img->fetch_assoc();
                                            ?>
                                                <a href="javascript:void(0)">
                                                    <img src="<?php echo $imgdata['path']; ?>" class="card-img-top rounded-0" alt="Product Image">
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a href="javascript:void(0)">
                                                    <img src="assets-admin/images/products/s5.jpg" class="card-img-top rounded-0" alt="Default Image">
                                                </a>
                                            <?php
                                            }
                                            ?>
                                            <a href="javascript:void(0)" class="bg-green rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
                                                <i class="ti ti-basket fs-4"></i>
                                            </a>
                                        </div>
                                        <div class="card-body pt-3 p-4">
                                            <h6 class="fw-semibold fs-4"><?php echo $productdata["title"] ?></h6>
                                            <div class="d-flex justify-content-end mt-2">
                                                <button class="btn tex-g p-1 rounded-0-5" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $productdata["id"] ?>">UPDATE</button>
                                                <button class="btn tex-b p-1 rounded-0-5" data-bs-toggle="modal" data-bs-target="#exampleModalb<?php echo $productdata["id"] ?>">BATCH</button>
                                                <button class="btn tex-r p-1 rounded-0-5" data-bs-toggle="modal" data-bs-target="#exampleModalx<?php echo $productdata["id"] ?>">DELETE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="exampleModalb<?php echo $productdata["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;
                                                    Batch Management</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row d-flex justify-content-center my-2">
                                                    <div class="col-12 col-lg-10 ">

                                                        <?php
                                                        $batch = Databases::Search("SELECT * FROM `batch` WHERE `product_id`='".$productdata["id"]."' AND  `Delete`='0' ORDER BY `date` ASC");
                                                        $batch_num = $batch->num_rows;
                                                        for ($io = 0; $io < $batch_num; $io++) {
                                                            $batchdata = $batch->fetch_assoc();
                                                        ?>

                                                            <!-- batch 1 start -->
                                                            <div class="row p-3 border border-dark-subtle shadow mt-4">

                                                                <div class="col-6 mt-3">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control rounded-0" id="bbatch_code<?php echo $batchdata["id"]; ?>" value="<?php echo $batchdata["batch_code"]; ?>" placeholder="Batch ID">
                                                                        <label for="floatingInput">Batch CODE</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6 mt-3">
                                                                    <div class="input-group">
                                                                        <div class="form-floating is-invalid">
                                                                            <input type="datetime" value="<?php echo $batchdata["date"]; ?>" class="form-control rounded-0" readonly>
                                                                            <label>Added date and time</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 mt-3">
                                                                    <div class="form-floating">
                                                                        <input readonly type="text" class="form-control rounded-0" value="<?php echo $productdata["title"]; ?>" placeholder="title of the product">
                                                                        <label for="floatingInput">Product Title</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6 mt-4">
                                                                    <div class="form-floating">
                                                                        <input id="vendornameb<?php echo $batchdata["id"]; ?>" value="<?php echo $batchdata["vendor_name"]; ?>" type="text" class="form-control rounded-0">
                                                                        <label>Vendor Name</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6 mt-4">
                                                                    <div class="form-floating">
                                                                        <input id="batchqty<?php echo $batchdata["id"]; ?>" type="number" class="form-control rounded-0" value="<?php echo $batchdata["batch_qty"]; ?>">
                                                                        <label>Batch Qty</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6 mt-4">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text rounded-0">LKR</span>
                                                                        <div class="form-floating is-invalid">
                                                                            <input id="Batchprice<?php echo $batchdata["id"]; ?>" type="text" class="form-control" value="<?php echo $batchdata["batch_price"]; ?>" required>
                                                                            <label>Batch Price</label>
                                                                        </div>
                                                                        <span class="input-group-text rounded-0">.00</span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6 mt-4 mb-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text rounded-0">LKR</span>
                                                                        <div class="form-floating is-invalid">
                                                                            <input type="text" id="selling_price<?php echo $batchdata["id"]; ?>" class="form-control" value="<?php echo $batchdata["selling_price"]; ?>" required>
                                                                            <label>Selling Price</label>
                                                                        </div>
                                                                        <span class="input-group-text rounded-0">.00</span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- batch 1 end -->

                                                            <div class="row">
                                                                <div class="col-12 text-end mt-1">
                                                                    <button onclick="savebatchup('<?php echo $batchdata['id']; ?>');" class="btn rounded-1 fw-bold x col-md-2">
                                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        <?php
                                                        }
                                                        ?>


                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Modal for delete confirmation -->
                                <div class="modal fade" id="exampleModalx<?php echo $productdata["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel">Warning&nbsp;&nbsp;<i class="fa fa-exclamation" aria-hidden="true"></i>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <span>Do you really want to delete <b>Example Product Title</b>?</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onclick="deleteProduct('<?php echo $productdata["id"]; ?>');" class="btn ub-btn">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="exampleModal<?php echo $productdata["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <?php
                                                                    $image = Databases::Search("SELECT * FROM `picture` WHERE `product_id`='" . $productdata["id"] . "' ");
                                                                    $imagenum = $image->num_rows;
                                                                    $image1 = "";
                                                                    $image2 = "";
                                                                    $image3 = "";
                                                                    for ($i = 0; $i < $imagenum; $i++) {
                                                                        $imagedata = $image->fetch_assoc();
                                                                        if ($imagedata["name"] == "Image 1") {
                                                                            $image1 = $imagedata["path"];
                                                                        } elseif ($imagedata["name"] == "Image 2") {
                                                                            $image2 = $imagedata["path"];
                                                                        } elseif ($imagedata["name"] == "Image 3") {
                                                                            $image3 = $imagedata["path"];
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                                        <input type="file" class="d-none" id="img_input_<?php echo $productdata['id']; ?>_1" onclick="imageget(<?php echo $productdata['id']; ?>, 1);">
                                                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div" id="di_<?php echo $productdata['id']; ?>_1" onclick="uProductImage(<?php echo $productdata['id']; ?>, 1);">
                                                                            <?php if ($image1 == "") { ?>
                                                                                <span class="small" id="img_span_<?php echo $productdata['id']; ?>_1">Image 1</span>
                                                                            <?php } else { ?>
                                                                                <img src="<?php echo $image1; ?>" class="img-fluid" id="img_div_<?php echo $productdata['id']; ?>_1">
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                                        <input onclick="imageget(<?php echo $productdata['id']; ?>, 2);" type="file" class="d-none" id="img_input_<?php echo $productdata['id']; ?>_2">
                                                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100" id="di_<?php echo $productdata['id']; ?>_2" onclick="uProductImage(<?php echo $productdata['id']; ?>, 2);">
                                                                            <?php
                                                                            if ($image2 == "") {
                                                                            ?>
                                                                                <span class="small" id="img_span_<?php echo $productdata['id']; ?>_2">Image 2</span>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <img src="<?php echo $image2; ?>" class="img-fluid" id="img_div_<?php echo $productdata['id']; ?>_2">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                                        <input onclick="imageget(<?php echo $productdata['id']; ?>, 3)" type="file" class="d-none" id="img_input_<?php echo $productdata['id']; ?>_3">
                                                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100" id="di_<?php echo $productdata['id']; ?>_3" onclick="uProductImage(<?php echo $productdata['id']; ?>,3);">
                                                                            <?php
                                                                            if ($image3 == "") {
                                                                            ?>
                                                                                <span class="small" id="img_span_<?php echo $productdata['id']; ?>_3">Image 3</span>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <img src="<?php echo $image3; ?>" class="img-fluid" id="img_div_<?php echo $productdata['id']; ?>_3">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" id="productt<?php echo $productdata["id"]; ?>" value="<?php echo $productdata["title"]; ?>" placeholder="title of the product">
                                                                    <label for="floatingInput">Product Title</label>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $subcategory = Databases::Search("SELECT * FROM `sub_category` WHERE `id`='" . $productdata["sub_category_id"] . "' ");
                                                            $subcategorydata = $subcategory->fetch_assoc();
                                                            $category = Databases::Search("SELECT * FROM `category` WHERE `id`='" . $subcategorydata["category_id"] . "' ");
                                                            $categorydata = $category->fetch_assoc();
                                                            ?>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0" id="pc<?php echo $productdata["id"]; ?>" aria-label="Floating label select example">
                                                                        <?php
                                                                        $cat = Databases::Search("SELECT * FROM `category`");
                                                                        $catnum = $cat->num_rows;
                                                                        for ($i = 0; $i < $catnum; $i++) {
                                                                            $catdata = $cat->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $catdata["id"] ?>"><?php echo $catdata["name"] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <option selected value="<?php echo $categorydata["id"] ?>"><?php echo $categorydata["name"] ?></option>
                                                                    </select>
                                                                    <label for="floatingSelect">Select your product Category here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0" id="group<?php echo $productdata["id"]; ?>" aria-label="Floating label select example">
                                                                        <?php
                                                                        $avgroup = Databases::Search("SELECT * FROM `group` WHERE `id`='" . $categorydata["group_id"] . "' ");
                                                                        $avgroupdata = $avgroup->fetch_assoc();
                                                                        ?>
                                                                        <option selected value="<?php echo $avgroupdata["id"] ?>"><?php echo $avgroupdata["group_name"] ?></option>
                                                                        <?php
                                                                        $group = Databases::Search("SELECT * FROM `group`");
                                                                        $groupnum = $group->num_rows;
                                                                        for ($i = 0; $i < $groupnum; $i++) {
                                                                            $groupdata = $group->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $groupdata["id"] ?>"><?php echo $groupdata["group_name"] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <label for="floatingSelect">Select your product group here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0" id="subcategory<?php echo $productdata["id"]; ?>" aria-label="Floating label select example">
                                                                        <option selected value="<?php echo $subcategorydata["id"] ?>"><?php echo $subcategorydata["name"] ?></option>
                                                                        <?php
                                                                        $subcate = Databases::Search("SELECT * FROM sub_category");
                                                                        $subcatenum = $subcate->num_rows;
                                                                        for ($i = 0; $i < $subcatenum; $i++) {
                                                                            $subcatedata = $subcate->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $subcatedata["id"] ?>"><?php echo $subcatedata["name"] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <label for="floatingSelect">Select your product sub_category here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0" id="condition<?php echo $productdata["id"]; ?>" aria-label="Floating label select example">
                                                                        <?php
                                                                        $condition = Databases::Search("SELECT * FROM `condition`");
                                                                        $conditionnum = $condition->num_rows;
                                                                        for ($i = 0; $i < $conditionnum; $i++) {
                                                                            $conditiondata = $condition->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $conditiondata["id"]; ?>"><?php echo $conditiondata["name"]; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        $activcondition = Databases::Search("SELECT * FROM `condition` WHERE `id`='" . $productdata["condition_id"] . "' ");
                                                                        $activconditiondata = $activcondition->fetch_assoc();
                                                                        ?>
                                                                        <option selected value="<?php echo  $activconditiondata["id"] ?>"><?php echo  $activconditiondata["name"] ?></option>
                                                                    </select>
                                                                    <label for="floatingSelect">Select your product condition here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0" id="brand<?php echo $productdata["id"]; ?>" aria-label="Floating label select example">
                                                                        <?php
                                                                        $brand = Databases::Search("SELECT * FROM `brand`");
                                                                        $brandnum = $brand->num_rows;
                                                                        for ($i = 0; $i < $brandnum; $i++) {
                                                                            $branddata = $brand->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $branddata["id"]; ?>"><?php echo $branddata["name"]; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        $activbrand = Databases::Search("SELECT * FROM `brand` WHERE `id`='" . $productdata["brand_id"] . "' ");
                                                                        $activbranddata = $activbrand->fetch_assoc();
                                                                        ?>
                                                                        <option selected value="<?php echo  $activbranddata["id"]; ?>"><?php echo  $activbranddata["name"]; ?></option>
                                                                    </select>
                                                                    <label for="floatingSelect">Select your product brand here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0" id="status<?php echo $productdata["id"]; ?>" aria-label="Floating label select example">
                                                                        <?php
                                                                        $status = Databases::Search("SELECT * FROM `status`");
                                                                        $statusnum = $status->num_rows;
                                                                        for ($i = 0; $i < $statusnum; $i++) {
                                                                            $statusdata = $status->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $statusdata["id"] ?>"><?php echo $statusdata["id"] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        $availablestatus = Databases::Search("SELECT * FROM `status` WHERE `id`='" . $productdata["status_id"] . "' ");
                                                                        $availablestatusdata = $availablestatus->fetch_assoc();
                                                                        ?>
                                                                        <option selected value="<?php echo $availablestatusdata["id"] ?>"><?php echo $availablestatusdata["name"] ?></option>
                                                                    </select>
                                                                    <label for="floatingSelect">Select your product status here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="input-group">
                                                                    <div class="form-floating is-invalid">
                                                                        <input id="weight<?php echo $productdata["id"]; ?>" type="text" class="form-control rounded-0" value="<?php echo $productdata["weight"]; ?>" required>
                                                                        <label>Product Weight ( Ex:-3.450 )</label>
                                                                    </div>
                                                                    <span class="input-group-text rounded-0">kg</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="input-group">
                                                                    <div class="form-floating is-invalid">
                                                                        <input value="<?php echo $productdata["date"]; ?>" type="datetime" class="form-control rounded-0" readonly>
                                                                        <label>Added date and time</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-4 mb-3">
                                                                <textarea id="desc<?php echo $productdata["id"]; ?>" class="form-control rounded-0" name="editor1" style="height: 100px"><?php echo $productdata["description"] ?></textarea>
                                                            </div>

                                                            <div class="col-12 text-end mt-3">
                                                                <button class="btn rounded-1 fw-bold x col-md-2" onclick="update_product(<?php echo $productdata["id"]; ?>)">
                                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <!-- Example Product Card End -->

                            <!-- Modal for updating product -->


                            <!-- Modal for updating batch -->
                            <div class="modal fade" id="exampleModalb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i class="fa fa-list" aria-hidden="true"></i>&nbsp;
                                                Batch Management</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row d-flex justify-content-center my-2">
                                                <div class="col-12 col-lg-10 ">

                                                    <!-- batch 1 start -->
                                                    <div class="row p-3 border border-dark-subtle shadow">

                                                        <div class="col-6 mt-3">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control rounded-0" id="pt" value="B1234#" placeholder="Batch ID">
                                                                <label for="floatingInput">Batch ID</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mt-3">
                                                            <div class="input-group">
                                                                <div class="form-floating is-invalid">
                                                                    <input type="date" class="form-control rounded-0" readonly>
                                                                    <label>Added date and time</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-3">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control rounded-0" id="pt" value="Example Product Title" placeholder="title of the product">
                                                                <label for="floatingInput">Product Title</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mt-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control rounded-0" placeholder="Vendor Name">
                                                                <label>Vendor Name</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mt-4">
                                                            <div class="form-floating">
                                                                <input type="number" class="form-control rounded-0" placeholder="Product Qty">
                                                                <label>Batch Qty</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mt-4">
                                                            <div class="input-group">
                                                                <span class="input-group-text rounded-0">LKR</span>
                                                                <div class="form-floating is-invalid">
                                                                    <input type="text" class="form-control" placeholder="Enter Amount" required>
                                                                    <label>Batch Price</label>
                                                                </div>
                                                                <span class="input-group-text rounded-0">.00</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mt-4 mb-3">
                                                            <div class="input-group">
                                                                <span class="input-group-text rounded-0">LKR</span>
                                                                <div class="form-floating is-invalid">
                                                                    <input type="text" class="form-control" placeholder="Enter Amount" required>
                                                                    <label>Selling Price</label>
                                                                </div>
                                                                <span class="input-group-text rounded-0">.00</span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- batch 1 end -->

                                                    <div class="row">
                                                        <div class="col-12 text-end mt-3">
                                                            <button class="btn rounded-1 fw-bold x col-md-2" onclick="">
                                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE
                                                            </button>
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
                </div>
            </div>

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

            <script src="https://cdn.tiny.cloud/1/723hsc796jwdbccgl2cjvmqzh651t875e476ph2334nnlnhu/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

            <script>
                // Wait for the document to be ready
                document.addEventListener("DOMContentLoaded", function() {
                    // Initialize TinyMCE with API key
                    tinymce.init({
                        selector: 'textarea',
                        apiKey: '723hsc796jwdbccgl2cjvmqzh651t875e476ph2334nnlnhu', // Replace 'YOUR_API_KEY_HERE' with your actual API key
                        plugins: 'autosave autolink lists link',
                        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link',
                        menubar: false,
                    });
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/sidebarmenu.js"></script>
            <script src="../assets/js/app.min.js"></script>
            <script src="../admin-panel/assets-admin/js/script.js"></script>
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
            <script src="../admin-panel/assets-admin/libs/jquery/dist/jquery.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../admin-panel/assets-admin/js/sidebarmenu.js"></script>
            <script src="../admin-panel/assets-admin/js/app.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/simplebar/dist/simplebar.js"></script>
            <script src="../admin-panel/assets-admin/js/dashboard.js"></script>
            <script src="../script.js"></script>
            <script src="../denu.js"></script>
            <script src="../M.js"></script>
            <!-- Include jQuery library -->
            <script src="sahan.js"></script>
            <!-- Include jQuery library -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.min.js"></script>

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