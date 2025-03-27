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
                              <div class="d-flex align-items-center mb-3">
                                   <div class="form-check me-3">
                                        <input hidden class="form-check-input" type="checkbox" id="selectBatches">
                                        <label class="form-check-label" for="selectBatches">
                                             SELECT BATCHES.. TICK THIS CHECKBOX
                                        </label>
                                   </div>
                                   <?php
                                   $batch = Databases::Search("SELECT * FROM `batch` ORDER BY `date` ASC");
                                   $batch_num = $batch->num_rows;
                                   ?>
                                   <button class="btn btn-danger" onclick="ADdiscount('<?php echo $batch_num;  ?>');">ADD Discount</button>
                              </div>
                              <br /><br />
                              <div class="row d-flex justify-content-center" id="ProductResult">

                                   <!-- Example Product Card Start -->
                                   <?php
                                   for ($b = 0; $b < $batch_num; $b++) {
                                        $batchdata = $batch->fetch_assoc();
                                        $product = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "' ");
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
                                                       <h6 class="fw-semibold fs-4"><?php echo $productdata["title"]; ?></h6>
                                                       <div class="d-flex justify-content-end mt-2">
                                                            <!-- Checkbox -->
                                                            <input id="dcheck<?php echo $b; ?>" value="true" type="checkbox" class="checked-danger" data-id="<?php echo $batchdata['id']; ?>" onchange="handleCheckbox(this)" />
                                                       </div>
                                                  </div>
                                                  <div id="qtySection" class="mb-3">
                                                       <label for="qtyInput" class="form-label">Quantity</label>
                                                       <input type="number" value="1" class="form-control" id="qtyInput" placeholder="Enter Quantity">
                                                  </div>
                                                  <!-- !-->
                                             </div>
                                        </div>
                                   <?php
                                   }
                                   ?>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- !-->
               <!-- Modal -->
               <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                         <div class="modal-content">
                              <div class="modal-header bg-primary text-white">
                                   <h5 class="modal-title" id="customModalLabel">Add New Item</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                   <!-- Image Upload Area -->
                                   <div class="mb-3 text-center">
                                        <label for="imageUpload" class="form-label">Upload Image</label>
                                        <input type="file" class="form-control" id="imageUpload" accept="image/*">
                                   </div>

                                   <!-- Title Input -->
                                   <div class="mb-3">
                                        <label for="titleInput" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="titleInput" placeholder="Enter Title">
                                   </div>
                                   <div class="mb-3">
                                        <label for="Discount" class="form-label">Discount price</label>
                                        <input type="number" class="form-control" id="Discount" placeholder="Enter Discount%"><br/>
                                        <span>Enter the percentage.%</span>
                                   </div>
                                   <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input id="start_date" type="date" class="form-control py-2" />
                                   </div>

                                   <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input id="end_date" type="date" class="form-control py-2" />
                                   </div>
                                   <!-- Description Input -->
                                   <div class="mb-3">
                                        <label for="descriptionInput" class="form-label">Description</label>
                                        <textarea class="form-control" id="descriptionInput" rows="4" placeholder="Enter Description"></textarea>
                                   </div>
                              </div>
                              <div class="modal-footer">
                                   <button type="button" class="btn btn-success" onclick="submitdisdetails('<?php echo $batch_num;  ?>');">Submit</button>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- !-->
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
               <script src="sahan.js"></script>
               <!-- Include jQuery library -->
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