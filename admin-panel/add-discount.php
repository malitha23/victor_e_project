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
      <!-- Bootstrap CSS -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    </head>

    <body>

      <div class="container mt-5 animate__animated animate__fadeIn">
        <div class="card shadow-lg p-4 rounded-4">
          <h2 class="text-center mb-4">Product Details Form</h2>
          <div class="row g-4">
            <!-- Left Column (Form Inputs) -->
            <div class="col-lg-6 col-12">
              <!-- Title -->
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" placeholder="Enter Title" required>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Enter Description" required></textarea>
              </div>

              <!-- Image Upload -->
              <div class="mb-4">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" accept="image/*" required>
              </div>
            </div>

            <!-- Right Column (Form Inputs) -->
            <div class="col-lg-6 col-12">

              <!-- Selector -->
              <div class="mb-3">
                <?php
                $batch = Databases::Search("SELECT * FROM `batch`");
                $batchnum = $batch->num_rows;
                ?>
                <label for="batch" class="form-label">Select Product</label>
                <select class="form-select" id="batch" required>
                  <option value="0" selected>Select Option</option>
                  <?php
                  for ($i = 0; $i < $batchnum; $i++) {
                    $batchdeta = $batch->fetch_assoc();
                    $product = Databases::Search("SELECT * FROM `product` WHERE `id`='" . $batchdeta["product_id"] . "' ");
                    $productdata = $product->fetch_assoc();
                  ?>
                    <option value="<?php echo $batchdeta["id"] ?>"><?php echo $productdata["title"] ?></option>
                  <?php
                  }
                  ?>
                  <option value="product">Product</option>
                  <option value="discount_percentage">Discount Percentage</option>
                  <option value="qty">Quantity</option>
                </select>
              </div>

              <!-- Quantity -->
              <div class="mb-3">
                <label for="qty" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="qty" placeholder="Enter Quantity" required>
              </div>

              <!-- Discount Percentage -->
              <div class="mb-3">
                <label for="discount" class="form-label">Discount Percentage</label>
                <input type="number" class="form-control" id="discount" placeholder="Enter Discount Percentage" required>
              </div>

              <!-- Start Date -->
              <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" required>
              </div>

              <!-- End Date -->
              <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" required>
              </div>

              <!-- Submit Button -->
              <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2 animate__animated animate__bounceIn" onclick="submitdiscount();">Submit</button>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Bootstrap JS & Popper -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    </body>
    <script src="sahan.js"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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