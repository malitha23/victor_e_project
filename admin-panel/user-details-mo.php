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
                                        <th>Invoice ID(uni_code)</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($invoice = $invoice_rs->fetch_assoc()) {
                                        $order = Databases::Search("SELECT * FROM `order` WHERE `invoice_id`='".$invoice["uni_code"]."' ");
                                        $orderd = $order->fetch_assoc();
                                        $status_rs = Databases::Search("SELECT * FROM `order_status` WHERE `id`='" . $orderd["Order_status_id"] . "'");
                                        $status_data = $status_rs->fetch_assoc();
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $invoice["uni_code"]; ?></td>
                                            <td><?php echo $invoice["date_time"]; ?></td>
                                            <td>Rs. <?php echo number_format($invoice["price"], 2); ?></td>
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
