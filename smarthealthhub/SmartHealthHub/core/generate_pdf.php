<?php
require_once "../config/db.php";
require_once "../vendor/tcpdf/tcpdf.php";

$appointmentId = $_GET['appointment_id'] ?? 0;

// Get prescription details
$stmt = $conn->prepare("SELECT * FROM prescriptions WHERE appointment_id = ?");
$stmt->execute([$appointmentId]);
$prescription = $stmt->fetch();

if (!$prescription) {
    die("❌ Prescription not found!");
}

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Add content
$html = "
    <h2>Smart HealthHub - Prescription</h2>
    <p><strong>Appointment ID:</strong> {$prescription['appointment_id']}</p>
    <p><strong>Doctor ID:</strong> {$prescription['doctor_id']}</p>
    <p><strong>Patient ID:</strong> {$prescription['patient_id']}</p>
    <p><strong>Date:</strong> {$prescription['created_at']}</p>
    <hr>
    <p><strong>Notes:</strong><br>{$prescription['notes']}</p>
";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("prescription_{$appointmentId}.pdf", 'I'); // I = inline
