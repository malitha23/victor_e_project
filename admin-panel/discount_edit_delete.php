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
               <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
               <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
          </head>

          <body>
               <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
                    <?php
                    require "side.php";
                    ?>

                    <div class="body-wrapper">
                         <?php
                         require "nav.php";
                         ?>
                         <div class="container-fluid">
                              <div class="row">
                                   <div class="col-12">
                                        <div class="row">
                                             <div class="col-12">
                                                  <div class="row">
                                                       <div class="col-12">
                                                            <div class="row">
                                                                 <div class="container">
                                                                      <div class="row">
                                                                           <?php
                                                                           $disg = Databases::Search("SELECT * FROM `discount_group`");
                                                                           while ($disgdata = $disg->fetch_assoc()) {
                                                                           ?>
                                                                                <div class="col-md-4 mb-4">
                                                                                     <div class="card shadow-sm border-0 rounded-4">
                                                                                          <div class="card-body p-4">
                                                                                               <!-- Title & Description -->
                                                                                               <h5 class="card-title fw-bold text-primary text-uppercase mb-2">
                                                                                                    <?php echo $disgdata["title"]; ?>
                                                                                               </h5>
                                                                                               <p class="card-text text-muted mb-3">
                                                                                                    <?php echo $disgdata["description"]; ?>
                                                                                               </p>

                                                                                               <!-- Product Image -->
                                                                                               <div class="text-center">
                                                                                                    <img src="<?php echo 'process/' . $disgdata['image_path']; ?>" class="img-fluid rounded-3 shadow-sm" alt="Product Image" style="max-height: 180px; object-fit: cover;">
                                                                                               </div>

                                                                                               <!-- Action Buttons -->
                                                                                               <div class="mt-4">
                                                                                                    <!-- Change Image Button -->
                                                                                                    <button class="btn btn-secondary w-100 mb-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#changeImageModal<?php echo $disgdata['id']; ?>">
                                                                                                         <i class="ph ph-image"></i> Change Image
                                                                                                    </button>

                                                                                                    <!-- Change Image Modal -->
                                                                                                    <div class="modal fade" id="changeImageModal<?php echo $disgdata['id']; ?>" tabindex="-1" aria-hidden="true">
                                                                                                         <div class="modal-dialog modal-dialog-centered">
                                                                                                              <div class="modal-content border-0 shadow">
                                                                                                                   <div class="modal-header bg-primary text-white">
                                                                                                                        <h5 class="modal-title">Upload New Image</h5>
                                                                                                                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                   </div>
                                                                                                                   <div class="modal-body p-4">

                                                                                                                        <input type="hidden" name="product_id" value="<?php echo $disgdata['id']; ?>">

                                                                                                                        <!-- File Input -->
                                                                                                                        <div class="mb-3">
                                                                                                                             <label class="form-label fw-semibold">Select New Image</label>
                                                                                                                             <input type="file" class="form-control" name="new_image" accept="image/*" required>
                                                                                                                        </div>

                                                                                                                        <!-- Upload Button -->
                                                                                                                        <div class="text-end">
                                                                                                                             <button onclick="upnewdisimg(<?php echo $disgdata['id']; ?>);" type="submit" class="btn btn-success">
                                                                                                                                  <i class="ph ph-upload"></i> Upload Image
                                                                                                                             </button>
                                                                                                                        </div>

                                                                                                                   </div>
                                                                                                              </div>
                                                                                                         </div>
                                                                                                    </div>


                                                                                                    <button class="btn btn-primary w-100 mb-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#batchModal<?php echo $disgdata['id']; ?>">
                                                                                                         <i class="ph ph-list"></i> View Batches & Edit
                                                                                                    </button>

                                                                                                    <button class="btn btn-info w-100 mb-2 fw-semibold text-white" data-bs-toggle="modal" data-bs-target="#disdetilModal<?php echo $disgdata['id']; ?>">
                                                                                                         <i class="ph ph-pencil"></i> View & Edit Details
                                                                                                    </button>

                                                                                                    <!-- Enable/Disable Button -->
                                                                                                    <?php if ($disgdata["status"] == 1) { ?>
                                                                                                         <button class="btn btn-warning w-100 mb-2 fw-semibold" onclick="disablediscoun(<?php echo $disgdata['id']; ?>);">
                                                                                                              <i class="ph ph-eye-slash"></i> Disable
                                                                                                         </button>
                                                                                                         <?php } else {
                                                                                                         $tdb = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE
                                                                                                          `discount_group_id`='" . $disgdata['id'] . "' ");
                                                                                                         $tdbn = $tdb->num_rows;
                                                                                                         if ($tdbn > 0) {
                                                                                                         ?>
                                                                                                              <button class="btn btn-success w-100 mb-2 fw-semibold" onclick="disablediscoun(<?php echo $disgdata['id']; ?>);">
                                                                                                                   <i class="ph ph-eye"></i> Enable
                                                                                                              </button>
                                                                                                         <?php
                                                                                                         } else {
                                                                                                         ?>
                                                                                                              <span class="text-success fw-bold m-1">pleace add Batch and Enable</span>
                                                                                                         <?php
                                                                                                         }
                                                                                                         ?>
                                                                                                    <?php } ?>

                                                                                                    <!-- Delete Button -->
                                                                                                    <button class="btn btn-danger w-100 mb-2 fw-semibold m-1 mb-3" onclick="deletdiscoun(<?php echo $disgdata['id']; ?>);">
                                                                                                         <i class="ph ph-trash"></i> Delete
                                                                                                    </button>

                                                                                                    <button class="btn btn-dark w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#addnewdatpreModal<?php echo $disgdata['id']; ?>">
                                                                                                         <i class="ph ph-plus-circle"></i> Add New Date, pre(%)
                                                                                                    </button>

                                                                                                    <!-- Add New Batch -->
                                                                                                    <button class="btn btn-dark w-100 fw-semibold m-2" data-bs-toggle="modal" data-bs-target="#disbachdetilModal<?php echo $disgdata['id']; ?>">
                                                                                                         <i class="ph ph-plus-circle"></i> Add New Batch
                                                                                                    </button>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>

                                                                                <!-- !-->
                                                                                <?php
                                                                                $query = Databases::Search("
                                                                                SELECT 
                                                                                    ddp.id,
                                                                                    ddp.discount_date_range_id,
                                                                                    ddp.discount_pre,
                                                                                    ddp.discount_group_id,
                                                                                    ddp.qty,
                                                                                    ddp.batch_id,
                                                                                    ddr.start_date,
                                                                                    ddr.end_date
                                                                                FROM 
                                                                                    discount_date_range_has_product ddp
                                                                                JOIN 
                                                                                    discount_date_range ddr 
                                                                                ON 
                                                                                    ddp.discount_date_range_id = ddr.id
                                                                                WHERE 
                                                                                    ddp.discount_group_id = '" . $disgdata['id'] . "'
                                                                                ");

                                                                                if ($query->num_rows > 0) {
                                                                                     $existing = $query->fetch_assoc(); // You can loop through multiple entries if needed
                                                                                }
                                                                                ?>

                                                                                <div class="modal fade" id="addnewdatpreModal<?php echo $disgdata['id']; ?>" tabindex="-1" aria-labelledby="addNewDatePreLabel<?php echo $disgdata['id']; ?>" aria-hidden="true">
                                                                                     <div class="modal-dialog modal-dialog-centered">
                                                                                          <div class="modal-content rounded-3 shadow">
                                                                                               <div class="modal-header bg-dark text-white">
                                                                                                    <h5 class="modal-title" id="addNewDatePreLabel<?php echo $disgdata['id']; ?>">Add / Edit Discount Period</h5>
                                                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                               </div>

                                                                                               <form action="update_discount_date.php" method="POST">
                                                                                                    <div class="modal-body">
                                                                                                         <input type="hidden" name="discount_group_id" value="<?php echo $disgdata['id']; ?>">
                                                                                                         <?php if (!empty($existing)) { ?>
                                                                                                              <input type="hidden" name="edit_id" value="<?php echo $existing['id']; ?>">
                                                                                                         <?php } ?>

                                                                                                         <div class="mb-3">
                                                                                                              <label for="percentage<?php echo $disgdata['id']; ?>" class="form-label">Percentage (%)</label>
                                                                                                              <input type="number" name="percentage" class="form-control" id="percentage<?php echo $disgdata['id']; ?>" value="<?php echo isset($existing['discount_pre']) ? $existing['discount_pre'] : ''; ?>" required>
                                                                                                         </div>

                                                                                                         <div class="mb-3">
                                                                                                              <label for="startDate<?php echo $disgdata['id']; ?>" class="form-label">Start Date</label>
                                                                                                              <input type="date" name="start_date" class="form-control" id="startDate<?php echo $disgdata['id']; ?>" value="<?php echo isset($existing['start_date']) ? $existing['start_date'] : ''; ?>" required>
                                                                                                         </div>

                                                                                                         <div class="mb-3">
                                                                                                              <label for="endDate<?php echo $disgdata['id']; ?>" class="form-label">End Date</label>
                                                                                                              <input type="date" name="end_date" class="form-control" id="endDate<?php echo $disgdata['id']; ?>" value="<?php echo isset($existing['end_date']) ? $existing['end_date'] : ''; ?>" required>
                                                                                                         </div>
                                                                                                    </div>

                                                                                                    <div class="modal-footer">
                                                                                                         <button type="submit" class="btn btn-success"><?php echo !empty($existing) ? 'Update' : 'Save'; ?></button>
                                                                                                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                                    </div>
                                                                                               </form>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>

                                                                                <!-- !-->

                                                                                <!-- Modal for viewing batch details -->
                                                                                <div class="modal fade" id="disbachdetilModal<?php echo $disgdata['id']; ?>" tabindex="-1" aria-labelledby="batchModalLabel" aria-hidden="true">
                                                                                     <div class="modal-dialog modal-xl">
                                                                                          <div class="modal-content border-0 shadow-sm rounded-3">
                                                                                               <!-- Modal Header -->
                                                                                               <div class="modal-header bg-dark text-white">
                                                                                                    <h5 class="modal-title fw-bold">Batch Details - Control Panel</h5>
                                                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                               </div>

                                                                                               <!-- Modal Body -->
                                                                                               <div class="modal-body p-4">
                                                                                                    <div class="table-responsive">
                                                                                                         <?php
                                                                                                         $discountRange = Databases::Search("SELECT * FROM `discount_date_range_has_product` 
                                                                                                         WHERE `discount_group_id`='" . $disgdata['id'] . "'");
                                                                                                         if ($discountRange->num_rows > 0) {
                                                                                                         ?>
                                                                                                              <div class="form-floating mb-3">
                                                                                                                   <input type="number" disabled class="form-control" id="EpercentageInput<?php echo $disgdata['id']; ?>" placeholder="Enter percentage">
                                                                                                                   <label for="percentageInput<?php echo $disgdata['id']; ?>">Enter percentage</label>
                                                                                                              </div>
                                                                                                              <div class="form-floating mb-3">
                                                                                                                   <input type="date" disabled class="form-control" id="startdate<?php echo $disgdata['id']; ?>" placeholder="Enter percentage">
                                                                                                                   <label for="startdate<?php echo $disgdata['id']; ?>">discount start date</label>
                                                                                                              </div>
                                                                                                              <div class="form-floating mb-3">
                                                                                                                   <input type="date" disabled class="form-control" id="enddate<?php echo $disgdata['id']; ?>" placeholder="Enter percentage">
                                                                                                                   <label for="enddate<?php echo $disgdata['id']; ?>">discount end date</label>
                                                                                                              </div>
                                                                                                         <?php
                                                                                                         } else {
                                                                                                         ?>
                                                                                                              <div class="form-floating mb-3">
                                                                                                                   <input type="number" class="form-control" id="EpercentageInput<?php echo $disgdata['id']; ?>" placeholder="Enter percentage">
                                                                                                                   <label for="percentageInput<?php echo $disgdata['id']; ?>">Enter percentage</label>
                                                                                                              </div>
                                                                                                              <div class="form-floating mb-3">
                                                                                                                   <input type="date" class="form-control" id="startdate<?php echo $disgdata['id']; ?>" placeholder="Enter percentage">
                                                                                                                   <label for="startdate<?php echo $disgdata['id']; ?>">discount start date</label>
                                                                                                              </div>
                                                                                                              <div class="form-floating mb-3">
                                                                                                                   <input type="date" class="form-control" id="enddate<?php echo $disgdata['id']; ?>" placeholder="Enter percentage">
                                                                                                                   <label for="enddate<?php echo $disgdata['id']; ?>">discount end date</label>
                                                                                                              </div>
                                                                                                         <?php
                                                                                                         }
                                                                                                         ?>

                                                                                                         <table class="table table-hover align-middle">
                                                                                                              <thead class="table-dark">
                                                                                                                   <tr>
                                                                                                                        <th>Product</th>
                                                                                                                        <th>Image</th>
                                                                                                                        <th>Original Price</th>
                                                                                                                        <th>Discounted Price</th>
                                                                                                                        <th>Available Qty</th>
                                                                                                                        <th>Quantity</th>
                                                                                                                        <th>Action</th>
                                                                                                                   </tr>
                                                                                                              </thead>
                                                                                                              <tbody>
                                                                                                                   <?php
                                                                                                                   $bach = Databases::Search("SELECT * FROM `batch` WHERE `Delete`='0' ");
                                                                                                                   while ($bach_d = $bach->fetch_assoc()) {
                                                                                                                        $pr = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $bach_d["product_id"] . "' ");
                                                                                                                        $pr = $pr->fetch_assoc();
                                                                                                                        $pic = Databases::Search("SELECT * FROM `picture` WHERE `product_id`='" . $pr["id"] . "' AND `name`='Image 1' ");
                                                                                                                        $pic_d = $pic->fetch_assoc();
                                                                                                                        $imgSrc = !empty($pic_d["path"]) ? $pic_d["path"] : "assets/images/thumbs/product-two-img2.png";
                                                                                                                   ?>
                                                                                                                        <tr>
                                                                                                                             <td class="fw-bold"><?php echo $pr["title"]; ?></td>
                                                                                                                             <td><img src="<?php echo $imgSrc; ?>" class="img-thumbnail" style="width: 50px; height: 50px;"></td>
                                                                                                                             <td class="text-muted"><del>Rs <?php echo $bach_d["selling_price"] + 20; ?></del></td>
                                                                                                                             <td class="fw-bold text-danger">Rs <?php echo $bach_d["selling_price"]; ?></td>
                                                                                                                             <td class="fw-bold"><?php echo $bach_d["batch_qty"]; ?></td>
                                                                                                                             <td>
                                                                                                                                  <input id="qtydisbach<?php echo $bach_d['id']  ?><?php echo $disgdata['id']; ?>" type="number" min="1" max="<?php echo $bach_d["batch_qty"]; ?>" value="1" class="form-control form-control-sm w-50 d-inline">
                                                                                                                             </td>
                                                                                                                             <td>
                                                                                                                                  <button onclick="adtodiscount(<?= $bach_d['id'] ?>, <?= $disgdata['id']; ?>);" class="btn btn-sm btn-primary">
                                                                                                                                       Add to Discount <i class="ph ph-shopping-cart"></i>
                                                                                                                                  </button>
                                                                                                                             </td>
                                                                                                                        </tr>
                                                                                                                   <?php } ?>
                                                                                                              </tbody>
                                                                                                         </table>
                                                                                                    </div>
                                                                                               </div>

                                                                                               <!-- Modal Footer -->
                                                                                               <div class="modal-footer bg-light">
                                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>


                                                                                <!-- Modal for viewing batch details -->
                                                                                <!-- View and Edit Details Button -->
                                                                                <!-- Modal for Editing Discount Group Details -->
                                                                                <div class="modal fade" id="disdetilModal<?php echo $disgdata['id']; ?>" tabindex="-1" aria-labelledby="batchModalLabel" aria-hidden="true">
                                                                                     <div class="modal-dialog modal-dialog-centered">
                                                                                          <div class="modal-content shadow-lg rounded-3">
                                                                                               <!-- Modal Header -->
                                                                                               <div class="modal-header bg-primary text-white">
                                                                                                    <h5 class="modal-title fw-bold" id="batchModalLabel">
                                                                                                         <i class="ph ph-pencil-line"></i> Edit Discount Group Details
                                                                                                    </h5>
                                                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                               </div>

                                                                                               <!-- Modal Body -->
                                                                                               <div class="modal-body p-4">
                                                                                                    <div class="mb-3">
                                                                                                         <label for="title" class="fw-semibold">Title</label>
                                                                                                         <input type="text" id="distitle<?php echo $disgdata['id']; ?>" name="title" class="form-control border-primary" value="<?php echo $disgdata["title"]; ?>" required />
                                                                                                    </div>

                                                                                                    <div class="mb-3">
                                                                                                         <label for="description" class="fw-semibold">Description</label>
                                                                                                         <textarea id="disdescription<?php echo $disgdata['id']; ?>" name="description" class="form-control border-primary" rows="3" required><?php echo $disgdata["description"]; ?></textarea>
                                                                                                    </div>

                                                                                                    <?php
                                                                                                    $dishp1 = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $disgdata["id"] . "'");
                                                                                                    $dishp1num = $dishp1->num_rows;
                                                                                                    $dishp1data = $dishp1->fetch_assoc();
                                                                                                    ?>
                                                                                                    <p class="text-muted"><i class="ph ph-list-bullets"></i> <?php echo $dishp1num; ?> batches found</p>

                                                                                                    <div class="mb-3">
                                                                                                         <label for="discount_pre" class="fw-semibold">Discount Percentage</label>
                                                                                                         <input type="number" id="discount_pre<?php echo $disgdata['id']; ?>" name="discount_pre" class="form-control border-primary" value="<?php echo $dishp1data["discount_pre"]; ?>" required />
                                                                                                    </div>

                                                                                                    <input type="hidden" name="discount_group_id" value="<?php echo $disgdata["id"]; ?>" />

                                                                                                    <!-- Update Button -->
                                                                                                    <button type="submit" class="btn btn-success w-100 fw-bold mt-3" onclick="updatedis('<?php echo $disgdata['id']; ?>');">
                                                                                                         <i class="ph ph-check-circle"></i> Update
                                                                                                    </button>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>

                                                                                <script src="https://cdn.tiny.cloud/1/v6ya2mxbd70fn22v774qp5fw78t114ccnejem2vy8oriyj04/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

                                                                                <script>
                                                                                     tinymce.init({
                                                                                          selector: 'textarea', // You can adjust this selector to target specific textareas if needed
                                                                                          menubar: false, // Disable the menubar if you don't need it
                                                                                          plugins: 'advlist autolink lists link image charmap print preview anchor',
                                                                                          toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
                                                                                          statusbar: false, // Hide the status bar if you want
                                                                                     });
                                                                                </script>

                                                                                <!-- Modal for viewing batches -->
                                                                                <div class="modal fade" id="batchModal<?php echo $disgdata['id']; ?>" tabindex="-1" aria-labelledby="batchModalLabel" aria-hidden="true">
                                                                                     <div class="modal-dialog modal-lg">
                                                                                          <div class="modal-content rounded-3 shadow-lg">
                                                                                               <!-- Modal Header -->
                                                                                               <div class="modal-header bg-dark text-white">
                                                                                                    <h5 class="modal-title fw-bold" id="batchModalLabel">
                                                                                                         <i class="ph ph-cogs"></i> Batches in <?php echo $disgdata["title"]; ?>
                                                                                                    </h5>
                                                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                               </div>

                                                                                               <!-- Modal Body -->
                                                                                               <div class="modal-body p-4">
                                                                                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                                                                                                         <?php
                                                                                                         $disdatehaspro = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $disgdata["id"] . "'");
                                                                                                         while ($disdatehasprodata = $disdatehaspro->fetch_assoc()) {
                                                                                                              $batch = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $disdatehasprodata['batch_id'] . "'");
                                                                                                              while ($batchdata = $batch->fetch_assoc()) {
                                                                                                                   $product = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "'");
                                                                                                                   $productdata = $product->fetch_assoc();
                                                                                                                   $img = Databases::Search("SELECT * FROM `picture` WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 1'");
                                                                                                                   $imgdata = $img->fetch_assoc();
                                                                                                         ?>
                                                                                                                   <div class="col">
                                                                                                                        <div class="card border-light shadow-sm rounded-3 hover-shadow">
                                                                                                                             <img src="<?php echo $imgdata ? $imgdata['path'] : 'assets-admin/images/products/s5.jpg'; ?>" class="card-img-top" alt="Product Image">
                                                                                                                             <div class="card-body">
                                                                                                                                  <h6 class="fw-semibold text-dark"><?php echo $productdata["title"]; ?></h6>
                                                                                                                                  <div class="d-flex justify-content-between align-items-center">
                                                                                                                                       <label for="dcheck<?php echo $batchdata['id']; ?>" class="form-check-label fw-semibold text-muted">Select</label>
                                                                                                                                       <input id="dcheck<?php echo $batchdata['id']; ?>" type="checkbox" class="form-check-input" data-id="<?php echo $batchdata['id']; ?>" onchange="handleCheckbox(this)">
                                                                                                                                  </div>
                                                                                                                                  <div class="mt-3">
                                                                                                                                       <label for="qtyInput<?php echo $batchdata['id']; ?>" class="form-label">Quantity</label>
                                                                                                                                       <?php
                                                                                                                                       $secpd = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `batch_id`='" . $batchdata['id'] . "' AND `discount_group_id`='" . $disgdata['id'] . "'");
                                                                                                                                       $secpddata = $secpd->fetch_assoc();
                                                                                                                                       ?>
                                                                                                                                       <input min="1" type="number" id="qtyInput<?php echo $batchdata['id']; ?>" value="<?php echo $secpddata["qty"]; ?>" class="form-control border-2" />
                                                                                                                                       <button class="btn btn-primary mt-2 w-100" onclick="updateQuantity(<?php echo $batchdata['id']; ?>, <?php echo $disgdata['id']; ?>)">
                                                                                                                                            <i class="ph ph-check-circle"></i> Apply Quantity
                                                                                                                                       </button>
                                                                                                                                       <button class="btn btn-danger mt-2 w-100" onclick="Removebatch(<?php echo $batchdata['id']; ?>, <?php echo $disgdata['id']; ?>)">
                                                                                                                                            <i class="ph ph-trash"></i> Remove this batch
                                                                                                                                       </button>
                                                                                                                                  </div>
                                                                                                                             </div>
                                                                                                                        </div>
                                                                                                                   </div>
                                                                                                         <?php
                                                                                                              }
                                                                                                         }
                                                                                                         ?>
                                                                                                    </div>
                                                                                               </div>

                                                                                               <!-- Modal Footer (Optional, e.g., Save Changes) -->
                                                                                               <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                    <button type="button" class="btn btn-success" onclick="saveChanges();"><i class="ph ph-check"></i> Save Changes</button>
                                                                                               </div>
                                                                                          </div>
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
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

               </div>
          </body>

          <script src="assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
          <script src="sahan.js"></script>
          <script>
               document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll(".modal").forEach(function(modal) {
                         modal.addEventListener("hidden.bs.modal", function() {
                              setTimeout(function() {
                                   document.querySelectorAll(".modal-backdrop").forEach(function(backdrop) {
                                        backdrop.remove();
                                   });
                                   document.body.classList.remove("modal-open");
                                   document.body.style.overflow = "";
                              }, 100);
                         });
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

          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


          </html>
<?php
     }
} ?>