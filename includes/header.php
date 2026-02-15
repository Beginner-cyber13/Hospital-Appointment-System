<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare | Modern Hospital Management</title>
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <a href="index.php" class="logo">
                    <i class="fas fa-heartbeat"></i> MediCare
                </a>
                <div class="nav-links">
                    <a href="index.php">Home</a>
                    <a href="doctors.php">Doctors</a>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php">Dashboard</a>
                        <a href="logout.php">Logout</a>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                        <a href="register.php" class="btn btn-primary" style="padding: 0.5rem 1.2rem; font-size: 0.9rem;">Register</a>
                    <?php endif; ?>
                </div>
            </nav>
        </header>
