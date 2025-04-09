<?php
require_once "../includes/auth.php";
require_once "../config/db.php";
require_once "../includes/navbar.php";

// Sample logic for testing purpose
$appointmentId = $_GET['appointment_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("INSERT INTO prescriptions (appointment_id, doctor_id, patient_id, notes) VALUES (?, ?, ?, ?)");
    $stmt->execute([$appointmentId, $_SESSION['user_id'], $_POST['patient_id'], $notes]);

    echo "<p style='color: green;'>Prescription saved. <a href='generate_pdf.php?appointment_id=$appointmentId'>Download PDF</a></p>";
}
?>

<div class="dashboard-container">
    <h2>📝 Write Prescription</h2>
    <form method="POST">
        <input type="hidden" name="patient_id" value="1"> <!-- use real ID in production -->
        <label>Prescription Notes:</label><br>
        <textarea name="notes" rows="8" cols="50" required></textarea><br><br>
        <button type="submit">💾 Save</button>
    </form>
</div>
<?php require_once "../includes/footer.php"; ?>
