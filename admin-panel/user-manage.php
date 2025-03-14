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
?>

    <!doctype html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>replace_title_admin</title>
      <link rel="shortcut icon" href="assets/img/logo-icon.ico" type="image/x-icon">
      <link rel="stylesheet" href="assets-admin/css/style.css" />
      <link rel="stylesheet" href="assets-admin/css/styles.min.css" />
    </head>

    <body>
      <!-- Body Wrapper -->
      <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar -->
        <?php require "side.php"; ?>

        <!-- Main wrapper -->
        <div class="body-wrapper">
          <!-- Header Start -->
          <?php require "nav.php"; ?>
          <!-- Header End -->

          <div class="container-fluid">
            <div class="row px-3">
              <div class="col-12 py-4 mb-3 border shadow">
                <div class="row p-2 d-flex flex-row justify-content-end">
                  <div class="col-12 col-lg-6">
                    <form action="">
                      <div class="input-group rounded border rounded-5">
                        <input type="search" class="form-control border-0 border-end" placeholder="Search by email" aria-label="Search" id="ukey" aria-describedby="search-addon" />
                        <span class="input-group-text btn border-0" onclick="SearchUser();" id="search-addon">
                          <i class="fas fa-search"></i>
                        </span>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="row" id="userarea">
                  <section>
                    <div class="gradient-custom-1 h-100">
                      <div class="mask d-flex align-items-center h-100">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-12">
                              <div class="table-responsive bg-white">
                                <table class="table mb-0">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">FULL NAME</th>
                                      <th scope="col">EMAIL</th>
                                      <th scope="col">DETAILS</th>
                                      <th scope="col">STATUS</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $user = Databases::Search("SELECT * FROM `user`");
                                    $usernum = $user->num_rows;
                                    for ($i = 0; $i < $usernum; $i++) {
                                      $userdata = $user->fetch_assoc();
                                    ?>
                                      <tr>
                                        <td><?php echo $i + 1; ?></td>
                                        <td><?php echo $userdata["fname"] . " " . $userdata["lname"]; ?></td>
                                        <td><?php echo $userdata["email"]; ?></td>
                                        <td>
                                          <a class="tex-b log-link fw-bold" data-bs-toggle="modal" onclick="callPHPFunction('<?php echo $userdata["email"]; ?>')">SHOW</a>
                                        </td>
                                        <td>
                                          <?php
                                          if ($userdata["status"] == 0) {
                                          ?>
                                            <a class="btn ub-btn p-1" onclick="confirmUNBlock('<?php echo $userdata['email']; ?>')">UNBLOCK</a>
                                          <?php
                                          } else {
                                          ?>
                                            <a class="btn ub-btn p-1" onclick="confirmBlock('<?php echo $userdata['email']; ?>')">BLOCK</a>
                                          <?php
                                          }
                                          ?>
                                        </td>
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
                  </section>
                </div>
                <div id="userDetailsModal"></div>
                <!-- !-->
                <script>
                  
                </script>
                <script>
                  
                </script>
                <!-- !-->
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal for Block/Unblock -->
      <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title fs-4 fw-bold" id="exampleModalLabel">
                Warning&nbsp;&nbsp;<i class="fa fa-exclamation" aria-hidden="true"></i>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span id="block_fname_lname">Are you sure you want to block/unblock this user?</span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger">Sure</button>
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
      <!-- Include SweetAlert2 Library -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- overlay -->
      <script src="sahan.js"></script>
      <div class="blueOverlay d-none">
        <div class="d-flex justify-content-center align-items-center h-100">
          <div class="text-center text-white">
            <div class="spinner-border text-light" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Please wait...</p>
          </div>
        </div>
      </div>

    </body>


    </html>

<?php
  } else {
    session_destroy();
    header("Location: ../index.php");
    exit();
  }
} else {
  session_destroy();
  header("Location: ../index.php");
  exit();
}
?>