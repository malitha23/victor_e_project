<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMING-SOON</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

</head>

<body class="overflow-hidden">

    <div class="container-fluid vh-100 p-0 bgc d-flex justify-content-center align-items-center overflow-hidden">

        <?php
        require_once "connection.php";
        $contact_d = Database::Search("SELECT * FROM `contact`");
        $con = $contact_d->fetch_assoc();
        ?>

        <link href="https://fonts.googleapis.com/css2?family=Edu+QLD+Beginner:wght@400..700&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>
            .edu-qld-beginner {
                font-family: "Edu QLD Beginner", cursive;
                font-optical-sizing: auto;
                font-weight: 700;
                font-style: normal;
            }

            .bgc {
                background-color: rgb(196, 207, 255);
                background-image: url("assets/images/abstract-luxury-gradient-blue-background-smooth-dark-blue-with-black-vignette-studio-banner.jpg");
                background-position: center;
                background-size: cover;
            }

            #typing-text::after {
                content: "|";
                animation: blink 0.7s step-end infinite;
            }

            @keyframes blink {

                from,
                to {
                    opacity: 0;
                }

                50% {
                    opacity: 1;
                }
            }
        </style>
        <div class="vh-100 d-flex flex-column justify-content-between px-5 overflow-hidden">
            
            <div class="text-center mt-auto mb-auto">
                <div class="text-white display-1 edu-qld-beginner overflow-hidden text-center" id="typing-text"></div>
                <script>
                    const text = "COMING SOON";
                    const typingTarget = document.getElementById("typing-text");
                    let index = 0;

                    function typeWriter() {
                        if (index < text.length) {
                            typingTarget.innerHTML += text.charAt(index);
                            index++;
                            setTimeout(typeWriter, 150); // typing speed in ms
                        }
                    }

                    window.onload = typeWriter;
                </script>

                <div class="h5 text-white edu-qld-beginner overflow-hidden">
                    We’re working hard to launch the best shopping experience for you.
                </div>
            </div>

            <!-- Bottom Contact Info -->
            <div class="gap-5 mb-3">
                <div class="fw-bold text-center edu-qld-beginner">
                    <a href="mailto:<?php echo $con['email']; ?>" class="text-white text-decoration-none">
                        <i class="fas fa-envelope pe-2"></i><?php echo $con['email']; ?>
                    </a>
                </div>
                <div class="fw-bold text-center edu-qld-beginner">
                    <a href="tel:<?php echo $con['mobile']; ?>" class="text-white text-decoration-none">
                        <i class="fas fa-mobile-alt pe-2"></i><?php echo $con['mobile']; ?>
                    </a>
                </div>
            </div>
        </div>

    </div>

</body>

</html>