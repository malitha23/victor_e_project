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
     <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
     <div class="container mt-5 animate__animated animate__fadeIn">
          <div class="card shadow-lg p-4 rounded-4">
               <div class="container mt-4">
                    <div class="row">
                         <?php
                         $disg = Databases::Search("SELECT * FROM `discount_group`");
                         while ($disgdata = $disg->fetch_assoc()) {
                         ?>
                              <div class="col-md-4 mb-4">
                                   <div class="card">
                                        <div class="card-body">
                                             <h5 class="card-title fw-bold text-primary"> <?php echo $disgdata["title"] ?> </h5>
                                             <p class="card-text text-muted"> <?php echo $disgdata["description"] ?> </p>
                                             <img src="<?php echo 'process/' . $disgdata['image_path']; ?>" class="img-fluid rounded mb-3" alt="Product Image">
                                             <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#batchModal<?php echo $disgdata['id']; ?>">View Batches & Remove</button>
                                        </div>
                                   </div>
                              </div>
                              <!-- Modal for viewing batches -->
                              <div class="modal fade" id="batchModal<?php echo $disgdata['id']; ?>" tabindex="-1" aria-labelledby="batchModalLabel" aria-hidden="true">
                                   <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                                  <h5 class="modal-title" id="batchModalLabel">Batches in <?php echo $disgdata["title"]; ?></h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                             </div>
                                             <div class="modal-body">
                                                  <div class="row">
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
                                                                 <div class="col-sm-6 col-xl-3 mb-4">
                                                                      <div class="card">
                                                                           <img src="<?php echo $imgdata ? $imgdata['path'] : 'assets-admin/images/products/s5.jpg'; ?>" class="card-img-top" alt="Product Image">
                                                                           <div class="card-body">
                                                                                <h6 class="fw-bold text-dark"> <?php echo $productdata["title"]; ?> </h6>
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                     <input id="dcheck<?php echo $batchdata['id']; ?>" type="checkbox" class="form-check-input" data-id="<?php echo $batchdata['id']; ?>" onchange="handleCheckbox(this)">
                                                                                </div>
                                                                                <div class="mt-3">
                                                                                     <label for="qtyInput<?php echo $batchdata['id']; ?>" class="form-label">Quantity</label>
                                                                                     <input type="number" id="qtyInput<?php echo $batchdata['id']; ?>" value="<?php echo $disdatehasprodata["qty"]; ?>" class="form-control">
                                                                                     <button class="btn btn-primary mt-2 w-100" onclick="updateQuantity(<?php echo $batchdata['id']; ?>)">Apply Quantity</button>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
<?php
     }
} ?>
