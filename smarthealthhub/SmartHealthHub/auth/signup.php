<?php
require_once "../config/db.php";
require_once "../includes/functions.php";

$err = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = sanitizeInput($_POST['fullname']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $role = isset($_POST['role']) ? sanitizeInput($_POST['role']) : 'free';

    if (!empty($fullName) && !empty($email) && !empty($password)) {
        $hashedPass = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $err = "⚠️ Email already registered. Try logging in.";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fullName, $email, $hashedPass, $role]);

            redirect("login.php");
        }
    } else {
        $err = "❌ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Smart HealthHub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="signup-container">
        <h2>Create Your Account</h2>

        <?php if ($err): ?>
            <p style="color:red;"><?php echo $err; ?></p>
        <?php endif; ?>

        <form method="POST" class="signup-form">
            <input type="text" name="fullname" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>

            <label for="role">Choose Membership:</label>
            <select name="role" id="role" required>
                <option value="free">Free</option>
                <option value="premium">Premium</option>
            </select><br><br>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
