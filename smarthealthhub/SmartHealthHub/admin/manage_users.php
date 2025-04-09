<?php
require_once "../config/db.php";
session_start();

$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>

<h2>👥 All Users</h2>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id']; ?></td>
        <td><?= $user['name']; ?></td>
        <td><?= $user['email']; ?></td>
        <td><a href="delete_user.php?id=<?= $user['id']; ?>" onclick="return confirm('Delete user?')">❌ Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>
