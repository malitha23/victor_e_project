<?php
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en" class="color-two font-exo">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>replace_title</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- select 2 -->
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <!-- Slick -->
    <link rel="stylesheet" href="assets/css/slick.css">
    <!-- Jquery Ui -->
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <!-- animate -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- AOS Animation -->
    <link rel="stylesheet" href="assets/css/aos.css">
    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <img src="assets/images/icon/preloader.gif" alt="">
    </div>
    <!--==================== Preloader End ====================-->

    <?php require_once "basic_header.php"; ?>
    <div class="container-fluid">
        <div class="row bg-main-two-50">
            <div class="col-12 text-center" style="margin-bottom: 50px; margin-top: 50px;">
                <img src="assets/images/logo/logo-two-black.png" alt="" class="mb-4">
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-12 text-center h3 fw-semibold text-dark">
                Welcome to Vicstore
            </div>
        </div>
    </div>

    <!-- =============================== Account Section Start =========================== -->
    <section class="account py-80">
        <div class="container container-lg">
            <form action="#">
                <div class="row gy-4">

                    <!-- Login Card Start -->
                    <div class="col-xl-6 pe-xl-5">
                        <div class="border border-gray-100 hover-border-main-600 transition-1 rounded-16 px-24 py-40 h-100">
                            <h6 class="text-center text-main">Already have an account ?</h6>
                            <h6 class="text-xl mb-32">Login</h6>
                            <?php
                            $email = isset($_COOKIE["email"]) ? $_COOKIE["email"] : "";
                            $password = isset($_COOKIE["password"]) ? $_COOKIE["password"] : "";
                            ?>
                            <div class="mb-24">
                                <label for="email" class="text-neutral-900 text-lg mb-8 fw-medium">Email Address <span class="text-danger">*</span> </label>
                                <input type="text" class="common-input" id="email" placeholder="Email Address" value="<?php echo $email; ?>">
                            </div>
                            <div class="mb-24">
                                <label for="password" class="text-neutral-900 text-lg mb-8 fw-medium">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="common-input" id="password" placeholder="Enter Password" value="<?php echo $password; ?>">
                                    <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash" id="toggle-password"></span>
                                </div>
                            </div>
                            <script>
                                document.getElementById("toggle-password").addEventListener("click", function() {
                                    const passwordField = document.getElementById("password");
                                    const isPasswordVisible = passwordField.getAttribute("type") === "text";
                                    passwordField.setAttribute("type", isPasswordVisible ? "password" : "text");
                                    this.classList.toggle("ph-eye");
                                    this.classList.toggle("ph-eye-slash");
                                });
                            </script>
                            <div class="mb-24 mt-48">
                                <div class="flex-align gap-48 flex-wrap">
                                    <button class="btn btn-main py-18 px-40" onclick="login();">Log in</button>
                                    <div class="form-check common-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember">
                                        <label class="form-check-label flex-grow-1" for="remember">Remember me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-48">
                                <a href="#" class="text-danger-600 text-sm fw-semibold hover-text-decoration-underline" onclick="forgotpassword();">Forgot your password?</a>
                            </div>
                        </div>
                    </div>
                    <!-- Login Card End -->
                    <!-- Forgot Password Modal -->
                    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="forgotPasswordLabel">Reset Your Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="forgotPasswordForm">
                                        <!-- Verification Code Input -->
                                        <div class="mb-3">
                                            <label for="verificationCode" class="form-label">Verification Code</label>
                                            <input type="text" class="form-control" id="verificationCode" placeholder="Enter your code" required>
                                        </div>
                                        <!-- New Password Input -->
                                        <div class="mb-3">
                                            <label for="newPassword" class="form-label">New Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
                                                <span class="input-group-text password-toggle" onclick="togglePassword('newPassword')">
                                                    <i class="bi bi-eye" id="newPasswordIcon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Confirm Password Input -->
                                        <div class="mb-3">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirmPassword" placeholder="Re-enter password" required>
                                                <span class="input-group-text password-toggle" onclick="togglePassword('confirmPassword')">
                                                    <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updatePassword()">Update Password</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
                        // Function to toggle password visibility
                        function togglePassword(inputId) {
                            const input = document.getElementById(inputId);
                            const icon = document.getElementById(inputId + 'Icon');
                            if (input.type === 'password') {
                                input.type = 'text';
                                icon.classList.remove('bi-eye');
                                icon.classList.add('bi-eye-slash');
                            } else {
                                input.type = 'password';
                                icon.classList.remove('bi-eye-slash');
                                icon.classList.add('bi-eye');
                            }
                        }
                    </script>
                    <!-- Register Card Start -->
                    <div class="col-xl-6">
                        <div class="border border-gray-100 hover-border-main-600 transition-1 rounded-16 px-24 py-40">
                            <h6 class="text-center text-main">New to Vicstore ?</h6>
                            <h6 class="text-xl mb-32">Register</h6>
                            <div class="mb-24">
                                <label for="usernameTwo" class="text-neutral-900 text-lg mb-8 fw-medium">mobile <span class="text-danger">*</span> </label>
                                <input type="text" class="common-input" id="mobile" placeholder="Write a username">
                            </div>
                            <div class="mb-24">
                                <label for="emailTwo" class="text-neutral-900 text-lg mb-8 fw-medium">Email address <span class="text-danger">*</span> </label>
                                <input type="email" class="common-input" id="emailTwo" placeholder="Enter Email Address">
                            </div>
                            <div class="mb-24">
                                <label for="enter-password" class="text-neutral-900 text-lg mb-8 fw-medium">Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="passwordtwo" class="common-input" id="enter-password" placeholder="Enter Password">
                                    <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash" id="#enter-password"></span>
                                </div>
                            </div>
                            <div class="my-48">
                                <p class="text-gray-500">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our
                                    .
                                </p>
                            </div>
                            <div class="mt-48">
                                <button type="submit" class="btn btn-main py-18 px-40" onclick="Registernow();">Register</button>
                            </div>
                        </div>
                    </div>
                    <!-- Register Card End -->
                    <!-- agreement model -->
                    <!-- Trigger button for the modal -->
                    <button type="button" class="btn btn-primary" onclick="openUserAgreement();">
                        Sign Up
                    </button>

                    <!-- Modal Structure -->
                    <div class="modal fade" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="agreementModalLabel">Privacy Agreement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $a = Database::Search("SELECT * FROM `privacy`");
                                    $adata = $a->fetch_assoc();
                                    ?>
                                    <p><?php echo $adata["Privacy"]; ?></p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agree" />
                                        <label class="form-check-label" for="agree">
                                            I agree to the terms and conditions
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="registerBtn" onclick="register()" class="btn btn-primary" disabled>Register</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- agreement model -->

                </div>
            </form>
        </div>
    </section>
    <!-- =============================== Account Section End =========================== -->




    <?php require "footer.php"; ?>



    <!-- Jquery js -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="assets/js/boostrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="assets/js/phosphor-icon.js"></script>
    <!-- Select 2 -->
    <script src="assets/js/select2.min.js"></script>
    <!-- Slick js -->
    <script src="assets/js/slick.min.js"></script>
    <!-- Slick js -->
    <script src="assets/js/count-down.js"></script>
    <!-- jquery UI js -->
    <script src="assets/js/jquery-ui.js"></script>
    <!-- wow js -->
    <script src="assets/js/wow.min.js"></script>
    <!-- AOS Animation -->
    <script src="assets/js/aos.js"></script>
    <!-- marque -->
    <script src="assets/js/marque.min.js"></script>
    <!-- marque -->
    <script src="assets/js/vanilla-tilt.min.js"></script>
    <!-- Counter -->
    <script src="assets/js/counter.min.js"></script>
    <!-- main js -->
    <script src="assets/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="sahan.js"></script>
</body>

</html>