<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Correct column names: users.full_name and doctors.name
$appointments = $conn->query("
    SELECT a.*, u.full_name AS patient_name, d.name AS doctor_name 
    FROM appointments a
    JOIN users u ON a.user_id = u.id
    JOIN doctors d ON a.doctor_id = d.id
    ORDER BY a.date DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">
    <h2>📅 Manage Appointments</h2>
    <table border="1">
        <tr><th>ID</th><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr>
        <?php foreach ($appointments as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['patient_name'] ?></td>
            <td><?= $a['doctor_name'] ?></td>
            <td><?= $a['date'] ?></td>
            <td><?= $a['time_slot'] ?></td>
            <td><?= $a['status'] ?? 'Pending' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
