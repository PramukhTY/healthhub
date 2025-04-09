<?php
require_once "../includes/auth.php"; // session check
require_once "../config/db.php";

// Check if a session is already active before starting a new one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Dummy motivational quotes — you can expand this
$thoughts = [
    "Stay strong, stay hopeful 💪",
    "Your health is your greatest wealth 🩺",
    "Every step counts. Keep going!",
    "Small changes make big impacts 💚",
    "You deserve care and confidence 🌟"
];

$quote = $thoughts[array_rand($thoughts)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Smart HealthHub</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include "../includes/navbar.php"; ?>

    <div class="dashboard-container">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h2>
        <p><strong>Membership:</strong> <?= ucfirst($_SESSION['user_role']) ?></p>

        <div class="thought-box">
            <h3>💬 Thought of the Day</h3>
            <p><?= $quote ?></p>
        </div>

        <div class="quick-links">
        <h3>🧭 Quick Access</h3>
        <ul>
            <li><a href="appointments.php">🩺 Book Doctor Appointment</a></li>
            <li><a href="e-medical.php">💊 e-Medical Store</a></li>
            <li><a href="chatbot_page.php">🤖 AI Chatbot</a></li>
            <li><a href="orders.php">📦 Order History</a></li>
            <li><a href="profile.php">👤 Your Profile</a></li>
        </ul>
    </div>

        <?php if ($_SESSION['user_role'] === 'free'): ?>
            <div class="upgrade-box">
                <p>⚠️ You're on a Free plan. Upgrade to <strong>Premium</strong> for 24x7 chatbot access, fast delivery, and priority appointments!</p>
                <a href="../core/profile.php" class="btn-upgrade">Upgrade Now</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include "../includes/footer.php"; ?>
</body>
</html>