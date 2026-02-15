<?php
session_start();
require_once 'includes/db_connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT PatientID, FullName,Gender ,PasswordHash FROM Patients WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['PasswordHash'])) {
        $_SESSION['user_id'] = $user['PatientID'];
        $_SESSION['user_name'] = $user['FullName'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
include 'includes/header.php';
?>

<div style="max-width: 400px; margin: 0 auto; padding-top: 5rem;">
    <div class="glass-card">
        <h2 style="text-align: center; margin-bottom: 2rem;">Welcome Back</h2>
        
        <?php if($error): ?>
            <div style="background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
                Don't have an account? <a href="register.php" style="color: #a855f7;">Register</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
