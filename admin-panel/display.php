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
               <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
          </head>

          <body>
               <!-- !-->
               <div class="container-fluid">
                    <div class="row">

                         <div class="col-4">
                              <div class="row">
                                   <?php

                                   require "side.php";

                                   ?>
                              </div>
                         </div>
                         <div class="col-8">
                              <div class="row">
                                   <!-- !-->
                                   <div class="container mt-5">
                                        <div class="row justify-content-center">
                                             <div class="col-md-8 text-center p-4 border rounded shadow">
                                                  <h1 class="mb-3">Apply Coming Soon</h1>
                                                  <p class="lead">Stay tuned! Our application feature is launching soon. Get ready for an exciting experience.</p>

                                                  <?php
                                                  $zoon = Databases::Search("SELECT * FROM `web_status`");
                                                  $zoonn = $zoon->num_rows;
                                                  $buttonText = "Apply Coming Soon";
                                                  $statusValue = 0;

                                                  if ($zoonn == 1) {
                                                       $zoond = $zoon->fetch_assoc();
                                                       if ($zoond["status"] == 1) {
                                                            $buttonText = "Apply Coming Soon";
                                                            $statusValue = 0;
                                                       } else {
                                                            $buttonText = "Enable Website";
                                                            $statusValue = 1;
                                                       }
                                                  }
                                                  ?>
                                                  <button onclick="applyComingSoon(<?php echo $statusValue; ?>);" class="btn btn-primary btn-lg">
                                                       <?php echo $buttonText; ?>
                                                  </button>
                                             </div>
                                        </div>
                                   </div>
                                   <script>
                                        function applyComingSoon(status) {
                                             let confirmationText = status === 1 ?
                                                  "Are you sure you want to enable the website?" :
                                                  "Are you sure you want to set it to 'Coming Soon' mode?";

                                             if (confirm(confirmationText)) {
                                                  let xhr = new XMLHttpRequest();
                                                  xhr.open("POST", "process/webstatuschange.php", true);
                                                  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                  xhr.onreadystatechange = function() {
                                                       if (xhr.readyState === 4 && xhr.status === 200) {
                                                            let response = JSON.parse(xhr.responseText);
                                                            alert(response.message);
                                                            location.reload();
                                                       }
                                                  };
                                                  xhr.send("status=" + status);
                                             }
                                        }
                                   </script>
                                   <!-- !-->
                                   <div class="container">
                                        <div class="row g-4">
                                             <h1 class="mb-3">image Upload section</h1>
                                             <?php for ($i = 0; $i < 3; $i++) {
                                                  $slider = Databases::Search("SELECT * FROM `main_slider` WHERE `slider`='" . $i . "'");
                                                  $slidernum = $slider->num_rows;
                                                  if ($slidernum == 1) {
                                                       $sliderdata = $slider->fetch_assoc();
                                                       $main = "process/" . $sliderdata["main_path"];
                                                       $sub = "process/" . $sliderdata["sub_path"];
                                                  } else {
                                                       $main = ""; // Ensure variables are set properly
                                                       $sub = "";
                                                  }
                                             ?>
                                                  <div class="col-md-4">
                                                       <div class="card shadow-sm border-0 rounded-3">
                                                            <div class="card-body">
                                                                 <h4 class="text-info mb-3 text-center text-danger fw-bold">Add Main Slider for <?php echo $i + 1 ?>section</h4>
                                                                 <span>Note: MAIN-Image size y*y</span>
                                                                 <br />
                                                                 <span>Note: SUB-Image size 555*607</span>

                                                                 <!-- Main Image Upload -->
                                                                
                                                                 <!-- Sub Image Upload -->
                                                                 <div class="mb-3 text-center">
                                                                      <label class="form-label fw-bold">Sub Image</label>
                                                                      <div class="border p-3 d-flex flex-column align-items-center justify-content-center rounded upload-box bg-light position-relative" style="height: 200px; cursor: pointer;" onclick="document.getElementById('sub-img<?php echo $i ?>').click();">
                                                                           <input type="file" class="d-none" id="sub-img<?php echo $i ?>" accept="image/*" onchange="previewImage(event, 'sub-preview-<?php echo $i ?>')">
                                                                           <span class="small text-muted">Click to Upload Image</span>
                                                                           <img src="" class="img-fluid mt-2 preview-img position-absolute" id="sub-preview-<?php echo $i ?>" style="max-height: 100px; display: <?php echo $sub ? 'block' : 'none'; ?>;">
                                                                      </div>
                                                                 </div>

                                                                 <!-- Title Input -->
                                                                 <div class="mb-3">
                                                                      <label for="title-main<?php echo $i ?>" class="form-label fw-bold">Title</label>
                                                                      <input type="text" class="form-control shadow-sm" id="title-main<?php echo $i ?>" placeholder="Enter title">
                                                                 </div>

                                                                 <!-- Description Input -->
                                                                 <div class="mb-3">
                                                                      <label for="desc-main<?php echo $i ?>" class="form-label fw-bold">Description</label>
                                                                      <textarea class="form-control shadow-sm" id="desc-main<?php echo $i ?>" rows="3" placeholder="Enter description"></textarea>
                                                                 </div>

                                                                 <!-- Save Button -->
                                                                 <div class="text-center">
                                                                      <button class="btn btn-primary px-4 fw-bold shadow-sm" onclick="savemainsliderde('<?php echo $i ?>');">
                                                                           Save <i class="fas fa-save ms-1"></i>
                                                                      </button>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             <?php } ?>
                                        </div>

                                   </div>

                                   <script>
                                        function previewImage(event, previewId) {
                                             let file = event.target.files[0]; // Get selected file
                                             let reader = new FileReader(); // Read the file

                                             reader.onload = function() {
                                                  let img = document.getElementById(previewId);
                                                  img.src = reader.result; // Set preview image
                                                  img.style.display = "block"; // Show image
                                             };

                                             if (file) {
                                                  reader.readAsDataURL(file); // Read file as data URL
                                             }
                                        }

                                        function savemainsliderde(index) {
                                             let subImage = document.getElementById('sub-img' + index).files[0];
                                             let title = document.getElementById('title-main' + index).value;
                                             let desc = document.getElementById('desc-main' + index).value;

                                             if ( !subImage || title.trim() === '' || desc.trim() === '') {
                                                  alert('Please fill all fields and upload images.');
                                                  return;
                                             }

                                             let formData = new FormData();
                                             formData.append('sub_image', subImage);
                                             formData.append('title', title);
                                             formData.append('description', desc);
                                             formData.append('index', index);

                                             fetch('process/main-slider-save.php', {
                                                       method: 'POST',
                                                       body: formData
                                                  })
                                                  .then(response => response.text())
                                                  .then(data => {
                                                       Swal.fire({
                                                            title: 'Success!',
                                                            text: data,
                                                            icon: 'success',
                                                            confirmButtonColor: '#28a745', // Green color for success
                                                            confirmButtonText: 'OK'
                                                       });
                                                  })
                                                  .catch(error => {
                                                       console.error('Error:', error);
                                                       Swal.fire({
                                                            title: 'Error!',
                                                            text: 'Something went wrong. Please try again.',
                                                            icon: 'error',
                                                            confirmButtonColor: '#dc3545', // Red color for error
                                                            confirmButtonText: 'OK'
                                                       });
                                                  });

                                        }
                                   </script>
                                   <!-- !-->
                                   <!-- !-->
                                   <div class="col-12">
                                        <div class="row">
                                             <div class="col-12">
                                                  <div class="row">
                                                       <h1 class="text-center fw-bold mb-4">Advertisement Upload Area</h1>
                                                       <?php
                                                       for ($a = 0; $a < 3; $a++) {
                                                       ?>
                                                            <div class="col-12 col-lg-4 mb-4">
                                                                 <div class="card">
                                                                      <div class="card-body">
                                                                           <h3 class="text-center fw-bold mb-3">Advertisement <?php echo $a + 1; ?> Upload</h3>
                                                                           <span>Note: Image size 98*115</span>
                                                                           <div class="mb-3">
                                                                                <label for="title-add<?php echo $a; ?>" class="form-label">Title</label>
                                                                                <input type="text" id="title-add<?php echo $a; ?>" class="form-control" placeholder="Enter title" />
                                                                           </div>

                                                                           <div class="mb-3">
                                                                                <label for="description-add<?php echo $a; ?>" class="form-label">Description</label>
                                                                                <input type="text" id="description-add<?php echo $a; ?>" class="form-control" placeholder="Enter description" />
                                                                           </div>

                                                                           <div class="mb-3">
                                                                                <label for="file-add<?php echo $a; ?>" class="form-label">Upload Image</label>
                                                                                <input type="file" id="file-add<?php echo $a; ?>" class="form-control" />
                                                                           </div>

                                                                           <div class="text-center">
                                                                                <button class="btn btn-success" onclick="uploadeadd(<?php echo $a; ?>)">Upload Advertisement</button>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       <?php
                                                       }
                                                       ?>
                                                  </div>
                                             </div>
                                             <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                                             <script>
                                                  // JavaScript function to handle the advertisement upload process
                                                  function uploadeadd(index) {
                                                       // Retrieve the input fields by their IDs dynamically based on the index
                                                       var title = document.getElementById('title-add' + index).value;
                                                       var description = document.getElementById('description-add' + index).value;
                                                       var fileInput = document.getElementById('file-add' + index);

                                                       // Ensure that all fields are filled before proceeding
                                                       if (title.trim() === "" || description.trim() === "" || fileInput.files.length === 0) {
                                                            Swal.fire({
                                                                 icon: 'error',
                                                                 title: 'Oops...',
                                                                 text: 'Please fill in all fields and upload an image.',
                                                            });
                                                            return;
                                                       }

                                                       // Title and description length validation
                                                       if (title.length > 45) {
                                                            Swal.fire({
                                                                 icon: 'error',
                                                                 title: 'Oops...',
                                                                 text: 'Title cannot exceed 45 characters.',
                                                            });
                                                            return;
                                                       }

                                                       if (description.length > 45) {
                                                            Swal.fire({
                                                                 icon: 'error',
                                                                 title: 'Oops...',
                                                                 text: 'Description cannot exceed 45 characters.',
                                                            });
                                                            return;
                                                       }

                                                       // Get the uploaded file from the file input
                                                       var file = fileInput.files[0];

                                                       // Validate the file type and file extension
                                                       var validImageTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
                                                       if (!validImageTypes.includes(file.type)) {
                                                            Swal.fire({
                                                                 icon: 'error',
                                                                 title: 'Oops...',
                                                                 text: 'Only JPG, PNG, and SVG image files are allowed.',
                                                            });
                                                            return;
                                                       }

                                                       // Create a new FormData object to handle the file upload
                                                       var formData = new FormData();
                                                       formData.append('title', title);
                                                       formData.append('description', description);
                                                       formData.append('image', file);
                                                       formData.append('index', index);

                                                       // Example: AJAX request to send the data to the server (you can change the URL and process the PHP file as needed)
                                                       var xhr = new XMLHttpRequest();
                                                       xhr.open('POST', 'process/upload_advertisement.php', true);

                                                       xhr.onload = function() {
                                                            if (xhr.status === 200) {
                                                                 // Handle successful upload
                                                                 Swal.fire({
                                                                      icon: 'success',
                                                                      title: 'Success',
                                                                      text: xhr.responseText,
                                                                 });

                                                                 // Reset the form or update the UI accordingly
                                                                 document.getElementById('title-add' + index).value = "";
                                                                 document.getElementById('description-add' + index).value = "";
                                                                 fileInput.value = "";
                                                            } else {
                                                                 // Handle error
                                                                 Swal.fire({
                                                                      icon: 'error',
                                                                      title: 'Error',
                                                                      text: 'Error uploading advertisement. Please try again.',
                                                                 });
                                                            }
                                                       };

                                                       // Send the FormData object with the data
                                                       xhr.send(formData);
                                                  }
                                             </script>

                                        </div>
                                   </div>
                                   <!-- !-->
                                   <!-- !-->
                                   <div class="container mt-4">
                                        <div class="card shadow-lg p-4">
                                             <h2 class="text-center text-primary">Top Selling Advertisement</h2>
                                             <form id="topSellForm">
                                                  <div class="mb-3">
                                                       <label for="top_s_title" class="form-label">Title</label>
                                                       <input id="top_s_title" type="text" class="form-control" placeholder="Enter advertisement title" />
                                                  </div>

                                                  <div class="mb-3">
                                                       <label for="top_s_desc" class="form-label">Description</label>
                                                       <textarea id="top_s_desc" class="form-control" rows="3" placeholder="Enter description"></textarea>
                                                  </div>

                                                  <div class="mb-3">
                                                       <label for="top_s_file" class="form-label">Upload Image</label>
                                                       <input id="top_s_file" type="file" class="form-control" />
                                                  </div>

                                                  <div class="text-center">
                                                       <button type="submit" class="btn btn-primary btn-lg">
                                                            Upload Advertisement
                                                       </button>
                                                  </div>
                                             </form>
                                        </div>
                                   </div>
                                   <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                             document.getElementById("topSellForm").addEventListener("submit", function(event) {
                                                  event.preventDefault(); // Prevent default form submission

                                                  let title = document.getElementById("top_s_title").value.trim();
                                                  let description = document.getElementById("top_s_desc").value.trim();
                                                  let fileInput = document.getElementById("top_s_file");
                                                  let file = fileInput.files[0];

                                                  if (title === "" || description === "" || !file) {
                                                       alert("Please fill all fields and select a file.");
                                                       return;
                                                  }

                                                  let formData = new FormData();
                                                  formData.append("title", title);
                                                  formData.append("description", description);
                                                  formData.append("file", file);

                                                  fetch("process/topselladdsave.php", {
                                                            method: "POST",
                                                            body: formData
                                                       })
                                                       .then(response => response.json())
                                                       .then(data => {
                                                            if (data.success) {
                                                                 alert("Advertisement uploaded successfully!");
                                                                 document.getElementById("topSellForm").reset();
                                                            } else {
                                                                 alert("Error: " + data.message);
                                                            }
                                                       })
                                                       .catch(error => {
                                                            console.error("Error:", error);
                                                            alert("An error occurred while uploading.");
                                                       });
                                             });
                                        });
                                   </script>
                                   <!-- !-->
                              </div>
                         </div>
                    </div>
               </div>
               <!-- !-->
          </body>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <script src="assets-admin/libs/jquery/dist/jquery.min.js"></script>
          <script src="assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
          <script src="assets-admin/js/sidebarmenu.js"></script>
          <script src="assets-admin/js/app.min.js"></script>
          <script src="assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
          <script src="assets-admin/libs/simplebar/dist/simplebar.js"></script>
          <script src="assets-admin/js/dashboard.js"></script>
          <script src="sahan.js"></script>
          <!-- SweetAlert2 CSS -->
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

          <!-- SweetAlert2 JavaScript -->
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

          </html>
<?php
     }
}
?>