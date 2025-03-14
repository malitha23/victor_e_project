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
               <title>Manage Discounts</title>
               <link rel="shortcut icon" href="assets/img/logo-icon.ico" type="image/x-icon">
               <link rel="stylesheet" href="assets-admin/css/style.css" />
               <link rel="stylesheet" href="assets-admin/css/styles.min.css" />
               <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.min.css" rel="stylesheet">
               <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
               <style>
                    .card {
                         transition: transform 0.3s;
                    }

                    .card:hover {
                         transform: scale(1.05);
                    }
               </style>
          </head>

          <body>
               <div class="container-fluid">
                    <div class="row">
                         <div class="col-12">
                              <div class="row">
                                   <h1 class="text-center mb-5">Manage Discounts</h1>
                                   <div class="col-5 mt-3 mb-3">
                                        <div class="input-group">
                                             <input class="form-control border rounded-pill rounded-end-0" id="diskey" placeholder="Search by name">
                                             <button class="btn btn-primary border rounded-pill rounded-start-0" onclick="Searchdicount();">
                                                  <i class="fa fa-search"></i>
                                             </button>
                                        </div>
                                   </div>
                                   <div class="row d-flex justify-content-center" id="ProductResult">
                                        <?php
                                        $batch = Databases::Search("SELECT * FROM `discount_group`");
                                        $batch_num = $batch->num_rows;
                                        for ($b = 0; $b < $batch_num; $b++) {
                                             $batchdata = $batch->fetch_assoc();
                                             $product = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $batchdata["id"] . "'");
                                             $productdata = $product->fetch_assoc();

                                             $bm = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $productdata["batch_id"] . "'");
                                             $bdeta = $bm->fetch_assoc();
                                        ?>
                                             <div class="container-fluid" id="inject-model"></div>
                                             <div class="col-sm-6 col-xl-3 mb-4">
                                                  <div class="card shadow">
                                                       <div class="position-relative">
                                                            <a href="#">
                                                                 <img src="<?php echo !empty($batchdata['image_path']) ? $batchdata['image_path'] : 'assets-admin/images/products/s5.jpg'; ?>" class="card-img-top" alt="Product Image">
                                                            </a>
                                                       </div>
                                                       <div class="card-body">
                                                            <h6 class="card-title fw-bold text-truncate">Title: <?php echo $batchdata["title"]; ?></h6>
                                                            <p>Description: <?php echo $batchdata["description"]; ?></p>
                                                            <p>Discount Percentage: <?php echo $productdata["discount_pre"]; ?>%</p>
                                                            <p>Quantity: <?php echo $productdata["qty"]; ?></p>
                                                            <?php
                                                            $date = Databases::Search("SELECT * FROM `discount_date_range` WHERE `id`='" . $productdata["discount_date_range_id"] . "' ");
                                                            $date = $date->fetch_assoc();
                                                            ?>
                                                            <p>start_date <?php echo  $date["start_date"]; ?></p>
                                                            <p>end_date <?php echo  $date["end_date"]; ?></p>
                                                            <h5>Batch Details:</h5>
                                                            <p>Vendor Name: <?php echo $bdeta["vendor_name"]; ?></p>
                                                            <p>Batch Code: <?php echo $bdeta["batch_code"]; ?></p>
                                                            <p>Selling Price: $<?php echo $bdeta["selling_price"]; ?></p>
                                                            <?php
                                                            $pm = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $bdeta["product_id"] . "' ");
                                                            $pmd = $pm->fetch_assoc();
                                                            ?>
                                                            <p><?php echo $pmd["title"] ?></p>
                                                            <div class="d-flex justify-content-between">
                                                                 <button class="btn btn-warning" onclick="updatedis('<?php echo $batchdata['id']; ?>')">UPDATE</button>
                                                                 <button class="btn btn-danger">DELETE</button>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!-- !-->
                                             <!-- !-->
                                        <?php
                                        }
                                        ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
               <script src="sahan.js"></script>
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
          echo "<script>Swal.fire('Error', 'User not found.', 'error');</script>";
     }
} else {
     echo "<script>Swal.fire('Error', 'Unauthorized access. Please log in.', 'error');</script>";
}
?>