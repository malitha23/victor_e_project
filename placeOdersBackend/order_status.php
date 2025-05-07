

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Title -->
        <title>Your Shopping Cart – Review & Update Your Items</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/images/logo/favicon.png">
        <!-- Include SweetAlert2 CSS and JS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <style>
        /* Modal Container */
        .modal {
            display: none;
            position: fixed;
            z-index: 20;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            animation: fadeIn 0.3s ease;
        }

        /* Modal Content */
        .modal-content {
            background-color: #ffffff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            animation: slideDown 0.4s ease;
        }

        /* Header */
        .modal-header {
            padding: 10px;
            color: #fff;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .close-btn {
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
            background: transparent;
            border: none;
            outline: none;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #cccccc;
        }

        /* Body */
        .modal-body {
            padding: 20px;
            color: #333;
            font-size: 16px;
            text-align: center;
            line-height: 1.6;
        }

        /* Footer */
        .modal-footer {
            padding: 10px;
            color: rgb(223, 222, 222);
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Success and Error Styles */
        .success {
            background-color: #4CAF50;
            color: #fff;
        }

        .error {
            background-color: #F44336;
            color: #fff;
        }

        /* Icon */
        .status-icon {
            font-size: 60px;
            margin-bottom: 10px;
        }

        .success-icon {
            color: #4CAF50;
        }

        .error-icon {
            color: #F44336;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-30px);
            }

            to {
                transform: translateY(0);
            }
        }

        /* Loader Overlay */
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 30;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader {
            width: 48px;
            height: 48px;
            border: 5px solid #FF3D00;
            border-top-color: transparent;
            border-radius: 50%;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 480px) {
            .modal-content {
                width: 95%;
            }
        }
    </style>
  <script>
    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const orderId = urlParams.get('orderId'); // Get 'orderId' parameter
        const status = urlParams.get('status'); // Get 'status' parameter

        if (orderId && status) {
            var message = status === 'success' 
                ? `Order #${orderId} was successful!` 
                : `Order #${orderId} failed. Please try again.`;
            openModal(message, status);
        }
    };
</script>


</head>

<body>

    <!-- Loader -->
    <div id="loaderOverlay" class="loader-overlay" style="display: none;">
        <div id="loader" class="loader"></div>
    </div>

    <!-- Modal -->
    <div id="orderModal" class="modal">
        <div id="modalContent" class="modal-content">
            <!-- Header -->
            <div id="modalHeader" class="modal-header">
                <span id="modalTitle">Order Status</span>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>

            <!-- Body -->
            <div id="modalBody" class="modal-body">
                <i id="modalIcon" class="fa status-icon" aria-hidden="true"></i>
                <p id="modalMessage"></p>
            </div>

            <!-- Footer -->
            <div id="modalFooter" class="modal-footer">
                Thank you for your order!
            </div>
        </div>
    </div>

    <script>
        function openModal(message, status) {
            document.getElementById('loaderOverlay').style.display = 'flex';
            
            const modal = document.getElementById("orderModal");
            const modalHeader = document.getElementById("modalHeader");
            const modalContent = document.getElementById("modalContent");
            const modalIcon = document.getElementById("modalIcon");
            const modalTitle = document.getElementById("modalTitle");
            const modalMessage = document.getElementById("modalMessage");

            // Reset previous state
            modalHeader.classList.remove('success', 'error');
            modalContent.classList.remove('success', 'error');
            modalIcon.classList.remove('fa-check-circle', 'fa-times-circle', 'success-icon', 'error-icon');

            setTimeout(() => {
                document.getElementById('loaderOverlay').style.display = 'none';
                if (status === 'success') {
                modalHeader.classList.add('success');
                modalContent.classList.add('success');
                modalIcon.classList.add('fa-check-circle', 'success-icon');
                modalTitle.innerText = 'Payment Successful';
            } else {
                modalHeader.classList.add('error');
                modalContent.classList.add('error');
                modalIcon.classList.add('fa-times-circle', 'error-icon');
                modalTitle.innerText = 'Payment Failed';
            }

            modalMessage.innerText = message;
            modal.style.display = "block";
            }, 2000);
          
        }

        function closeModal() {
            document.getElementById("orderModal").style.display = "none";
        }

        // Close modal on outside click
        window.onclick = function (event) {
            const modal = document.getElementById("orderModal");
            if (event.target === modal) {
                closeModal();
            }
        };

      
    </script>
</body>

</html>
