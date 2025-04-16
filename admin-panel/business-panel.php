<?php
session_start();

if (!isset($_SESSION["a"])) {
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
            <script src="https://cdn.tiny.cloud/1/v6ya2mxbd70fn22v774qp5fw78t114ccnejem2vy8oriyj04/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

        </head>

        <body onload="change_branch()">
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

                    <div class="container-fluid px-md-5">

                        <div class="row">
                            <div class="col-12 text-center mb-0">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Privacy Policy&nbsp;&nbsp;<i class="fa fa-balance-scale" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can change your privacy policies here</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div class="col-12 px-3">
                                                <textarea id="privacy" class="form-control" rows="10" placeholder="Enter your privacy policy"></textarea>
                                            </div>
                                            <div class="col-12 text-end mt-3">
                                                <button class="btn rounded-0-5 fw-bold x" data-bs-toggle="modal" onclick="savePrivacy();" data-bs-target="#exampleModal"><i class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            tinymce.init({
                                selector: '#privacy', // Target the privacy textarea
                                height: 300,
                                menubar: false,
                                plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image',
                                branding: false, // Optional: Hide branding
                                statusbar: false, // Optional: Hide status bar
                            });

                            function savePrivacy() {
                                const privacyText = tinymce.get('privacy').getContent().trim();

                                // Validate input
                                if (!privacyText) {
                                    alert("Please enter a privacy policy.");
                                    return;
                                }

                                // Create a confirmation prompt
                                if (confirm("Are you sure you want to save the privacy policy?")) {
                                    let xhr = new XMLHttpRequest();
                                    xhr.open("POST", "process/privsave.php", true);
                                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            let response = JSON.parse(xhr.responseText);
                                            alert(response.message);

                                            // If success, clear the input field
                                            if (response.success) {
                                                tinymce.get('privacy').setContent(''); // Reset the editor
                                            }
                                        }
                                    };

                                    // Send the privacy policy text to the PHP file
                                    xhr.send("privacy=" + encodeURIComponent(privacyText));
                                }
                            }
                        </script>

                        <!-- !-->
                        <!-- add cities -->
                        <div class="row mt-5">
                            <div class="col-12 text-center mb-0">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Add Cities&nbsp;&nbsp;<i class="fa fa-globe" aria-hidden="true"></i>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can add and edit city details here</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-1 col-10 offset-md-0 col-md-4 d-flex flex-row justify-content-center">
                                <img src="../admin-panel/assets-admin/images/contact/branch_i.svg" class="img-fluid" width="300px">
                            </div>
                            <div class="col-12 col-md-8 mb-2">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="ad_id" onchange="list_town();"
                                                        aria-label="Floating label select example">
                                                        <option selected value="0" selected>Select a district</option>
                                                        <?php
                                                        $district_q1 = Databases::search("SELECT * FROM `distric` ");
                                                        while ($district1 = $district_q1->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $district1['distric_id'] ?>">
                                                                <?php echo $district1['name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="c_id">District</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="at_id"
                                                        aria-label="Floating label select example">

                                                    </select>
                                                    <label for="c_id">Available Cities</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 py-1">
                                                <button
                                                    class="btn btn-lg btn-light-danger border-danger border-opacity-25 rounded-0-5 text-dark-emphasis fw-100 fs-4" onclick="add_town_col();">ADD</button>
                                            </div>
                                            <div class="col-12">
                                                <div class="row" id="town_col">

                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button class="btn rounded-0-5 fw-bold x" data-bs-toggle="modal"
                                                    onclick="savecities();" data-bs-target="#exampleModal"><i
                                                        class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                            <script>
                                                var town_col_count = 0;

                                                function add_town_col() {
                                                    var town_col = document.getElementById("town_col");
                                                    if (town_col_count <= 10) {
                                                        town_col_count = town_col_count + 1;
                                                        town_col.insertAdjacentHTML("beforeend",
                                                            "<div class='col-6 col-md-4 position-relative' id='dfDiv_" + town_col_count + "' >" +
                                                            "<div class='form-floating mb-3'>" +
                                                            "<input type='text' class='form-control rounded-0' id='df_" + town_col_count + "' value='' placeholder=''>" +
                                                            "<label for=''>City Name</label>" +
                                                            " <button type='button' onclick='removeDF(" + town_col_count + ");' class='delete-btn'><i class='fa fa-trash' aria-hidden='true'></i></button>" +
                                                            "</div>" +
                                                            "</div>"
                                                        );
                                                    } else {
                                                        alert("A maximum of 10 cities can be added at a time.");
                                                    }

                                                }

                                                function removeDF(id) {
                                                    var element = document.getElementById('dfDiv_' + id);
                                                    if (element) {
                                                        element.remove();
                                                        town_col_count = town_col_count - 1;
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 mb-2 d-none">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="ad_id" onchange="list_town();" aria-label="Floating label select example">
                                                        <option selected value="0" selected>Select a district</option>
                                                        <?php
                                                        $district_q1 = Databases::search("SELECT * FROM `distric` ");
                                                        while ($district1 = $district_q1->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $district1['distric_id'] ?>">
                                                                <?php echo $district1['name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="c_id">District</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="at_id" aria-label="Floating label select example">

                                                    </select>
                                                    <label for="c_id">Town</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 py-1">
                                                <button class="btn btn-lg btn-light-danger border-danger border-opacity-25 rounded-0-5 text-dark-emphasis fw-100 fs-4" onclick="add_town_col();">ADD</button>
                                            </div>
                                            <div class="col-12">
                                                <div class="row" id="town_col">

                                                </div>
                                            </div>
                                            <input type="number" value="" hidden id="num" />
                                            <div class="col-12 text-end">
                                                <button onclick="savecities();" class="btn rounded-0-5 fw-bold x"><i class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- shipping cost -->
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Delivery Charges&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can add or change your delivery charges
                                        here</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="offset-1 col-10 offset-md-0 col-md-4 d-flex flex-row justify-content-center order-md-2">
                                <img src="../admin-panel/assets-admin/images/contact/delivey_img.svg" class="img-fluid" width="300px">
                            </div>
                            <div class="col-12 col-md-8 order-md-1">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div hidden class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="c_id" onchange="list_dprice();" aria-label="Floating label select example">
                                                        <option selected value="0" selected>Select a city</option>
                                                        <?php
                                                        $district_q = DatabaseS::search("SELECT * FROM `city` ");
                                                        while ($district = $district_q->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $district['city_id'] ?>">
                                                                <?php echo $district['name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="c_id">FROM</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select rounded-0" id="c_id2" onchange="list_dprice();" aria-label="Floating label select example">
                                                        <option selected value="0" selected>Select a district</option>
                                                        <?php
                                                        $district_q = Databases::search("SELECT * FROM `city`");
                                                        while ($district = $district_q->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?php echo $district['city_id'] ?>">
                                                                <?php echo $district['name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="c_id2">TO</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control rounded-0" id="d_price" value="" placeholder="charges">
                                                    <label for="d_price">Delivery charges</label>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button class="btn rounded-0-5 fw-bold x" onclick="update_dprice();"><i class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- !-->
                        <div class="container">
                            <div class="row">
                                <!-- !-->
                                <script>
                                    function calculatePrice() {
                                        let thisWeight = document.getElementById('thisWeight').value;
                                        let thisPrice = document.getElementById('thisPrice').value;
                                        let forWeight = document.getElementById('forWeight').value;

                                        if (thisWeight > 0 && thisPrice > 0 && forWeight > 0) {
                                            let xhr = new XMLHttpRequest();
                                            xhr.open("POST", "process/calculate_price.php", true);
                                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                            xhr.onreadystatechange = function() {
                                                if (xhr.readyState === 4 && xhr.status === 200) {
                                                    document.getElementById('priceResult').innerHTML = "For price: RS: " + xhr.responseText;
                                                }
                                            };
                                            xhr.send("thisWeight=" + thisWeight + "&thisPrice=" + thisPrice + "&forWeight=" + forWeight);
                                        } else {
                                            alert("Please enter valid values.");
                                        }
                                    }
                                </script>
                                <div class="container mt-5">
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <div class="card shadow p-4">
                                                <h4 class="fw-semibold text-center">Calculate Your Excess Weight Price</h4>
                                                <p class="text-muted text-center">If X is for this weight, what is the price for Y?</p>

                                                <div class="mb-3">
                                                    <label class="form-label">This Weight (kg)</label>
                                                    <input type="number" id="thisWeight" class="form-control" placeholder="Enter weight (e.g., 100)">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">This Price (RS)</label>
                                                    <input type="number" id="thisPrice" class="form-control" placeholder="Enter price (e.g., 20)">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">For Weight (kg)</label>
                                                    <input type="number" oninput="calculatePrice()" id="forWeight" class="form-control" placeholder="Enter weight (e.g., 320)">
                                                </div>

                                                <div class="text-center">
                                                    <button class="btn btn-primary w-100==" onclick="calculatePrice()">Calculate</button>
                                                </div>
                                                <div class="mt-3 text-center">
                                                    <h4 id="priceResult" class="fw-bold text-danger">For price: RS: </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- !-->
                            </div>

                            <div class="row">
                                <div class="col-12 text-center mb-3">
                                    <h4 class="fw-semibold mb-1">Additional Delivery Fee for Weight <i class="fa"></i></h4>

                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <img src="../admin-panel/assets-admin/images/contact/email_i.svg" class="img-fluid" width="250px">
                                </div>

                                <div class="col-md-8">
                                    <div class="shadow p-4 rounded">
                                        <div class="mb-3">
                                            <label for="wprice" class="form-label">Additional Fee for Delivery</label>
                                            <input type="text" class="form-control rounded-0" id="wprice" placeholder="Enter additional fee">
                                        </div>

                                        <div class="mb-3">
                                            <label for="wid" class="form-label">Select Weight</label>
                                            <select id="wid" class="form-select rounded-0">
                                                <?php
                                                $we = Databases::Search("SELECT * FROM `weight`");
                                                $wenum = $we->num_rows;
                                                for ($i = 0; $i < $wenum; $i++) {
                                                    $wed = $we->fetch_assoc();
                                                    $dffw = Databases::Search("SELECT * FROM `delivery_fee_for_weight` WHERE `weight_id`='" . $wed["id"] . "' ");
                                                    $dffwnum = $dffw->num_rows;
                                                    if ($dffwnum != 1) {
                                                ?>
                                                        <option value="<?php echo $wed["id"]; ?>"><?php echo $wed["weight"]; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary fw-bold px-4 py-2" data-bs-toggle="modal" onclick="saveWeight();" data-bs-target="#exampleModal">
                                                <i class="fa fa-check"></i> SAVE
                                            </button>
                                        </div>

                                        <script>
                                            function saveWeight() {
                                                const weightId = document.getElementById("wid").value;
                                                const fee = document.getElementById("wprice").value;

                                                if (!weightId || !fee) {
                                                    alert("Please select a weight and enter a fee.");
                                                    return;
                                                }

                                                // Create a confirmation prompt
                                                if (confirm("Are you sure you want to save the selected weight and fee?")) {
                                                    let xhr = new XMLHttpRequest();
                                                    xhr.open("POST", "process/DeliveryFeeforWeight.php", true);
                                                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                                                    xhr.onreadystatechange = function() {
                                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                                            let response = JSON.parse(xhr.responseText);
                                                            alert(response.message);

                                                            // If success, reset the form or close modal
                                                            if (response.success) {
                                                                document.getElementById("wid").value = ''; // Reset selection
                                                                document.getElementById("wprice").value = ''; // Reset fee
                                                                // Optionally close the modal here
                                                                $('#exampleModal').modal('hide');
                                                                location.reload();
                                                            }
                                                        }
                                                    };

                                                    // Sending both the selected weight ID and the fee to the PHP file
                                                    xhr.send("weightId=" + encodeURIComponent(weightId) + "&fee=" + encodeURIComponent(fee));
                                                }
                                            }
                                        </script>

                                        <div class="mb-3">
                                            <label for="wid" class="form-label fw-semibold">Delete Weight</label>
                                            <div class="input-group">
                                                <select id="wid2" class="form-select rounded-0">
                                                    <?php
                                                    $dfw = Databases::Search("SELECT * FROM `delivery_fee_for_weight` ");
                                                    $dfwnum = $dfw->num_rows;
                                                    for ($i = 0; $i < $dfwnum; $i++) {
                                                        $dfdata = $dfw->fetch_assoc();
                                                        $w = Databases::Search("SELECT * FROM `weight` WHERE `id`='" . $dfdata["weight_id"] . "' ");
                                                        $ww = $w->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $dfdata["id"]; ?>">
                                                            <?php echo $ww["weight"] . " kg - RS " . $dfdata["fee"]; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <button class="btn btn-danger rounded-0" onclick="deleteWeight();">
                                                    <i class="fa fa-trash"></i> DELETE
                                                </button>
                                            </div>
                                        </div>

                                        <script>
                                            function deleteWeight() {
                                                let selectedWeightId = document.getElementById("wid2").value;
                                                if (selectedWeightId) {
                                                    if (confirm("Are you sure you want to delete this weight entry?")) {
                                                        let xhr = new XMLHttpRequest();
                                                        xhr.open("POST", "process/delete_weight.php", true);
                                                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                        xhr.onreadystatechange = function() {
                                                            if (xhr.readyState === 4 && xhr.status === 200) {
                                                                alert(xhr.responseText);
                                                                location.reload(); // Reload to update the list
                                                            }
                                                        };
                                                        xhr.send("weightId=" + selectedWeightId);
                                                    }
                                                } else {
                                                    alert("Please select a weight to delete.");
                                                }
                                            }
                                        </script>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- !-->
                        <!-- contact us -->
                        <div class="row mt-5">
                            <div class="col-12 text-center mb-0">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Contact Us&nbsp;&nbsp;<i class="fa fa-envelope" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can change your contact
                                        details here</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-1 col-10 offset-md-0 col-md-4 d-flex flex-row justify-content-center order-md-2">
                                <img src="../admin-panel/assets-admin/images/contact/email_i.svg" class="img-fluid" width="300px">
                            </div>
                            <div class="col-12 col-md-8 order-md-1">
                                <div class="row d-flex flex-row justify-content-center align-items-center h-100">
                                    <div class="col-12 shadow p-3 py-4">
                                        <div class="row">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control rounded-0" id="contact_email" placeholder="name@example.com">
                                                <label for="floatingInput">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-0" id="contact_mobile" placeholder="..+94.">
                                                <label for="floatingInput">Mobile Number</label>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button class="btn rounded-0-5 fw-bold x" data-bs-toggle="modal" onclick="change_emailN();" data-bs-target="#exampleModal"><i class="fa fa-check"></i>
                                                    SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            <script src="sahan.js"></script>
            <!-- SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

            <!-- SweetAlert2 JavaScript -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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