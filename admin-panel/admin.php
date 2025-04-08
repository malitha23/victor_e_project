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
    session_regenerate_id(true);
?>

    <!doctype html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>replace_title_admin</title>
      <link rel="shortcut icon" href="assets/img/logo-icon.ico" type="image/x-icon">

      <link rel="stylesheet" href="assets-admin/css/styles.min.css" />
    </head>

    <body>
      <!--  Body Wrapper -->
      <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php

        require "side.php";

        ?>
        <!--  Main wrapper -->
        <div class="body-wrapper">

          <?php
          require "nav.php";
          ?>

          <div class="container-fluid">
            <!-- Row 1 -->
            <div class="row">
              <div class="col-lg-8 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                      <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Sales Overview</h5>
                      </div>
                    </div>
                    <div id="chart"></div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="row">
                  <div class="col-lg-12">
                    <?php
                    $today = date("Y-m-d");
                    $thisMonth = date("m");
                    $thisYear = date("Y");

                    $a = $b = $c = $e = $f = 0;

                    // Fetch only successful transactions and join with invoice
                    $query = "
          SELECT invoice.*, transactions.transaction_time
          FROM invoice
          INNER JOIN transactions ON invoice.id = transactions.order_id
          WHERE transactions.transaction_status = 'Success'
        ";

                    $invoice_rs = Databases::search($query);
                    $invoice_num = $invoice_rs->num_rows;

                    for ($x = 0; $x < $invoice_num; $x++) {
                      $invoice_data = $invoice_rs->fetch_assoc();
                      $qty = (int)$invoice_data["qty"];
                      $price = (float)$invoice_data["price"];
                      $discount = (float)$invoice_data["discount"];
                      $delivery = (float)$invoice_data["delivery_fee"];
                      $total = ($price - $discount + $delivery) * $qty;

                      $f += $qty;

                      $pdate = explode(" ", $invoice_data["transaction_time"])[0];

                      if ($pdate == $today) {
                        $a += $total;
                        $c += $qty;
                      }

                      $splitMonth = explode("-", $pdate);
                      if ($splitMonth[0] == $thisYear && $splitMonth[1] == $thisMonth) {
                        $b += $total;
                        $e += $qty;
                      }
                    }
                    ?>

                    <div class="card overflow-hidden">
                      <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Daily Breakup</h5>
                        <div class="row align-items-center">
                          <div class="col-8">
                            <h4 class="fw-semibold mb-3">LKR <?php echo number_format($a, 2); ?></h4>
                            <div class="d-flex align-items-center mb-3">
                              <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrow-up-left text-success"></i>
                              </span>
                              <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                              <p class="fs-3 mb-0">Last Day</p>
                            </div>
                            <div class="d-flex align-items-center">
                              <div class="me-4">
                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2"><?php echo date("Y"); ?></span>
                              </div>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="d-flex justify-content-center">
                              <div id="breakup"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="row align-items-start">
                          <div class="col-8">
                            <h5 class="card-title mb-9 fw-semibold">Monthly Earnings</h5>
                            <h4 class="fw-semibold mb-3">LKR <?php echo number_format($b, 2); ?></h4>
                            <div class="d-flex align-items-center pb-1">
                              <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrow-down-right text-danger"></i>
                              </span>
                              <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                              <p class="fs-3 mb-0">Last Year</p>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="d-flex justify-content-end">
                              <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-currency-dollar fs-6"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="earning"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <!-- Recent Transactions Timeline -->
            <div class="row">

              <!-- Timeline: Recent Invoices -->
              <div class="col-lg-4 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">
                    <div class="mb-4">
                      <h5 class="card-title fw-semibold">Recent Invoices</h5>
                    </div>
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                      <?php
                      try {
                        $recent_rs = Databases::search("SELECT * FROM `invoice` ORDER BY `date_time` DESC LIMIT 5");
                        while ($recent = $recent_rs->fetch_assoc()) {
                          $time = explode(" ", $recent['date_time'])[1];
                      ?>
                          <li class="timeline-item d-flex position-relative overflow-hidden">
                            <div class="timeline-time text-dark flex-shrink-0 text-end"><?php echo $time; ?></div>
                            <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                              <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                              <span class="timeline-badge-border d-block flex-shrink-0"></span>
                            </div>
                            <div class="timeline-desc fs-3 text-dark mt-n1">
                              Payment received from <?php echo $recent['user_email']; ?> of
                              LKR <?php echo number_format($recent['price'] + $recent['delivery_fee'] - $recent['discount'], 2); ?>
                            </div>
                          </li>
                      <?php
                        }
                      } catch (Exception $e) {
                        echo "<li class='text-danger'>Error loading recent invoices: " . $e->getMessage() . "</li>";
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Table: Recent Transactions -->
              <div class="col-lg-8 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
                    <div class="table-responsive">
                      <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                          <tr>
                            <th>
                              <h6 class="fw-semibold mb-0">ID</h6>
                            </th>
                            <th>
                              <h6 class="fw-semibold mb-0">Reference</h6>
                            </th>
                            <th>
                              <h6 class="fw-semibold mb-0">Order ID</h6>
                            </th>
                            <th>
                              <h6 class="fw-semibold mb-0">Status</h6>
                            </th>
                            <th>
                              <h6 class="fw-semibold mb-0">Amount</h6>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          try {
                            $trans_rs = Databases::search("SELECT * FROM `transactions` ORDER BY `id` DESC LIMIT 10");
                            while ($trans = $trans_rs->fetch_assoc()) {
                          ?>
                              <tr>
                                <td>
                                  <h6 class="fw-semibold mb-0"><?php echo $trans["id"]; ?></h6>
                                </td>
                                <td>
                                  <h6 class="fw-semibold mb-1"><?php echo $trans["transaction_reference"]; ?></h6>
                                  <span class="fw-normal"><?php echo explode(" ", $trans["transaction_time"])[0]; ?></span>
                                </td>
                                <td>
                                  <p class="mb-0 fw-normal"><?php echo $trans["order_id"]; ?></p>
                                </td>
                                <td>
                                  <div class="d-flex align-items-center gap-2">
                                    <span class="badge 
                          <?php echo $trans["transaction_status"] == 'Success' ? 'bg-success' : 'bg-danger'; ?> 
                          rounded-3 fw-semibold">
                                      <?php echo $trans["transaction_status"]; ?>
                                    </span>
                                  </div>
                                </td>
                                <td>
                                  <span class="fw-semibold mb-0 text-black">LKR <?php echo number_format($trans["transaction_amount"], 2); ?></span>
                                </td>
                              </tr>
                          <?php
                            }
                          } catch (Exception $e) {
                            echo "<tr><td colspan='5' class='text-danger'>Error loading transactions: " . $e->getMessage() . "</td></tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>


            <!-- Footer -->
            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by
                <a href="https://codylanka.com" class="pe-1 text-primary text-decoration-underline">Cody Zea</a>
                Distributed by
                <a href="https://codyzea.com">Cody Zea</a>
              </p>
            </div>
          </div>

        </div>
      </div>

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
    session_destroy();
    header("Location: authentication-login.php");
    exit();
  }
} else {
  session_destroy();
  header("Location: authentication-login.php");
  exit();
}
?>