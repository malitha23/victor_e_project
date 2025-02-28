<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>replace_title_admin</title>
  <link rel="shortcut icon" type="image/png" href="assets-admin/images/logos/store_logo.webp" />
  <link rel="stylesheet" href="assets-admin/css/styles.min.css" />
</head>

<body style="background-color:rgb(232, 232, 253);">
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden min-vh-100 d-flex ">
      <div class="d-flex align-items-start align-items-md-center justify-content-center w-100 mt-5 mt-md-0">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <h1 class="text-center">Vicstore</h1>
                  <div class="mb-3">
                    <label for="u" class="form-label">Username</label>
                    <input type="text" class="form-control" id="userName" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                  </div>
         
                  <a href="#" class="btn x w-100 py-8 fs-4 mb-4 rounded-2" onclick="adminLogin();">Sign In</a>   
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets-admin/js/script.js"></script>
  <script src="assets-admin/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>