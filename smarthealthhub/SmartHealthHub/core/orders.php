<?php
require_once "../includes/auth.php";
require_once "../config/db.php";
require_once "../includes/functions.php";
require_once "../includes/navbar.php";

$userId = $_SESSION['user_id'];

// Fetch all orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Orders</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">
    <h2>📦 Your Orders</h2>

    <?php if (count($orders) > 0): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <h3>🧾 Order #<?php echo $order['id']; ?> - ₹<?php echo number_format($order['total_amount'], 2); ?></h3>
                <p><strong>Placed On:</strong> <?php echo $order['order_date']; ?></p>

                <table border="1" cellpadding="8" cellspacing="0" width="100%">
                    <tr>
                        <th>Medicine</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>

                    <?php
                    $stmtItems = $conn->prepare("SELECT oi.quantity, oi.price, m.name FROM order_items oi JOIN medicines m ON oi.medicine_id = m.id WHERE oi.order_id = ?");
                    $stmtItems->execute([$order['id']]);
                    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You haven't placed any orders yet. <a href="e-medical.php">🛒 Start Shopping</a></p>
    <?php endif; ?>
</div>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>
