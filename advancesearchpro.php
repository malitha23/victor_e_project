<?php
require_once 'connection.php';

$searchtext = $_POST['searchtext'] ?? '';
$minprice = $_POST['minprice'] ?? '';
$maxprice = $_POST['maxprice'] ?? '';
$condition = $_POST['condition'] ?? '';
$brandidlength = $_POST['brandidlength'] ?? 0;
$brandid = [];
if ($brandidlength == 0) {
     $brandid[] = 0;
} else {
     for ($i = 0; $i < $brandidlength; $i++) {
          $brandid[] = $_POST['brand' . $i] ?? '';
     }
}
$groupid = $_POST['groupid'] ?? '';
$catagoryid = $_POST['catagoryid'] ?? '';
$subcatagoryid = $_POST['subcatagoryid'] ?? '';
$sort = $_POST['sort'] ?? 'latest';
$discountstatus = $_POST['discount'] ?? 0;


$itemsPerPage = 20;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($currentPage - 1) * $itemsPerPage;

$query = "SELECT * FROM `product`";

$conditions = [];
$conditionsid = [];
$brandforquery = [];
if ($subcatagoryid != 0) {
     $conditions[] = " `sub_category_id` = '" . $subcatagoryid . "' ";
} else {
     if ($catagoryid != 0) {
          $c = Database::Search("SELECT * FROM `sub_category` WHERE `category_id`='" . $catagoryid . "'  ");
          $cnum = $c->num_rows;
          for ($i = 0; $i < $cnum; $i++) {
               $cdata = $c->fetch_assoc();
               $conditionsid[] = " `sub_category_id` = '" . $cdata["id"] . "' ";
          }
     } else {
          if ($groupid != 0) {
               $g = Database::Search("SELECT * FROM `category` WHERE `group_id`='" . $groupid . "' ");
               $gnum = $g->num_rows;
               for ($i = 0; $i < $gnum; $i++) {
                    $gdata = $g->fetch_assoc();
                    $c = Database::Search("SELECT * FROM `sub_category` WHERE `category_id`='" . $gdata["id"] . "'  ");
                    $cnum = $c->num_rows;
                    for ($i = 0; $i < $cnum; $i++) {
                         $cdata = $c->fetch_assoc();
                         $conditionsid[] = " `sub_category_id` = '" . $cdata["id"] . "' ";
                    }
               }
          }
     }
}
if (!empty($condition)) {
     if ($condition != 0) {
          $conditions[] = " `condition_id` = '" . $condition . "' ";
     }
}

if (!empty($searchtext)) {
     $conditions[] = " `title` LIKE '%$searchtext%'";
}
if ($maxprice != 0) {
     $mb = Database::Search("SELECT * FROM `batch` WHERE `selling_price` <= '" . $maxprice . "' ");
     $mbn = $mb->num_rows;
     for ($i = 0; $i <  $mbn; $i++) {
          $mbd = $mb->fetch_assoc();
          $conditions[] = " `id` = '" . $mbd["product_id"] . "' ";
     }
}
if ($minprice != 0) {
     $mb = Database::Search("SELECT * FROM `batch` WHERE `selling_price` >= '" . $minprice . "' ");
     $mbn = $mb->num_rows;
     for ($i = 0; $i <  $mbn; $i++) {
          $mbd = $mb->fetch_assoc();
          $conditions[] = " `id` = '" . $mbd["product_id"] . "' ";
     }
}
if ($brandid[0] != 0) {
     for ($i = 0; $i < $brandidlength; $i++) {
          $brandforquery[] = " `brand_id` = '" . $brandid[$i] . "' ";
     }
}

if (count($conditions) > 0) {
     $query .= " WHERE " . implode(" AND ", $conditions);
}

if (count($conditionsid) > 0) {
     $query .= (count($conditions) > 0 ? " AND " : " WHERE ") . implode(" OR ", $conditionsid);
}

if (count($brandforquery) > 0) {
     $query .= (count($conditions) > 0 || count($conditionsid) > 0 ? " AND " : " WHERE ") . implode(" OR ", $brandforquery);
}

     switch ($sort) {
          case 'Latest':
               $query .= " ORDER BY `date` DESC";
               break;

          case 'Popular':
               $ivoice = Database::Search("SELECT 
               `product_id`,
               COUNT(`product_id`) AS `total_sales`
           FROM 
               victore.invoice
           GROUP BY 
               `product_id`
           ORDER BY 
               `total_sales` DESC;
           ");
               $ivoicenum = $ivoice->num_rows;
               for ($i = 0; $i < $ivoicenum; $i++) {
                    $productIds = [];
                    while ($ivoicenumdata = $ivoice->fetch_assoc()) {
                         $productIds[] = " `id` = '" . $ivoicenumdata["product_id"] . "' ";
                    }
                    if (count($productIds) > 0) {
                         $query .= (count($conditions) > 0 || count($conditionsid) || count($brandforquery)  > 0 ? " AND " : " WHERE ") . implode(" AND ", $productIds);
                    }
               }
               break;

          case 'Trending':
               $query .= " ORDER BY RAND()";
               break;

          case 'Matches':
               $Bsort = Database::Search("SELECT * FROM `batch` ORDER BY `selling_price` ASC");
               $Bsortnum = $Bsort->num_rows;
               if ($Bsortnum > 0) {
                    $productIds = [];
                    while ($Bsortdata = $Bsort->fetch_assoc()) {
                         $productIds[] = " `id` = '" . $Bsortdata["product_id"] . "' ";
                    }
                    if (count($productIds) > 0) {
                         $query .= (count($conditions) > 0 || count($conditionsid) || count($brandforquery)  > 0 ? " AND " : " WHERE ") . implode(" OR ", $productIds);
                    }
               }
               break;
     }


$query .= " LIMIT $itemsPerPage OFFSET $start";
$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;
?>
<div class="list-grid-wrapper" id="shopveiw">
     <div class="row">
          <?php
          // Define items per page
          $itemsPerPage = 20;

          // Get the current page from URL (default to 1 if not set)
          $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

          // Calculate the starting point
          $start = ($currentPage - 1) * $itemsPerPage;

          // Get total number of products
          $totalBatch = Database::Search("SELECT COUNT(*) as total FROM `batch`");
          $totalBatchCount = $totalBatch->fetch_assoc()["total"];

          // Calculate total pages
          $totalPages = ceil($totalBatchCount / $itemsPerPage);

          for ($a = 0; $a < $product_num; $a++) {
               $dataap = $product_rs->fetch_assoc();
               $dataap["id"];
               // Fetch limited product data for current page
               $batch = Database::Search("SELECT * FROM `batch` WHERE `product_id`='" . $dataap["id"] . "' LIMIT $start, $itemsPerPage");
               $batchnum = $batch->num_rows;
               for ($i = 0; $i <  $batchnum; $i++) {
                    $batchdata = $batch->fetch_assoc();
                    $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "' ");
                    $productdata = $product->fetch_assoc();
                    $picture = Database::Search("SELECT * FROM `picture` WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 1'");
                    $picturenum = $picture->num_rows;

                    if ($picturenum == 1) {
                         $picturedata = $picture->fetch_assoc();
                         $picturepath = $picturedata["path"];
                    } else {
                         $picturepath = 'assets/images/thumbs/product-two-img2.png';
                    }
          ?>
                    <div class="col-6 col-md-4">
                         <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                              <a href="product-details.php" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                                   <img src="admin-panel/<?php echo $picturepath; ?>" alt="" class="w-auto max-w-unset">
                              </a>
                              <div class="product-card__content mt-16">
                                   <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                        <a href="product-details.php" class="link text-line-2"><?php echo $productdata["title"]; ?></a>
                                   </h6>
                                   <div class="mt-8">
                                        <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                             <div class="progress-bar bg-main-two-600 rounded-pill" style="width: 35%"></div>
                                        </div>
                                        <?php
                                        $invoice = Database::Search("SELECT * FROM `invoice` WHERE `product_id`='" . $productdata["id"] . "'");
                                        $invoicenum = $invoice->num_rows;
                                        ?>
                                        <span class="text-gray-900 text-xs fw-medium mt-8">Sold: <?php echo $invoicenum; ?></span>
                                   </div>

                                   <div class="product-card__price mt-3 mb-4 d-flex flex-column gap-1">
                                        <span class="text-secondary text-decoration-line-through fw-semibold fs-6">Rs <?php echo $batchdata["selling_price"] + 10; ?></span>
                                        <span class="text-dark fw-bold fs-5">
                                             Rs <?php echo $batchdata["selling_price"]; ?>
                                             <span class="text-muted fw-normal fs-6 ms-1">Quantity / <?php echo $batchdata["batch_qty"]; ?> Available</span>
                                        </span>
                                   </div>

                                   <a href="cart.html" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium">
                                        Add To Cart <i class="ph ph-shopping-cart"></i>
                                   </a>
                              </div>
                         </div>
                    </div>
               <?php
               }
               if ($batchnum == 0) {
               ?>
                    <div>
                    </div>
          <?php
               };
          }
          ?>
     </div>
</div>