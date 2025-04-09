<?php
require_once "../config/db.php";

// Simulate sending medicine reminder
$today = date("Y-m-d");
$currentTime = date("H:i");

$stmt = $conn->query("SELECT users.full_name, users.email, appointments.appointment_date, appointments.appointment_time
    FROM appointments
    JOIN users ON appointments.user_id = users.id
    WHERE appointment_date = '$today'");

$results = $stmt->fetchAll();

foreach ($results as $row) {
    $apptTime = date("H:i", strtotime($row['appointment_time']));
    if ($apptTime === $currentTime) {
        // Normally you'd use PHPMailer here
        echo "⏰ Reminder sent to: " . $row['email'] . " for appointment at $apptTime<br>";
    }
}
?>
