<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $uemail = $_POST["email"];
     $um = Databases::Search("SELECT * from `user` WHERE `email`='" . $uemail . "' ");
     $umdata = $um->fetch_assoc();
?>
     <div class="modal fade" id="detailsModal_1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
               <div class="modal-content">
                    <div class="modal-header">
                         <div class="modal-title fs-4 fw-bold" id="exampleModalLabel">
                              <i class="fa fa-users" aria-hidden="true"></i>&nbsp; Consumer Details
                         </div>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                         <!-- Personal Info Card -->

                         <div class="card mb-4">
                              <div class="row pt-3 px-2">
                                   <div class="col-4 col-md-2 d-flex justify-content-center align-items-center">
                                        <img src="assets-admin/images/profile/avatar.svg" class="img-fluid" width="90px" alt="User Image">
                                   </div>
                                   <div class="col-8 col-md-10">
                                        <div class="row">
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="text" class="form-control rounded-0" value="<?php echo $umdata["fname"] . " " . $umdata["lname"]; ?>" readonly>
                                                       <label>Full Name</label>
                                                  </div>
                                             </div>
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="text" class="form-control rounded-0" value="<?php echo $umdata["mobile"]; ?>" readonly>
                                                       <label>Mobile</label>
                                                  </div>
                                             </div>
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="text" class="form-control rounded-0" value="<?php echo $umdata["email"]; ?>" readonly>
                                                       <label>Email</label>
                                                  </div>
                                             </div>
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="text" class="form-control rounded-0" value="<?php echo $umdata["mail"]; ?>" readonly>
                                                       <label>Mail (Recovery)</label>
                                                  </div>
                                             </div>
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="date" class="form-control rounded-0" value="<?php echo $umdata["bod"]; ?>" readonly>
                                                       <label>Date of Birth</label>
                                                  </div>
                                             </div>
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="date" class="form-control rounded-0" value="<?php echo $umdata["date"]; ?>" readonly>
                                                       <label>Join Date</label>
                                                  </div>
                                             </div>
                                             <div class="col-12 mb-3">
                                                  <div class="form-floating">
                                                       <?php
                                                       $address_rs = Databases::Search("SELECT * FROM `address` WHERE `address_id`='" . $umdata["adress_id"] . "'");
                                                       if ($address_rs->num_rows == 1) {
                                                            $addressdata = $address_rs->fetch_assoc();

                                                            // Get city and district names
                                                            $city_rs = Databases::Search("SELECT * FROM `city` WHERE `city_id`='" . $addressdata["city_city_id"] . "'");
                                                            $city_data = $city_rs->fetch_assoc();

                                                            $district_rs = Databases::Search("SELECT * FROM `distric` WHERE `distric_id`='" . $addressdata["distric_distric_id"] . "'");
                                                            $district_data = $district_rs->fetch_assoc();

                                                            $full_address = $addressdata["line_1"] . ", " . $addressdata["line_2"] . ", " . $city_data["name"] . ", " . $district_data["name"];
                                                       ?>
                                                            <input type="text" class="form-control rounded-0" value="<?php echo $full_address; ?>" readonly>
                                                            <label>Address</label>
                                                       <?php } ?>
                                                  </div>
                                             </div>
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="text" class="form-control rounded-0" value="<?php echo $umdata["status"] == 1 ? 'Active' : 'Inactive'; ?>" readonly>
                                                       <label>Status</label>
                                                  </div>
                                             </div>
                                             <div class="col-12 col-md-6 mb-3">
                                                  <div class="form-floating">
                                                       <input type="text" class="form-control rounded-0" value="<?php echo $umdata["v_code"]; ?>" readonly>
                                                       <label>Verification Code</label>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>


                         <!-- Invoice Details -->
                         <h5 class="text-primary"><i class="fa fa-file-invoice"></i> Invoice Details</h5>
                         <hr>
                         <?php
                         $invoice_rs = Databases::Search("SELECT * FROM `invoice` WHERE `user_email`='" . $umdata["email"] . "'");
                         if ($invoice_rs->num_rows > 0) {
                         ?>
                              <div class="table-responsive">
                                   <table class="table table-bordered table-striped mt-3">
                                        <thead class="table-dark">
                                             <tr>
                                                  <th>#</th>
                                                  <th>Invoice ID</th>
                                                  <th>Date</th>
                                                  <th>Product</th>
                                                  <th>Vendor</th>
                                                  <th>Qty</th>
                                                  <th>Unit Price</th>
                                                  <th>Discount</th>
                                                  <th>Delivery Fee</th>
                                                  <th>Total</th>
                                                  <th>Status</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                             $i = 1;
                                             while ($invoice = $invoice_rs->fetch_assoc()) {
                                                  // Get order and status
                                                  $order = Databases::Search("SELECT * FROM `order` WHERE `invoice_id`='" . $invoice["uni_code"] . "'");
                                                  $orderd = $order->fetch_assoc();
                                                  $status_rs = Databases::Search("SELECT * FROM `order_status` WHERE `id`='" . $orderd["Order_status_id"] . "'");
                                                  $status_data = $status_rs->fetch_assoc();

                                                  // Get product and batch
                                                  $batch_rs = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $invoice["batch_id"] . "'");
                                                  $batch_data = $batch_rs->fetch_assoc();

                                                  $product_rs = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $invoice["product_id"] . "'");
                                                  $product_data = $product_rs->fetch_assoc();

                                                  // Calculate actual total with discount
                                                  $unit_price = $batch_data["selling_price"];
                                                  $qty = $invoice["qty"];
                                                  $discount = $invoice["discount"];
                                                  $delivery_fee = $invoice["delivery_fee"];
                                                  $total = ($unit_price * $qty) - $discount + $delivery_fee;
                                             ?>
                                                  <tr>
                                                       <td><?php echo $i++; ?></td>
                                                       <td><?php echo $invoice["uni_code"]; ?></td>
                                                       <td><?php echo $invoice["date_time"]; ?></td>
                                                       <td><?php echo $product_data["title"]; ?></td>
                                                       <td><?php echo $batch_data["vendor_name"]; ?></td>
                                                       <td><?php echo $qty; ?></td>
                                                       <td>Rs. <?php echo number_format($unit_price, 2); ?></td>
                                                       <td>Rs. <?php echo number_format($discount, 2); ?></td>
                                                       <td>Rs. <?php echo number_format($delivery_fee, 2); ?></td>
                                                       <td>Rs. <?php echo number_format($total, 2); ?></td>
                                                       <td><?php echo $status_data["status"]; ?></td>
                                                  </tr>
                                             <?php } ?>
                                        </tbody>
                                   </table>
                              </div>
                         <?php
                         } else {
                              echo '<div class="alert alert-info mt-3">This user hasn’t made any purchases yet.</div>';
                         }
                         ?>

                         <!-- Invoice Details -->

                    </div>

                    <div class="modal-footer">
                         <button class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Close</button>
                    </div>
               </div>
          </div>
     </div>
<?php
     exit();
}
?>