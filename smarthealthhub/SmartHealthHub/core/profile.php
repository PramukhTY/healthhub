<?php
session_start();
require_once "../config/db.php";
require_once "../includes/auth.php";

$userId = $_SESSION['user_id'];

// Handle upgrade to premium
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upgrade'])) {
    $stmt = $conn->prepare("UPDATE users SET role = 'premium' WHERE id = ?");
    $stmt->execute([$userId]);
    $_SESSION['user_role'] = 'premium'; // update session
    header("Location: profile.php?upgraded=1");
    exit;
}

// Fetch user info
$stmt = $conn->prepare("SELECT full_name, email, role, created_at FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile - Smart HealthHub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include "../includes/navbar.php"; ?>

<div class="dashboard-container">
    <h2>👤 Your Profile</h2>

    <?php if (isset($_GET['upgraded'])): ?>
        <p class="success">🎉 You have successfully upgraded to Premium!</p>
    <?php endif; ?>

    <table>
        <tr><th>Full Name</th><td><?= htmlspecialchars($user['full_name']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
        <tr><th>Member Since</th><td><?= htmlspecialchars($user['created_at']) ?></td></tr>
        <tr><th>Plan</th><td><?= ucfirst($user['role']) ?></td></tr>
    </table>

    <?php if ($user['role'] === 'free'): ?>
        <form method="post">
            <p>⚠️ You're currently on the <strong>Free</strong> plan. Upgrade to enjoy premium benefits!</p>
            <button type="submit" name="upgrade">Upgrade to Premium</button>
        </form>
    <?php else: ?>
        <p>💎 You're a valued <strong>Premium</strong> member. Enjoy all features!</p>
    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
