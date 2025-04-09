<?php
require_once "../includes/auth.php";
require_once "../config/db.php";
require_once "../includes/functions.php";
require_once "../includes/navbar.php";

$userId = $_SESSION['user_id'];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $conn->beginTransaction();

    try {
        // Step 1: Insert into orders table
        $total = $_POST['total_amount'];
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
        $stmt->execute([$userId, $total]);
        $orderId = $conn->lastInsertId();

        // Step 2: Fetch cart items
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cartItems as $item) {
            // Step 3: Get medicine price
            $med = $conn->prepare("SELECT price, stock FROM medicines WHERE id = ?");
            $med->execute([$item['medicine_id']]);
            $medicine = $med->fetch();

            if ($medicine['stock'] < $item['quantity']) {
                throw new Exception("Insufficient stock for one or more items.");
            }

            // Step 4: Insert into order_items
            $price = $medicine['price'];
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, medicine_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$orderId, $item['medicine_id'], $item['quantity'], $price]);

            // Step 5: Reduce stock
            $stmt = $conn->prepare("UPDATE medicines SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$item['quantity'], $item['medicine_id']]);
        }

        // Step 6: Clear user's cart
        $conn->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$userId]);

        $conn->commit();
        $success = true;

    } catch (Exception $e) {
        $conn->rollBack();
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>💳 Checkout</h2>

    <?php if ($success): ?>
        <p style="color:green;">✅ Order placed successfully! Thank you for shopping with us.</p>
        <a href="orders.php">📦 View Your Orders</a>
    <?php else: ?>
        <p>Something went wrong or you're accessing checkout directly.</p>
        <a href="cart.php">← Back to Cart</a>
    <?php endif; ?>
</div>
<?php require_once "../includes/footer.php"; ?>
</body>
</html>
