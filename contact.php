<?php
require "connection.php";
$WEB = Database::Search("SELECT * FROM   `web_status`   WHERE `status`='0' ");
$WEBNUM = $WEB->num_rows;
if ($WEBNUM == 1) {
    comminzoon();
    exit();
}
function comminzoon()
{
?>
    <script>
        window.location = "coming-soon.php";
    </script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en" class="color-two font-exo">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Get in Touch – We're Here to Help</title>
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

    <!-- ========================= Breadcrumb Start =============================== -->
    <div class="breadcrumb mb-0 py-26 bg-main-two-50">
        <div class="container container-lg">
            <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                <h6 class="mb-0">Contact</h6>
                <ul class="flex-align gap-8 flex-wrap">
                    <li class="text-sm">
                        <a href="index.php" class="text-gray-900 flex-align gap-8 hover-text-main-600">
                            <i class="ph ph-house"></i>
                            Home
                        </a>
                    </li>
                    <li class="flex-align">
                        <i class="ph ph-caret-right"></i>
                    </li>
                    <li class="text-sm text-main-600"> Contact </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- ========================= Breadcrumb End =============================== -->

    <!-- ============================ Contact Section Start ================================== -->
    <?php
    $contact = Database::Search("SELECT * FROM `contact` ");
    $contactnum = $contact->num_rows;
    if ($contactnum == 1) {
        $contactdata = $contact->fetch_assoc();
        $email =  $contactdata["email"];
        $mobile = $contactdata["mobile"];
    } else {
        $email = 0;
        $mobile = 0;
    }
    ?>
    <section class="contact py-80">
        <div class="container container-lg">
            <div class="row gy-5">
                <div class="col-lg-8">
                    <div class="contact-box border border-gray-100 rounded-16 px-24 py-40">
                        
                            <h6 class="mb-32">Send Us a Message</h6>
                            <div class="row gy-4">
                                <div class="col-sm-6 col-xs-6">
                                    <label for="name" class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Full Name <span class="text-danger text-xl line-height-1">*</span> </label>
                                    <input type="text" class="common-input px-16" id="name" placeholder="Full name">
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <label for="email" class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Email Address <span class="text-danger text-xl line-height-1">*</span> </label>
                                    <input type="email" class="common-input px-16" id="email" placeholder="Email address">
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <label for="phone" class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Phone Number<span class="text-danger text-xl line-height-1">*</span> </label>
                                    <input type="number" class="common-input px-16" id="phone" placeholder="Phone Number*">
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <label for="subject" class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Subject <span class="text-danger text-xl line-height-1">*</span> </label>
                                    <input type="text" class="common-input px-16" id="subject" placeholder="Subject">
                                </div>
                                <div class="col-sm-12">
                                    <label for="message" class="flex-align gap-4 text-sm font-heading-two text-gray-900 fw-semibold mb-4">Message <span class="text-danger text-xl line-height-1">*</span> </label>
                                    <textarea class="common-input px-16" id="message" placeholder="Type your message"></textarea>
                                </div>
                                <div class="col-sm-12 mt-32">
                                    <button type="submit" onclick="sendWhatsAppMessage();" class="btn btn-main py-18 px-32 rounded-8">Send</button>
                                </div>
                            </div>
                        
                    </div>
                </div>
                <script>
                    function sendWhatsAppMessage() {
                        const name = document.getElementById("name").value.trim();
                        const email = document.getElementById("email").value.trim();
                        const phone = document.getElementById("phone").value.trim();
                        const subject = document.getElementById("subject").value.trim();
                        const message = document.getElementById("message").value.trim();

                        if (!name || !email || !phone || !subject || !message) {
                            alert("Please fill in all required fields.");
                            return;
                        }

                        const text = `Hello, my name is ${name}.%0AEmail: ${email}%0APhone: ${phone}%0ASubject: ${subject}%0AMessage: ${message}`;

                        const mobile = "<?php echo $mobile; ?>"; // This should be a valid WhatsApp number like 94771234567
                        const whatsappUrl = `https://wa.me/${mobile}?text=${text}`;

                        window.open(whatsappUrl, '_blank');
                    }
                </script>

                <div class="col-lg-4">
                    <div class="contact-box border border-gray-100 rounded-16 px-24 py-40">
                        <h6 class="mb-48">Get In Touch</h6>
                        <div class="flex-align gap-16 mb-16">
                            <span class="w-40 h-40 flex-center rounded-circle border border-gray-100 text-main-two-600 text-2xl flex-shrink-0"><i class="ph-fill ph-phone-call"></i></span>
                            <a href="tel:<?php echo $mobile ?>" class="text-md text-gray-900 hover-text-main-600"><?php echo $mobile ?></a>
                        </div>
                        <div class="flex-align gap-16 mb-16">
                            <span class="w-40 h-40 flex-center rounded-circle border border-gray-100 text-main-two-600 text-2xl flex-shrink-0"><i class="ph-fill ph-envelope"></i></span>
                            <a href="mailto:<?php echo $email ?>" class="text-md text-gray-900 hover-text-main-600"><?php echo $email ?></a>
                        </div>
                        <div class="flex-align gap-16 mb-0">
                            <span class="w-40 h-40 flex-center rounded-circle border border-gray-100 text-main-two-600 text-2xl flex-shrink-0"><i class="ph-fill ph-map-pin"></i></span>
                            <span class="text-md text-gray-900 ">789 , Colombo</span>
                        </div>
                    </div>
                    <div class="mt-24 flex-align flex-wrap gap-16 px-10">
                        <a href="tel:<?php echo $mobile ?>" class="bg-neutral-600 hover-bg-main-600 rounded-8 p-10 px-16 flex-between flex-wrap gap-8 flex-grow-1">
                            <span class="text-white fw-medium">Get Support On Call</span>
                            <span class="w-36 h-36 bg-main-600 rounded-8 flex-center text-xl text-white"><i class="ph ph-headset"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Contact Section End ================================== -->


    <?php require_once "footer.php"; ?>



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



</body>

</html>