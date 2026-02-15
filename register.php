<?php
session_start();
require_once 'includes/db_connect.php';

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $age = intval($_POST['age']);

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT PatientID FROM Patients WHERE Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email is already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO Patients (FullName, Email, ContactNumber, Gender, Age, PasswordHash) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$fullName, $email, $phone, $gender, $age, $hashed_password])) {
                $message = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong.";
            }
        }
    }
}
include 'includes/header.php';
?>

<div style="max-width: 500px; margin: 0 auto; padding-top: 3rem;">
    <div class="glass-card">
        <h2 style="text-align: center; margin-bottom: 2rem;">Create Account</h2>
        
        <?php if($error): ?>
            <div style="background: rgba(239, 68, 68, 0.2); color: #f87171; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if($message): ?>
            <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; text-align: center;">
                <?php echo $message; ?> <br> <a href="login.php" style="color: white; text-decoration: underline;">Login here</a>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="fullname" class="form-control" required placeholder="John Doe">
            </div>
            <div class="form-group">
                <label class="form-label">Gender</label>
                <div style="display: flex; gap: 1.5rem; padding: 0.5rem 0;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: white;">
                        <input type="radio" name="gender" value="Male" required style="accent-color: #a855f7;"> Male
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: white;">
                        <input type="radio" name="gender" value="Female" required style="accent-color: #a855f7;"> Female
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" required min="1" max="60" placeholder="e.g. 25">
            </div>
             <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="john@example.com">
            </div>
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="+1 234 567 8900">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Sign Up</button>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
                Already have an account? <a href="login.php" style="color: #a855f7;">Login</a>
            </p>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
