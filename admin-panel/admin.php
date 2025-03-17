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
      <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <?php

        require "side.php";

        ?>
        <!--  Main wrapper -->
        <div class="body-wrapper">

          <?php
          require "nav.php";
          ?>

          <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
              <div class="col-lg-8 d-flex align-items-strech">
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
                    $thismonth = date("m");
                    $thisyear = date("Y");

                    $a = "0";
                    $b = "0";
                    $c = "0";
                    $e = "0";
                    $f = "0";

                    $invoice_rs = Databases::search("SELECT * FROM `invoice`");
                    $invoice_num = $invoice_rs->num_rows;

                    for ($x = 0; $x < $invoice_num; $x++) {
                      $invoice_data = $invoice_rs->fetch_assoc();

                      $f = $f + $invoice_data["qty"];

                      $d = $invoice_data["date_time"];
                      $splitDate = explode(" ", $d); //separate date from time
                      $pdate = $splitDate[0]; //sold date

                      if ($pdate == $today) {
                        $a = $a + $invoice_data["total_amount"];
                        $c = $c + $invoice_data["qty"];
                      }

                      $splitMonth = explode("-", $pdate); //separate date as year,month & date
                      $pyear = $splitMonth[0]; //year
                      $pmonth = $splitMonth[1]; //month

                      if ($pyear == $thisyear) {
                        if ($pmonth == $thismonth) {
                          $b = $b + $invoice_data["total_amount"];
                          $e = $e + $invoice_data["qty"];
                        }
                      }
                    }

                    ?>
                    <!-- Yearly Breakup -->
                    <div class="card overflow-hidden">
                      <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Daily Breakup</h5>
                        <div class="row align-items-center">
                          <div class="col-8">
                            <h4 class="fw-semibold mb-3">LKR <?php echo number_format($a, 2) ?></h4>
                            <div class="d-flex align-items-center mb-3">
                              <span
                                class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrow-up-left text-success"></i>
                              </span>
                              <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                              <p class="fs-3 mb-0">Last Day</p>
                            </div>
                            <div class="d-flex align-items-center">
                              <div class="me-4">
                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">2023</span>
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
                    <!-- Monthly Earnings -->
                    <div class="card">
                      <div class="card-body">
                        <div class="row alig n-items-start">
                          <div class="col-8">
                            <h5 class="card-title mb-9 fw-semibold"> Monthly Earnings </h5>
                            <h4 class="fw-semibold mb-3">LKR <?php echo number_format($b, 2) ?></h4>
                            <div class="d-flex align-items-center pb-1">
                              <span
                                class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrow-down-right text-danger"></i>
                              </span>
                              <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                              <p class="fs-3 mb-0">last year</p>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="d-flex justify-content-end">
                              <div
                                class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
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
            <div class="row">
              <div class="col-lg-4 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">
                    <div class="mb-4">
                      <h5 class="card-title fw-semibold">Recent Transactions</h5>
                    </div>
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                      <!-- Example List Items for Transactions -->
                      <li class="timeline-item d-flex position-relative overflow-hidden">
                        <div class="timeline-time text-dark flex-shrink-0 text-end">10:30:15</div>
                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                          <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                          <span class="timeline-badge-border d-block flex-shrink-0"></span>
                        </div>
                        <div class="timeline-desc fs-3 text-dark mt-n1">
                          Payment received from user@example.com of LKR 200.00
                        </div>
                      </li>
                      <li class="timeline-item d-flex position-relative overflow-hidden">
                        <div class="timeline-time text-dark flex-shrink-0 text-end">09:15:10</div>
                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                          <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                          <span class="timeline-badge-border d-block flex-shrink-0"></span>
                        </div>
                        <div class="timeline-desc fs-3 text-dark mt-n1">
                          Payment received from anotheruser@example.com of LKR 150.00
                        </div>
                      </li>
                      <!-- Add more transaction examples as needed -->
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-lg-8 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
                    <div class="table-responsive">
                      <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                          <tr>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Id</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Invoice</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Name</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Status</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Budget</h6>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Example Table Rows -->
                          <tr>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">1</h6>
                            </td>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-1">INV12345</h6>
                              <span class="fw-normal">2025-01-30</span>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">user@example.com</p>
                            </td>
                            <td class="border-bottom-0">
                              <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary rounded-3 fw-semibold">Success</span>
                              </div>
                            </td>
                            <td class="border-bottom-0">
                              <span class="fw-semibold mb-0 text-black">LKR 200.00</span>
                            </td>
                          </tr>
                          <tr>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">2</h6>
                            </td>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-1">INV67890</h6>
                              <span class="fw-normal">2025-01-29</span>
                            </td>
                            <td class="border-bottom-0">
                              <p class="mb-0 fw-normal">anotheruser@example.com</p>
                            </td>
                            <td class="border-bottom-0">
                              <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary rounded-3 fw-semibold">Success</span>
                              </div>
                            </td>
                            <td class="border-bottom-0">
                              <span class="fw-semibold mb-0 text-black">LKR 150.00</span>
                            </td>
                          </tr>
                          <!-- Add more example rows as needed -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by <a href="codylanka.com"
                  class="pe-1 text-primary text-decoration-underline">Cody Zea</a> Distributed by <a
                  href="codyzea.com">Cody Zea</a></p>
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