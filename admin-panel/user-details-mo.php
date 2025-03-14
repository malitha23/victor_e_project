<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $uemail = $_POST["email"];
     $um = Databases::Search("SELECT * from `user` WHERE `email`='" . $uemail . "' ");
     $umdata = $um->fetch_assoc();
?>
     <div class="modal fade" id="detailsModal_1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
               <div class="modal-content">
                    <div class="modal-header">
                         <div class="modal-title fs-4 fw-bold" id="exampleModalLabel">
                              <i class="fa fa-users" aria-hidden="true"></i>&nbsp; Consumer Details
                         </div>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4">
                         <div class="card mb-0">
                              <div class="row pt-3 px-2">
                                   <div class="col-4 col-md-2 d-flex justify-content-center align-items-center">
                                        <img src="assets-admin/images/profile/avatar.svg" class="img-fluid" width="90px" alt="">
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
                                                       $address = Databases::Search("SELECT * FROM `address` WHERE `address_id`='" . $umdata["adress_id"] . "' ");
                                                       if ($address->num_rows == 1) {
                                                            $addressdata = $address->fetch_assoc();
                                                       ?>
                                                            <input type="text" class="form-control rounded-0" value="<?php echo $addressdata["line_1"] . " " . $addressdata["line_2"]; ?>" readonly>
                                                            <label>Address</label>
                                                       <?php } ?>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button class="btn fw-bold x" data-bs-dismiss="modal">Close</button>
                    </div>
               </div>
          </div>
     </div>
<?php
     exit();
}
?>