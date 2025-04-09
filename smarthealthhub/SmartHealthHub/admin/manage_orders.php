<?php
session_start();
require_once "../config/db.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Corrected 'u.name' to 'u.full_name' and 'o.created_at' to 'o.order_date'
$orders = $conn->query("
    SELECT o.*, u.full_name AS user_name 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.order_date DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">
    <h2>📦 Manage Orders</h2>
    <table border="1">
    <tr><th>ID</th><th>User</th><th>Total</th><th>Date</th></tr>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?= $order['id'] ?></td>
        <td><?= $order['user_name'] ?></td>
        <td>₹<?= number_format($order['total_amount'], 2) ?></td>
        <td><?= $order['order_date'] ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>

</body>
</html>
