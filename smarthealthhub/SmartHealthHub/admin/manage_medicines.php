<?php
session_start();
require_once "../config/db.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Add new medicine
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("INSERT INTO medicines (name, description, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $desc, $price, $stock]);
}

// Fetch all medicines
$meds = $conn->query("SELECT * FROM medicines")->fetchAll();
?>

<h2>💊 Manage Medicines</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Medicine Name" required><br>
    <input type="text" name="description" placeholder="Description"><br>
    <input type="number" name="price" placeholder="Price" step="0.01" required><br>
    <input type="number" name="stock" placeholder="Stock" required><br>
    <button type="submit">Add Medicine</button>
</form>

<hr>

<h3>All Medicines</h3>
<table border="1">
<tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th></tr>
<?php foreach ($meds as $med): ?>
<tr>
    <td><?= $med['id'] ?></td>
    <td><?= $med['name'] ?></td>
    <td>₹<?= $med['price'] ?></td>
    <td><?= $med['stock'] ?></td>
</tr>
<?php endforeach; ?>
</table>
