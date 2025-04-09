<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<h2>Welcome, Admin 👋</h2>
<ul>
    <li><a href="manage_users.php">👥 Manage Users</a></li>
    <li><a href="manage_appointments.php">📅 Manage Appointments</a></li>
    <li><a href="manage_medicines.php">💊 Manage Medicines</a></li>
    <li><a href="manage_orders.php">📦 View Orders</a></li>
    <li><a href="admin_logout.php">🚪 Logout</a></li>
</ul>
