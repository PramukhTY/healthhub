<?php
session_start();
require_once "../config/db.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    try {
        // Start transaction
        $conn->beginTransaction();

        // Step 1: Delete from order_items (via orders)
        $orderStmt = $conn->prepare("SELECT id FROM orders WHERE user_id = ?");
        $orderStmt->execute([$userId]);
        $orderIds = $orderStmt->fetchAll(PDO::FETCH_COLUMN);

        if ($orderIds) {
            $placeholders = rtrim(str_repeat('?,', count($orderIds)), ',');
            $conn->prepare("DELETE FROM order_items WHERE order_id IN ($placeholders)")->execute($orderIds);
        }

        // Step 2: Delete from orders
        $conn->prepare("DELETE FROM orders WHERE user_id = ?")->execute([$userId]);

        // Step 3: Delete from appointments
        $conn->prepare("DELETE FROM appointments WHERE user_id = ?")->execute([$userId]);

        // Step 4: Delete from cart
        $conn->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$userId]);

        // Optional: Delete from other user-related tables like `prescriptions`, `feedback`, etc.

        // Step 5: Delete user
        $conn->prepare("DELETE FROM users WHERE id = ?")->execute([$userId]);

        // Commit transaction
        $conn->commit();

        // Redirect to manage users
        header("Location: manage_users.php");
        exit;
    } catch (Exception $e) {
        $conn->rollBack();
        echo "❌ Error deleting user: " . $e->getMessage();
    }
} else {
    echo "❌ User ID not provided!";
}
