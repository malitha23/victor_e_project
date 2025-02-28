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

    <body class="loading_body">
      <!--  Body Wrapper -->
      <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <?php

        require "side.php";

        ?>
        <!--  Main wrapper -->
        <div class="body-wrapper">

          <?php
          require "nav.php";
          ?>

          <div class="container-fluid">

            <div class="row d-flex justify-content-center">
              <div class="col-12 text-center mb-3">
                <div class="mb-1">
                  <span class="h4 mb-9 fw-semibold">Add new Product&nbsp;&nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                </div>
                <div>
                  <span class="mb-9 text-dark-emphasis">You can add new product here</span>
                </div>
              </div>
              <div class="col-12 col-lg-10 border shadow">
                <div class="row m-3">
                  <div class="col-12 mt-4">
                    <div class="form-floating">
                      <input type="text" class="form-control rounded-0" placeholder="title of the product">
                      <label>Product Title</label>
                    </div>
                  </div>

                  <div class="col-6 mt-4">
                    <div class="form-floating">
                      <select class="form-select rounded-0" aria-label="Floating label select example">
                        <option selected>Select Product Group</option>
                      </select>
                      <label>Select your product group here</label>
                    </div>
                    <button class="btn x rounded-0 mt-2 d-grid col-12" data-bs-toggle="modal" data-bs-target="#weightModal">Add New Group</button>

                    <!--Add Group Modal-->
                    <div class="modal fade" id="weightModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Group</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="col-12">
                              <div class="form-floating">
                                <input type="text" class="form-control rounded-0" placeholder="title of the product">
                                <label>Group Name</label>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn x"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Add Group Modal-->
                  </div>

                  <div class="col-6 mt-4">
                    <div class="form-floating">
                      <select class="form-select rounded-0" aria-label="Floating label select example">
                        <option selected>Select product category</option>
                      </select>
                      <label>Select your product category here</label>
                    </div>
                    <button class="btn x rounded-0 mt-2 d-grid col-12" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Category</button>

                    <!--Add New Category Modal-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Category</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="col-12">
                              <div class="form-floating">
                                <input type="text" class="form-control rounded-0" placeholder="title of the product">
                                <label>Category Name</label>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn x"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Add New Category Modal-->
                  </div>

                  <div class="col-6 mt-4">
                    <div class="form-floating">
                      <select class="form-select rounded-0" aria-label="Floating label select example">
                        <option selected>Select Product Condition</option>
                      </select>
                      <label>Select Product Condition</label>
                    </div>
                  </div>

                  <div class="col-6 mt-4">
                    <div class="form-floating">
                      <select class="form-select rounded-0" aria-label="Floating label select example">
                        <option selected>Select Product Status</option>
                      </select>
                      <label>Select Product Status</label>
                    </div>
                  </div>

                  <div class="col-12 mt-4">
                    <div class="row justify-content-center">
                      <div class="col-6">
                        <div class="input-group">
                          <div class="form-floating is-invalid">
                            <input type="text" class="form-control rounded-0" placeholder="Enter Amount" required>
                            <label>Product Weight ( Ex:-3.450 )</label>
                          </div>
                          <span class="input-group-text rounded-0">kg</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mt-4 mb-3">
                    <textarea class="form-control rounded-0" name="editor1" placeholder="Product Description" style="height: 100px"></textarea>
                  </div>

                  <div class="col-12 mb-3">
                    <div class="row d-flex justify-content-center">
                      <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                        <input type="file" class="d-none" id="img_input_1">
                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div" id="di_1"
                          onclick="tProductImage(1);"><span class="small" id="img_span_1">Image 1</span>
                          <img src="" class="img-fluid" id="img_div_1">
                        </div>
                      </div>
                      <div class="col-8 col-md-4  mb-2" style="height: 200px;">
                        <input type="file" class="d-none" id="img_input_2">
                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100" id="di_2"
                          onclick="tProductImage(2);"><span class="small" id="img_span_2">Image 2</span>
                          <img src="" class="img-fluid" id="img_div_2">
                        </div>
                      </div>
                      <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                        <input type="file" class="d-none" id="img_input_3">
                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100" id="di_3"
                          onclick="tProductImage(3);"><span class="small" id="img_span_3">Image 3</span>
                          <img src="" class="img-fluid" id="img_div_3">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mb-3">
                    <div class="form-check">
                      <input class="form-check-input border border-dark" type="checkbox" value="" id="flexCheckChecked">
                      <label class="form-check-label text-dark fw-bold" for="flexCheckChecked">
                        Consignment Stock *
                      </label>
                    </div>
                  </div>

                  <div class="col-12 text-end">
                    <button class="btn rounded-1 fw-bold x col-md-2"><i class="fa fa-plus-circle" aria-hidden="true"></i> ADD</button>
                  </div>
                </div>
              </div>

              <div class="col-12 col-lg-10 border shadow mt-5">
                <div class="row m-3">

                  <div class="col-12 mt-4">
                    <div class="form-floating">
                      <select class="form-select rounded-0" aria-label="Floating label select example">
                        <option selected>Select Product</option>
                      </select>
                      <label>Select your product here</label>
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

                  <div class="col-6 mt-4">
                    <div class="input-group">
                      <span class="input-group-text rounded-0">LKR</span>
                      <div class="form-floating is-invalid">
                        <input type="text" class="form-control" placeholder="Enter Amount" required>
                        <label>Selling Price</label>
                      </div>
                      <span class="input-group-text rounded-0">.00</span>
                    </div>
                  </div>

                  <div class="col-12 text-end mt-4">
                    <button class="btn rounded-1 fw-bold x col-md-2"><i class="fa fa-plus-circle" aria-hidden="true"></i> ADD</button>
                  </div>
                </div>
              </div>

            </div>
            
          </div>
        </div>
      </div>

      <script src="https://cdn.tiny.cloud/1/v6ya2mxbd70fn22v774qp5fw78t114ccnejem2vy8oriyj04/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

      <script>
        // Wait for the document to be ready
        document.addEventListener("DOMContentLoaded", function() {
          // Initialize TinyMCE with API key
          tinymce.init({
            selector: 'textarea',
            apiKey: 'v6ya2mxbd70fn22v774qp5fw78t114ccnejem2vy8oriyj04', // Replace 'YOUR_API_KEY_HERE' with your actual API key
            plugins: 'autosave autolink lists link',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link',
            menubar: false,
          });
        });
      </script>

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