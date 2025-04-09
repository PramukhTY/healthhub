<?php
require_once "../includes/auth.php";
require_once "../config/db.php";
require_once "../includes/functions.php";
require_once "../includes/navbar.php";

$userId = $_SESSION['user_id'];
$msg = "";

// Add to cart logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $medId = $_POST['medicine_id'];
    $qty = $_POST['quantity'];

    $check = $conn->prepare("SELECT stock FROM medicines WHERE id = ?");
    $check->execute([$medId]);
    $stock = $check->fetchColumn();

    if ($qty > $stock) {
        $msg = "Only $stock items left in stock!";
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, medicine_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $medId, $qty]);
        $msg = "Added to cart!";
    }
}

// Fetch all medicines
$meds = $conn->query("SELECT * FROM medicines")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>e-Medical Store</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">
    <h2>💊 e-Medical Store</h2>
    <?php if ($msg): ?><p style="color:green;"><?php echo $msg; ?></p><?php endif; ?>

    <div class="grid">
        <?php foreach ($meds as $med): ?>
            <div class="card">
                <img src="../assets/images/meds/<?php echo $med['image']; ?>" alt="Med" width="100%">
                <h3><?php echo $med['name']; ?></h3>
                <p><?php echo $med['description']; ?></p>
                <p><strong>₹<?php echo $med['price']; ?></strong></p>
                <p>Stock: <?php echo $med['stock']; ?></p>
                <form method="POST">
                    <input type="hidden" name="medicine_id" value="<?php echo $med['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $med['stock']; ?>">
                    <button name="add_to_cart">Add to Cart 🛒</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <p><a href="cart.php">🛍️ View Cart</a></p>
</div>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>
