<?php
session_start();
require_once "connection.php";

if (!isset($_GET['email'])) {
    die("Invalid request.");
}

$email = $_GET['email'];
$query = "SELECT c.*, p.title, p.description FROM cashond c 
          JOIN product p ON c.product_id = p.id 
          WHERE c.email = '".$email."'
          ORDER BY c.id DESC"; // optional: most recent first
$params = [$email];
$types = "s";

$orders = Database::Search($query);
if ($orders->num_rows == 0) {
    die("No orders found for this email.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cash on Delivery Invoices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .invoice-box {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        .invoice-header h2 { margin-bottom: 0; }
        .card + .card { margin-top: 20px; }
    </style>
</head>
<body>

<div class="invoice-box mt-5">
    <div class="invoice-header text-center">
        <h2>Cash on Delivery Invoices</h2>
        <p class="text-muted">Orders for <?= htmlspecialchars($email) ?></p>
    </div>

    <?php while ($order = $orders->fetch_assoc()): ?>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>Order ID:</strong> <?= htmlspecialchars($order['uniq_id']) ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($order['title']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($order['description'])) ?></p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Quantity:</strong> <?= $order['qty'] ?></li>
                    <li class="list-group-item"><strong>Price:</strong> $<?= number_format($order['price'], 2) ?></li>
                    <li class="list-group-item"><strong>Delivery Fee:</strong> $<?= number_format($order['delivery_fee'], 2) ?></li>
                    <li class="list-group-item"><strong>Total:</strong> $<?= number_format($order['totalprice'], 2) ?></li>
                    <li class="list-group-item"><strong>Discount:</strong> <?= $order['discount_pre'] ?>%</li>
                    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></li>
                    <li class="list-group-item"><strong>Status:</strong> <?= $order['cashon_status_id'] == 1 ? 'Pending' : 'Processed' ?></li>
                </ul>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
