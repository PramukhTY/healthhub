<?php
require_once "../includes/auth.php";
require_once "../config/db.php";
require_once "../includes/functions.php";
require_once "../includes/navbar.php";

$userId = $_SESSION['user_id'];
$msg = "";

// Booking appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorId = $_POST['doctor_id'];
    $date = $_POST['date'];
    $timeSlot = $_POST['time_slot'];

    $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_id, date, time_slot) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $doctorId, $date, $timeSlot]);

    $msg = "Appointment booked successfully!";
}

// Fetch doctors
$doctors = $conn->query("SELECT * FROM doctors")->fetchAll(PDO::FETCH_ASSOC);

// User's upcoming appointments
$stmt = $conn->prepare("SELECT a.*, d.name AS doctor_name, d.specialty FROM appointments a JOIN doctors d ON a.doctor_id = d.id WHERE a.user_id = ? ORDER BY a.date ASC");
$stmt->execute([$userId]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard-container">
    <h2>🩺 Book a Doctor Appointment</h2>
    <?php if ($msg): ?>
        <p style="color: green;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Doctor:</label>
        <select name="doctor_id" required>
            <option value="">Select Doctor</option>
            <?php foreach ($doctors as $doc): ?>
                <option value="<?php echo $doc['id']; ?>">
                    <?php echo $doc['name'] . " - " . $doc['specialty']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Date:</label>
        <input type="date" name="date" required><br><br>

        <label>Time Slot:</label>
        <select name="time_slot" required>
            <option>9:00 AM - 10:00 AM</option>
            <option>10:00 AM - 11:00 AM</option>
            <option>11:00 AM - 12:00 PM</option>
            <option>2:00 PM - 3:00 PM</option>
            <option>3:00 PM - 4:00 PM</option>
        </select><br><br>

        <button type="submit">Book Appointment</button>
    </form>

    <h3>📅 Your Upcoming Appointments</h3>
    <?php if (count($appointments) > 0): ?>
        <ul>
        <?php foreach ($appointments as $app): ?>
            <li>
                <strong><?php echo $app['doctor_name']; ?></strong> (<?php echo $app['specialty']; ?>) <br>
                Date: <?php echo $app['date']; ?> | Time: <?php echo $app['time_slot']; ?> | Status: <?php echo $app['status']; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No appointments yet.</p>
    <?php endif; ?>
</div>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>
