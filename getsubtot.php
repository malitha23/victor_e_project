<?php
session_start();
include "connection.php";
if (isset($_SESSION["user_vec"])) {
     $user_row = Database::Search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user_vec"]["email"] . "' ");
     $user_data = $user_row->fetch_assoc();
} else {
     $user_data = [];
}
?>
<div id="sutotive" class="cart-sidebar border border-gray-100 rounded-8 px-24 py-40">
     <h6 class="text-xl mb-32">Cart Totals</h6>
     <?php
     $deliveryfee = 0.0;
     if (isset($_SESSION["user_vec"])) {
          $u = Database::Search("SELECT * FROM `user` WHERE `email`='" . $user_data["email"] . "' ");
          $un = $u->num_rows;
          if ($un == 1) {
               $ud = $u->fetch_assoc();
               if (!empty($ud["adress_id"])) {
                    $ad = Database::Search("SELECT * FROM `address` WHERE `address_id` ='" . $ud["adress_id"] . "'");
                    $add = $ad->fetch_assoc();
                    $df = Database::Search("SELECT * FROM `delivery_fee` WHERE `city_city_id`='" . $add["city_city_id"] . "' ");
                    $dfn = $df->num_rows;
                    if ($dfn == 1) {
                         $dfd = $df->fetch_assoc();
                         $deliveryfee = $dfd["fee"];
                    } else {
                         $deliveryfee = 00.00;
                    }
               } else {
                    $deliveryfee = 00.00;
               }
          }
     }
     #
     $cartdatafull = [];

     if (!isset($_SESSION["user_vec"])) {
          // Use session cart if database cart is empty
          $cartdatafull = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
          $cartnum = count($cartdatafull);
     } else {

          $cart = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_data["email"] . "' ");
          $cartnum = $cart->num_rows;
           $cartnum;
          // Fetch all database cart items into an array
          if ($cartnum > 0) {
               while ($row = $cart->fetch_assoc()) {
                    $cartdatafull[] = $row;
               }
          } else {
               $cartdatafull = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
               $cartnum = count($cartdatafull);
          }
     }

     $weigdeliveryfee = 0;
     if ($cartnum > 0) {
          $price_tot = 0;
          for ($i = 0; $i < $cartnum; $i++) {
               $cartdata = $cartdatafull[$i];
               $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $cartdata["batch_id"] . "' ");
               $batch_data = $batch->fetch_assoc();
               $product = Database::Search("SELECT * FROM `product` WHERE `id`='" . $batch_data["product_id"] . "' ");
               $product_data = $product->fetch_assoc();
               if ($product_data["weight"] > 0) {
                    $product_weight = $product_data["weight"];
                    $dw = Database::Search("SELECT * FROM `weight`");
                    $dwn = $dw->num_rows;
                    for ($i = 0; $i < $dwn; $i++) {
                         $dwd = $dw->fetch_assoc();
                         if ($dwd["weight"] == $product_weight) {
                              $final_product_weight = $dwd["weight"];
                              $dfw = Database::Search("SELECT * FROM `delivery_fee_for_weight` WHERE `weight_id`='" . $dwd["id"] . "' ");
                              $dfwn = $dfw->num_rows;
                              if ($dfwn == 1) {
                                   $dfwd = $dfw->fetch_assoc();
                                   $weigdeliveryfee = $dfwd["fee"];
                              } else {
                                   $weigdeliveryfee = 0;
                              }
                         } else {
                              $weigdeliveryfee = 0;
                         }
                    }
               } else {
                    $weigdeliveryfee = 0;
               }
          }
     } else {
          $weigdeliveryfee = 0;
     }
     #
     ?>
     <?php

     $cartdatafull = [];

     if (!isset($_SESSION["user_vec"])) {
          // Use session cart if database cart is empty
          $cartdatafull = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
          $cartnum = count($cartdatafull);
     } else {
          $cart = Database::Search("SELECT * FROM `cart` WHERE `user_email`='" . $user_data["email"] . "' ");
          $cartnum = $cart->num_rows;
          // Fetch all database cart items into an array
          if ($cartnum > 0) {
               while ($row = $cart->fetch_assoc()) {
                    $cartdatafull[] = $row;
               }
          } else {
               $cartdatafull = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
               $cartnum = count($cartdatafull);
          }
     }

     if ($cartnum > 0) {
          $price_tot = 0;
          for ($i = 0; $i < $cartnum; $i++) {
               $cartdata = $cartdatafull[$i];
               $batch = Database::Search("SELECT * FROM `batch` WHERE `id`='" . $cartdata["batch_id"] . "' ");
               $batch_data = $batch->fetch_assoc();
               $price = $batch_data["selling_price"];
               $discountpre = $cartdata["discount"];
               $discountAmount = ($price * $discountpre) / 100;
               $finalPricePerItem = $price - $discountAmount;
               $price_tot = ($finalPricePerItem * $cartdata["qty"]) + $price_tot;
          }
     } else {
          $price_tot = 0;
     }
     ?>
     <div class="bg-color-three rounded-8 p-24">
          <div class="mb-32 flex-between gap-8">
               <span class="text-gray-900 font-heading-two">Subtotal</span>
               <span class="text-gray-900 fw-semibold"><?php echo $price_tot + $weigdeliveryfee; ?></span>
          </div>
          <!-- <div class="flex-between mb-3 text-center">
                                    <a href="profile.php"
                                        class=" font-heading-two text-success text-decoration-underline">Change Delivery
                                        Address</a>
                                </div> -->
          <div class="mb-32 flex-between gap-8">
               <span class="text-gray-900 font-heading-two">Delivery Fee</span>
               <span class="text-gray-900 fw-semibold"><?php echo $deliveryfee ?></span>
          </div>
          <div class="mb-0 flex-between gap-8">
               <span class="text-gray-900 font-heading-two">Tax</span>
               <span class="text-gray-900 fw-semibold">00.00</span>
          </div>
     </div>
     <div class="bg-color-three rounded-8 p-24 mt-24">
          <div class="flex-between gap-8">
               <span class="text-gray-900 text-xl fw-semibold">Total</span>
               <span class="text-gray-900 text-xl fw-semibold"><?php echo $price_tot + $deliveryfee + $weigdeliveryfee; ?></span>
          </div>
     </div>
     <a href="guest-checkout.php?total_price=<?php echo urlencode(base64_encode($price_tot)); ?>&weigdeliveryfee=<?php echo urlencode(base64_encode($weigdeliveryfee)); ?>" class="btn btn-main mt-40 py-18 w-100 fw-bold h6 rounded-8">Checkout</a>
</div>