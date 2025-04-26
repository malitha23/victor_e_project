<?php
require_once '../db.php';

if (isset($_POST['productid'])) {
     $productid = (int) $_POST['productid'];

     $batch = Databases::Search("SELECT * FROM `batch` WHERE `product_id`='" . $productid . "' ");
     $batchnum = $batch->num_rows;
?>
     <div class="modal-body" id="batchDetailsContent">
          <div class="row d-flex justify-content-center my-2">
               <div class="col-12 border shadow">

                    <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                         <div class="col-12 shadow p-3 py-4">
                              <div class="row">
                                   <div class="div-12 small text-center">Product Name Here</div>
                                   <div class="col-12 d-flex justify-content-center mt-2">
                                        <div class="table-responsive bg-white border w-100" style=" overflow-x: auto;">
                                             <table class="table mb-0 table-bordered">
                                                  <thead>
                                                       <tr style="background-color: azure;">
                                                            <th></th>
                                                            <th>BATCH</th>
                                                            <th>DATE</th>
                                                            <th>VENDOR</th>
                                                            <th>PRICE</th>
                                                            <th>SOLD</th>
                                                            <th>STOCK</th>
                                                            <th>INCOME</th>
                                                            <th>DISCOUNTS</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody id="">

                                                       <?php
                                                       for ($x = 1; $x < $batchnum; $x++) {
                                                            $batchdata = $batch->fetch_assoc();
                                                       ?>
                                                            <tr>
                                                                 <td class="fw-bold"><?php echo $x; ?></td>
                                                                 <td class="fw-bold"><?php echo $batchdata["batch_code"]; ?></td>
                                                                 <td>
                                                                      <div class="fw-bold">2024/12/15</div>
                                                                      <div class="fw-bold">13:12</div>
                                                                 </td>
                                                                 <td class="fw-bold"><?php echo $batchdata["vendor_name"]; ?></td>
                                                                 <td>
                                                                      <div class="fw-bold">Batch : Rs.<?php echo $batchdata["batch_price"]; ?></div>
                                                                      <div class="fw-bold">Selling : Rs.<?php echo $batchdata["selling_price"]; ?></div>
                                                                 </td>
                                                                 <td>
                                                                      <?php
                                                                      $invoice = Databases::Search("SELECT * FROM `invoice` WHERE `batch_id`='" . $batchdata["id"] . "' LIMIT 4 ");
                                                                      $invoicen = $invoice->num_rows;
                                                                      for ($i = 0; $i < $invoicen; $i++) {
                                                                           $invoiced = $invoice->fetch_assoc();
                                                                      ?>
                                                                           <div class="fw-bold " style="color:rgb(233, 72, 72);"><?php echo $invoiced["date_time"] ?> : <?php echo $invoiced["qty"] ?></div>
                                                                      <?php
                                                                      }
                                                                      ?>
                                                                 </td>
                                                                 <td>
                                                                      <?php
                                                                      $invoicek = Databases::Search("SELECT * FROM `invoice` WHERE `batch_id`='" . $batchdata["id"] . "' ");
                                                                      $invoicenk = $invoicek->num_rows;
                                                                      $sqty = 0;
                                                                      $income = 0;
                                                                      for ($ik = 0; $ik <  $invoicenk; $ik++) {
                                                                           $invoicedk = $invoicek->fetch_assoc();
                                                                           $sqty = $sqty + $invoicedk["qty"];
                                                                           $income = $income + $invoicedk["price"];
                                                                      }
                                                                      ?>
                                                                      <div class="fw-bold">Sold : <?php echo $sqty; ?></div>
                                                                      <div class="fw-bold">Remain : <?php echo $batchdata["batch_qty"]; ?></div>
                                                                 </td>
                                                                 <td class="fw-bold">Rs. <?php echo $income; ?></td>
                                                                 <?php
                                                                 $dis = Databases::Search("SELECT * FROM `discount_date_range_has_product` WHERE `batch_id`='" . $batchdata["id"] . "' ");
                                                                 $disn = $dis->num_rows;
                                                                 if ($disn < 1) {
                                                                 ?>
                                                                      <td class="fw-bold">Not Available</td>
                                                                 <?php
                                                                 }else{
                                                                      $disd = $dis->fetch_assoc();  
                                                                      echo ($disd["discount_pre"])("%") ;
                                                                 }
                                                                 ?>
                                                            </tr>
                                                       <?php
                                                       }
                                                       ?>

                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>
                              </div>

                         </div>
                    </div>

               </div>
          </div>
     </div>
<?php
} else {
     echo "No product selected.";
}
?>