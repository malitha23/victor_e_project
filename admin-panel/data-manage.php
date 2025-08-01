<?php
session_start();

if (isset($_SESSION["a"])) {
  include "db.php";
  // $uemail = $_SESSION["a"]["username"];
  // $query = "SELECT * FROM `admin` WHERE `username` = ?";
  // $params = [$uemail];
  // $types = "s";
  // $u_detail = Databases::Search($query, $params, $types);
  // if ($u_detail->num_rows == 1) {
  if (1 == 1) {
?>

    <!doctype html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Vicstore Admin Panel – Manage Your Store with Ease</title>
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
            <div class="row px-3 d-flex justify-content-center">

              <div class="col-12 text-center mb-3">
                <div class="mb-1">
                  <span class="h4 mb-9 fw-semibold">Manage Data&nbsp;&nbsp;<i class="fa fa-database" aria-hidden="true"></i></span>
                </div>
                <div>
                  <span class="mb-9 text-dark-emphasis">You can delete data here</span>
                </div>
              </div>

              <style>
                .table-row-selectable {
                  cursor: pointer;
                  transition: background-color 0.2s ease-in-out;
                }

                .table-row-selectable:hover {
                  background-color: #f0f8ff;
                  /* Light blue on hover */
                }
              </style>

              <!-- GROUPS SECTION -->
              <div class="col-auto py-4 mt-4 mb-3 border shadow">
                <div class="row">
                  <section>
                    <div class="gradient-custom-1 h-100">
                      <div class="mask d-flex align-items-center h-100">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-12 text-center fw-bolder h4 mb-3">GROUPS</div>

                            <div class="col-12 d-flex justify-content-center">
                              <div class="table-responsive bg-white border" style="max-height: 500px; overflow-y: auto;">
                                <table class="table mb-0 table-bordered">
                                  <thead>
                                    <tr style="background-color: azure;">
                                      <th></th>
                                      <th>NAME</th>
                                      <th>ROOT</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $gruop = Databases::Search("SELECT * FROM `group`");
                                    $gruopn = $gruop->num_rows;
                                    for ($i = 1; $i <=  $gruopn; $i++) {
                                      $gruopd = $gruop->fetch_assoc();
                                    ?>
                                      <tr class="table-row-selectable">
                                        <td><input id="grcheck<?php echo $i ?>" type="checkbox" class="row-checkbox"></td>
                                        <td id="groupname<?php echo $i ?>" class="px-md-3 px-lg-5"><?php echo $gruopd["group_name"] ?></td>
                                        <td class="px-md-3 px-lg-5"><?php echo $gruopd["group_name"] ?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                              <button onclick="deletegroup(<?php echo $gruopn ?>);" class="btn rounded-1 fw-bold x col-md-2">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> DELETE
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
              <script>
                function deletegroup(total) {
                  const selectedGroups = [];

                  for (let i = 1; i <= total; i++) {
                    const checkbox = document.getElementById(`grcheck${i}`);
                    if (checkbox && checkbox.checked) {
                      const groupName = document.getElementById(`groupname${i}`).innerText.trim();
                      selectedGroups.push(groupName);
                    }
                  }

                  if (selectedGroups.length === 0) {
                    alert("Please select at least one group to delete.");
                    return;
                  }

                  if (!confirm("Are you sure you want to delete the selected groups?")) {
                    return;
                  }

                  const formData = new FormData();
                  formData.append("groups", JSON.stringify(selectedGroups));

                  fetch("process/groupdelete.php", {
                      method: "POST",
                      body: formData
                    })
                    .then(res => res.text())
                    .then(data => {
                      alert(data);
                      location.reload(); // Refresh page after deletion
                    })
                    .catch(err => {
                      console.error(err);
                      alert("An error occurred while deleting groups.");
                    });
                }
              </script>

              <!-- CATEGORIES SECTION -->
              <div class="col-auto py-4 mt-4 mb-3 border shadow">
                <div class="row">
                  <section>
                    <div class="gradient-custom-1 h-100">
                      <div class="mask d-flex align-items-center h-100">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-12 text-center fw-bolder h4 mb-3">CATEGORIES</div>

                            <div class="col-12 d-flex justify-content-center">
                              <div class="table-responsive bg-white border" style="max-height: 500px; overflow-y: auto;">
                                <table class="table mb-0 table-bordered">
                                  <thead>
                                    <tr style="background-color: azure;">
                                      <th></th>
                                      <th>NAME</th>
                                      <th>ROOT</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $scat = Databases::search("SELECT * FROM `sub_category`");
                                    $scatnum = $scat->num_rows;
                                    for ($i = 1; $i <= $scatnum; $i++) {
                                      $scatdata = $scat->fetch_assoc();
                                      $mcat = Databases::Search("SELECT * FROM `category` WHERE `id`='" . $scatdata["category_id"] . "' ");
                                      $mcatd = $mcat->fetch_assoc();
                                    ?>
                                      <tr class="table-row-selectable">
                                        <td><input id="catceck<?php echo $i ?>" type="checkbox" class="row-checkbox"></td>
                                        <td id="subcat<?php echo $i ?>" class="px-md-3 px-lg-5"><?php echo  $scatdata["name"] ?></td>
                                        <td id="cat<?php echo $i ?>" class="px-md-3 px-lg-5"><?php echo $mcatd["name"] ?> > <?php echo  $scatdata["name"] ?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                              <button onclick="deletecat(<?php echo  $scatnum; ?>);" class="btn rounded-1 fw-bold x col-md-2">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> DELETE
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
              </div>

              <script>
                function deletecat(num) {
                  let selectedSubCats = [];

                  for (let i = 1; i <= num; i++) {
                    let checkbox = document.getElementById("catceck" + i);
                    if (checkbox && checkbox.checked) {
                      let subcat = document.getElementById("subcat" + i).textContent.trim();
                      selectedSubCats.push(subcat);
                    }
                  }

                  if (selectedSubCats.length === 0) {
                    alert("Please select at least one sub-category to delete.");
                    return;
                  }

                  const formData = new FormData();
                  formData.append("subcats", JSON.stringify(selectedSubCats));

                  const xhr = new XMLHttpRequest();
                  xhr.open("POST", "process/deletecat.php", true);
                  xhr.onload = function() {
                    if (xhr.status === 200) {
                      alert(xhr.responseText);
                      location.reload();
                    } else {
                      alert("Error deleting sub-categories.");
                    }
                  };
                  xhr.send(formData);
                }
              </script>

              <!-- SUB CATEGORIES SECTION -->
              <div class="col-auto py-4 mt-4 mb-3 border shadow">
                <div class="row">
                  <section>
                    <div class="gradient-custom-1 h-100">
                      <div class="mask d-flex align-items-center h-100">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-12 text-center fw-bolder h4 mb-3">SUB CATEGORIES</div>

                            <div class="col-12 d-flex justify-content-center">
                              <div class="table-responsive bg-white border" style="max-height: 500px; overflow-y: auto;">
                                <table class="table mb-0 table-bordered">
                                  <thead>
                                    <tr style="background-color: azure;">
                                      <th></th>
                                      <th>NAME</th>
                                      <th>ROOT</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $scat = Databases::search("SELECT * FROM `sub_category`");
                                    $scatnum = $scat->num_rows;
                                    for ($i = 1; $i <= $scatnum; $i++) {
                                      $scatdata = $scat->fetch_assoc();
                                      $mcat = Databases::Search("SELECT * FROM `category` WHERE `id`='" . $scatdata["category_id"] . "' ");
                                      $mcatd = $mcat->fetch_assoc();
                                    ?>
                                      <tr class="table-row-selectable">
                                        <td><input type="checkbox" id="catcheck<?php echo $i; ?>" class="row-checkbox"></td>
                                        <td id="subcat<?php echo $i; ?>" class="px-md-3 px-lg-5"><?php echo $scatdata["name"] ?></td>
                                        <td class="px-md-3 px-lg-5"><?php echo $mcatd["name"] ?> > <?php echo $scatdata["name"] ?> > Sub Category</td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                              <button onclick="deletecat(<?php echo  $scatnum; ?>);" class="btn rounded-1 fw-bold x col-md-2">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> DELETE
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
              </div>

              <script>
                function deletecat(num) {
                  let selectedSubCats = [];

                  for (let i = 1; i <= num; i++) {
                    let checkbox = document.getElementById("catcheck" + i);
                    if (checkbox && checkbox.checked) {
                      let subcat = document.getElementById("subcat" + i).textContent.trim();
                      selectedSubCats.push(subcat);
                    }
                  }

                  if (selectedSubCats.length === 0) {
                    alert("Please select at least one sub-category to delete.");
                    return;
                  }

                  const formData = new FormData();
                  formData.append("subcats", JSON.stringify(selectedSubCats));

                  const xhr = new XMLHttpRequest();
                  xhr.open("POST", "process/deletesubcat.php", true);
                  xhr.onload = function() {
                    if (xhr.status === 200) {
                      alert(xhr.responseText);
                      location.reload();
                    } else {
                      alert("Error deleting sub-categories.");
                    }
                  };
                  xhr.send(formData);
                }
              </script>


              <!-- BRANDS SECTION -->
              <div class="col-auto py-4 mt-4 mb-3 border shadow">
                <div class="row">
                  <section>
                    <div class="gradient-custom-1 h-100">
                      <div class="mask d-flex align-items-center h-100">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-12 text-center fw-bolder h4 mb-3">BRANDS</div>

                            <div class="col-12 d-flex justify-content-center">
                              <div class="table-responsive bg-white border">
                                <table class="table mb-0 table-bordered" style="max-height: 500px; overflow-y: auto;">
                                  <thead>
                                    <tr style="background-color: azure;">
                                      <th></th>
                                      <th>NAME</th>
                                      <th>ROOT</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $brand = Databases::Search("SELECT * FROM `brand`");
                                    $brandn = $brand->num_rows;
                                    for ($i = 1; $i <= $brandn; $i++) {
                                      $brandd = $brand->fetch_assoc();
                                    ?>
                                      <tr class="table-row-selectable">
                                        <td><input id="brandcheck<?php echo $i; ?>" type="checkbox" class="row-checkbox"></td>
                                        <td id="brandname<?php echo $i; ?>" value="<?php echo $brandd["name"]; ?>" class="px-md-3 px-lg-5"><?php echo $brandd["name"]; ?></td>
                                        <td class="px-md-3 px-lg-5"><?php echo $brandd["name"]; ?></td>
                                      </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                              <button onclick="brandelete(<?php echo $brandn ?>);" class="btn rounded-1 fw-bold x col-md-2">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> DELETE
                              </button>
                            </div>
                            <script>
                              function brandelete(num) {
                                let selectedBrands = [];

                                for (let index = 1; index <= num; index++) {
                                  const checkbox = document.getElementById("brandcheck" + index);
                                  if (checkbox && checkbox.checked) {
                                    const brandName = document.getElementById("brandname" + index).textContent.trim();
                                    selectedBrands.push(brandName);
                                  }
                                }

                                if (selectedBrands.length === 0) {
                                  alert("Please select at least one brand to delete.");
                                  return;
                                }

                                const formData = new FormData();
                                formData.append("brands", JSON.stringify(selectedBrands));

                                const xhr = new XMLHttpRequest();
                                xhr.open("POST", "process/branddelete.php", true);
                                xhr.onload = function() {
                                  if (xhr.status === 200) {
                                    alert(xhr.responseText);
                                    location.reload();
                                  } else {
                                    alert("Error deleting brand(s).");
                                  }
                                };
                                xhr.send(formData);
                              }
                            </script>

                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
              </div>

              <!-- JS: Enable row click toggling checkbox -->
              <script>
                document.querySelectorAll('.table-row-selectable').forEach(row => {
                  row.addEventListener('click', function(e) {
                    if (e.target.tagName.toLowerCase() !== 'input') {
                      const checkbox = this.querySelector('.row-checkbox');
                      checkbox.checked = !checkbox.checked;
                    }
                  });
                });
              </script>


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