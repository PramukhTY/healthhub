<?php
require_once "../includes/auth.php";
require_once "../config/db.php";
require_once "../includes/functions.php";
require_once "../includes/navbar.php";

$userId = $_SESSION['user_id'];
$msg = "";

// Update quantity
if (isset($_POST['update'])) {
    $cartId = $_POST['cart_id'];
    $newQty = $_POST['quantity'];
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$newQty, $cartId, $userId]);
    $msg = "Quantity updated!";
}

// Remove item
if (isset($_POST['remove'])) {
    $cartId = $_POST['cart_id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cartId, $userId]);
    $msg = "Item removed!";
}

// Fetch cart items
$stmt = $conn->prepare("SELECT c.id AS cart_id, m.*, c.quantity FROM cart c JOIN medicines m ON c.medicine_id = m.id WHERE c.user_id = ?");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>🛍️ Your Cart</h2>
    <?php if ($msg): ?><p style="color:green;"><?php echo $msg; ?></p><?php endif; ?>

    <?php if (count($cartItems) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Medicine</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($cartItems as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>₹<?php echo $item['price']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>">
                            <button name="update">Update</button>
                        </form>
                    </td>
                    <td>₹<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                            <button name="remove" style="color:red;">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td colspan="2">₹<?php echo number_format($total, 2); ?></td>
            </tr>
        </table>

        <br>
        <form action="checkout.php" method="POST">
            <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
            <button type="submit" name="checkout">Proceed to Checkout</button>
        </form>

    <?php else: ?>
        <p>Your cart is empty. <a href="e-medical.php">Browse Medicines</a></p>
    <?php endif; ?>
</div>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>
