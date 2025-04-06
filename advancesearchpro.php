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
          $c = Database::Search("SELECT * FROM `sub_category` WHERE `category_id`='" . $catagoryid . "'");
          while ($cdata = $c->fetch_assoc()) {
               $conditionsid[] = " `sub_category_id` = '" . $cdata["id"] . "' ";
          }
     } elseif ($groupid != 0) {
          $g = Database::Search("SELECT * FROM `category` WHERE `group_id`='" . $groupid . "'");
          while ($gdata = $g->fetch_assoc()) {
               $c = Database::Search("SELECT * FROM `sub_category` WHERE `category_id`='" . $gdata["id"] . "'");
               while ($cdata = $c->fetch_assoc()) {
                    $conditionsid[] = " `sub_category_id` = '" . $cdata["id"] . "' ";
               }
          }
     }
}

if (!empty($condition) && $condition != 0) {
     $conditions[] = " `condition_id` = '" . $condition . "' ";
}

if (!empty($searchtext)) {
     $conditions[] = " `title` LIKE '%$searchtext%'";
}

if ($maxprice || $minprice) {
     $mb = Database::Search("SELECT DISTINCT `product_id` FROM `batch` WHERE `selling_price` >= '$minprice' AND `selling_price` <= '$maxprice'");
     $productIds = [];
     while ($mbd = $mb->fetch_assoc()) {
          $productIds[] = (int)$mbd["product_id"];
     }
     if (count($productIds) == 0) exit();
     $conditions[] = " `id` IN (" . implode(",", $productIds) . ")";
}

if ($brandid[0] != 0) {
     foreach ($brandid as $bid) {
          $brandforquery[] = " `brand_id` = '" . $bid . "' ";
     }
}

if (count($conditions) > 0) {
     $query .= " WHERE " . implode(" AND ", $conditions);
}

if (count($conditionsid) > 0) {
     $query .= (count($conditions) > 0 ? " AND " : " WHERE ") . "(" . implode(" OR ", $conditionsid) . ")";
}

if (count($brandforquery) > 0) {
     $query .= (count($conditions) > 0 || count($conditionsid) > 0 ? " AND " : " WHERE ") . "(" . implode(" OR ", $brandforquery) . ")";
}

switch (strtolower($sort)) {
     case 'latest':
          $query .= " ORDER BY `date` DESC";
          break;

     case 'popular':
          $ivoice = Database::Search("SELECT `product_id`, COUNT(`product_id`) AS `total_sales` FROM `invoice` GROUP BY `product_id` ORDER BY `total_sales` DESC");
          $popularIds = [];
          while ($ivoicenumdata = $ivoice->fetch_assoc()) {
               $popularIds[] = (int)$ivoicenumdata["product_id"];
          }
          if (count($popularIds) > 0) {
               $query .= (strpos($query, 'WHERE') !== false ? " AND " : " WHERE ") . "`id` IN (" . implode(",", $popularIds) . ")";
          }
          break;

     case 'trending':
          $query .= " ORDER BY RAND()";
          break;

     case 'matches':
          $Bsort = Database::Search("SELECT * FROM `batch` ORDER BY `selling_price` ASC");
          $matchIds = [];
          while ($Bsortdata = $Bsort->fetch_assoc()) {
               $matchIds[] = (int)$Bsortdata["product_id"];
          }
          if (count($matchIds) > 0) {
               $query .= (strpos($query, 'WHERE') !== false ? " AND " : " WHERE ") . "`id` IN (" . implode(",", $matchIds) . ")";
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
          if ($product_num == 0) {
               echo "no product available";
          }
          if (!empty($condition)) {
               if ($condition  == 0) {
                    $conbu = 0;
               } else {
                    $conbu = $condition;
               }
          } else {
               $conbu = 0;
          }
          for ($a = 0; $a < $product_num; $a++) {
               $dataap = $product_rs->fetch_assoc();
               $dataap["id"];
               // Fetch limited product data for current page
               $batch = Database::Search("SELECT * FROM `batch` WHERE `product_id`='" . $dataap["id"] . "' LIMIT $start, $itemsPerPage");
               $batchnum = $batch->num_rows;
               for ($i = 0; $i <  $batchnum; $i++) {
                    $batchdata = $batch->fetch_assoc();
                    if ($discountstatus == true) {
                         $disc = Database::Search("SELECT * FROM `discount_date_range_has_product` WHERE `batch_id`='" . $batchdata["id"] . "' ");
                         $discnum = $disc->num_rows;
                         if ($discnum == 1) {
                              $disdetails = $disc->fetch_assoc();
                              $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "' ");
                              $productdata = $product->fetch_assoc();
                              if ($conbu != 0) {
                                   if ($productdata["condition_id"] == $condition) {
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
                                                            <span class="text-dark fw-bold fs-5">normal price:
                                                                 Rs <?php echo $batchdata["selling_price"]; ?>
                                                                 <span class="text-muted fw-normal fs-6 ms-1">Quantity / <?php echo $batchdata["batch_qty"]; ?> Available</span>
                                                            </span>
                                                            <span class="sellp-dism text-dark fw-bold fs-5">
                                                                 <?php
                                                                 $dispre = $disdetails["discount_pre"];
                                                                 $sellprice = $batchdata["selling_price"] - ($batchdata["selling_price"] * $dispre / 100); ?>
                                                                 Rs <?php echo  $sellprice; ?>
                                                            </span>
                                                            <span class="dismp"><?php echo $disdetails["discount_pre"]; ?>% discount</span>
                                                            <span class="dismq"><?php echo  $disdetails["qty"]; ?> Available for discount</span>
                                                       </div>

                                                       <a href="cart.html" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium">
                                                            Add To Cart <i class="ph ph-shopping-cart"></i>
                                                       </a>
                                                  </div>
                                             </div>
                                        </div>
                                   <?php
                                   } else {
                                        $cm = Database::Search("SELECT * FROM `condition` WHERE `id`='" . $productdata["condition_id"] . "'  ");
                                        $cmd = $cm->fetch_assoc();
                                        echo $productdata["title"] . "condition :" . $cmd["name"] . "There is no item for this condition.";
                                   }
                              } else {
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
                                                       <span class="text-dark fw-bold fs-5">normal price:
                                                            Rs <?php echo $batchdata["selling_price"]; ?>
                                                            <span class="text-muted fw-normal fs-6 ms-1">Quantity / <?php echo $batchdata["batch_qty"]; ?> Available</span>
                                                       </span>
                                                       <span class="sellp-dism text-dark fw-bold fs-5">
                                                            <?php
                                                            $dispre = $disdetails["discount_pre"];
                                                            $sellprice = $batchdata["selling_price"] - ($batchdata["selling_price"] * $dispre / 100); ?>
                                                            Rs <?php echo  $sellprice; ?>
                                                       </span>
                                                       <span class="dismp"><?php echo $disdetails["discount_pre"]; ?>% discount</span>
                                                       <span class="dismq"><?php echo  $disdetails["qty"]; ?> Available for discount</span>
                                                  </div>

                                                  <a href="cart.html" class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium">
                                                       Add To Cart <i class="ph ph-shopping-cart"></i>
                                                  </a>
                                             </div>
                                        </div>
                                   </div>
                              <?php
                              }
                              ?>
                              <style>
                                   /* Animation Keyframes */
                                   @keyframes fadeInScale {
                                        0% {
                                             opacity: 0;
                                             transform: scale(0.9);
                                        }

                                        100% {
                                             opacity: 1;
                                             transform: scale(1);
                                        }
                                   }

                                   @keyframes glowText {

                                        0%,
                                        100% {
                                             text-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
                                        }

                                        50% {
                                             text-shadow: 0 0 15px rgba(0, 153, 255, 0.7);
                                        }
                                   }

                                   @keyframes pulseDiscount {

                                        0%,
                                        100% {
                                             transform: scale(1);
                                        }

                                        50% {
                                             transform: scale(1.05);
                                        }
                                   }

                                   /* Applying Animations */
                                   .sellp-dism {
                                        animation: fadeInScale 0.6s ease-in-out, glowText 3s infinite;
                                        display: block;
                                        margin-bottom: 6px;
                                   }

                                   .dismp {
                                        animation: pulseDiscount 1.5s infinite;
                                        color: #28a745;
                                        font-weight: bold;
                                        display: block;
                                        margin-bottom: 4px;
                                   }

                                   .dismq {
                                        animation: fadeInScale 0.8s ease-in-out;
                                        color: #007bff;
                                        display: block;
                                   }

                                   /* Smooth Transition Effect */
                                   .sellp-dism,
                                   .dismp,
                                   .dismq {
                                        transition: all 0.3s ease;
                                   }
                              </style>

                              <?php
                         } else {
                         }
                    } else {
                         $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batchdata["product_id"] . "' ");
                         $productdata = $product->fetch_assoc();
                         $picture = Database::Search("SELECT * FROM `picture` WHERE `product_id`='" . $productdata["id"] . "' AND `name`='Image 1'");
                         $picturenum = $picture->num_rows;

                         if ($conbu != 0) {
                              if ($conbu == $productdata["condition_id"]) {
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
                              } else {
                                   $cm = Database::Search("SELECT * FROM `condition` WHERE `id`='" . $productdata["condition_id"] . "'  ");
                                   $cmd = $cm->fetch_assoc();
                                   echo $productdata["title"] . "condition :" . $cmd["name"] . "There is no item for this condition.";
                              }
                         } else {
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
                    }
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
<style>
     /* Product Card Styles */
     .product-card {
          background-color: white;
          border-radius: 16px;
          transition: all 0.3s ease;
          overflow: hidden;
     }

     .product-card:hover {
          border-color: #007bff;
          /* Highlighted border color */
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
     }

     .product-card__thumb {
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: #f8f9fa;
          padding: 10px;
          height: 200px;
     }

     .product-card__thumb img {
          max-height: 100%;
          max-width: 100%;
          border-radius: 8px;
          transition: transform 0.3s;
     }

     .product-card__thumb:hover img {
          transform: scale(1.05);
     }

     .product-card__content h6 {
          font-size: 1.1rem;
          font-weight: 600;
          margin-bottom: 0.5rem;
     }

     .product-card__content .text-line-2 {
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
     }

     .product-card__price {
          font-size: 1rem;
          color: #212529;
     }

     .product-card__price span {
          display: block;
     }

     .product-card__cart {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          padding: 10px 24px;
          background-color: #f8f9fa;
          color: #007bff;
          border: none;
          cursor: pointer;
          border-radius: 8px;
          transition: all 0.3s ease;
          margin-top: 1rem;
     }

     .product-card__cart:hover {
          background-color: #007bff;
          color: white;
     }

     /* Responsive Styles */
     @media (max-width: 768px) {
          .product-card__thumb {
               height: 150px;
          }
     }

     @media (max-width: 576px) {
          .product-card__thumb {
               height: 120px;
          }
     }
</style>