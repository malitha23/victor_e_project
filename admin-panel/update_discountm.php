<?php
session_start();
include "db.php";

if (isset($_SESSION["a"])) {

     if (isset($_POST["groupid"])) {

          $groupid = $_POST["groupid"];

          if (!is_numeric($groupid)) {
               echo "Invalid group ID.";
               exit();
          }

          $group = Databases::Search("SELECT * FROM `discount_group` WHERE `id`='" . $groupid . "' ");
          $groupdeta = $group->fetch_assoc();
          $ddrp = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `discount_group_id`='" . $groupdeta["id"] . "' ");
          $ddrpdata = $ddrp->fetch_assoc();
          $date = Databases::Search("SELECT * FROM `discount_date_range` WHERE `id`='" . $ddrpdata["discount_group_id"] . "' ");
          $datedata = $date->fetch_assoc();
          $bach = Databases::Search("SELECT * FROM `batch` WHERE `id`='" . $ddrpdata["batch_id"] . "' ");
          $batchdata = $bach->fetch_assoc();
?>
          <!-- Bootstrap Modal -->
          <div class="modal fade" id="exampleModal<?php echo $groupid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $groupid; ?>" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                         <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel<?php echo $groupid; ?>">Update Discount Details</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                              <form id="updateForm<?php echo $groupid; ?>">
                                   <?php
                                   $image1 = $groupdeta["image_path"];
                                   ?>
                                   <div class="col-8 col-md-4 mb-3" style="height: 200px;">
                                        <input type="file" class="d-none" id="img_input_<?php echo $groupid; ?>" onchange="imageget(<?php echo $groupid; ?>)">
                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div" id="di_<?php echo $groupid; ?>" onclick="document.getElementById('img_input_<?php echo $groupid; ?>').click();">
                                             <?php if ($image1 == "") { ?>
                                                  <span class="small" id="img_span_<?php echo $groupid; ?>">Upload Image</span>
                                             <?php } else { ?>
                                                  <img src="<?php echo $image1; ?>" class="img-fluid" id="img_div_<?php echo $groupid; ?>">
                                             <?php } ?>
                                        </div>
                                   </div>
                                   <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title<?php echo $groupid; ?>" value="<?php echo $groupdeta['title']; ?>">
                                   </div>
                                   <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description<?php echo $groupid; ?>" rows="4"><?php echo $groupdeta['description']; ?></textarea>
                                   </div>
                                   <div class="mb-3">
                                        <label for="discountPre" class="form-label">Discount Percentage</label>
                                        <input type="number" class="form-control" id="discountPre<?php echo $groupid; ?>" value="<?php echo $ddrpdata['discount_pre']; ?>">
                                   </div>
                                   <div class="mb-3">
                                        <label for="qty" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="qty<?php echo $groupid; ?>" value="<?php echo $ddrpdata['qty']; ?>">
                                   </div>
                                   <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date<?php echo $groupid; ?>" value="<?php echo $datedata['start_date']; ?>">
                                   </div>
                                   <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date<?php echo $groupid; ?>" value="<?php echo $datedata['end_date']; ?>">
                                   </div>
                              </form>
                         </div>
                         <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" onclick="saveUpdate(<?php echo $groupid; ?>)">Save Changes</button>
                         </div>
                    </div>
               </div>
          </div>

<?php

     } else {
          echo "No discount group ID provided.";
     }
} else {
     echo "Unauthorized access. Please log in.";
}
