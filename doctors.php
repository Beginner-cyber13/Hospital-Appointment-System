<?php
session_start();
require_once 'includes/db_connect.php';
include 'includes/header.php';

try {
    $stmt = $conn->query("SELECT * FROM Doctors ORDER BY DoctorName ASC");
    $doctors = $stmt->fetchAll();
} catch(PDOException $e) {
    $doctors = [];
    $error = "Error fetching doctors.";
}
?>

<div class="hero" style="padding: 2rem 0; text-align: left;">
    <h1>Our Specialists</h1>
    <p style="margin: 0;">Meet our team of dedicated healthcare professionals.</p>
</div>

<div class="dashboard-grid" style="margin-top: 1rem;">
    <?php if(empty($doctors)): ?>
        <p>No doctors found or system error.</p>
    <?php else: ?>
        <?php foreach($doctors as $doctor): ?>
        <div class="glass-card">
            <div style="width: 60px; height: 60px; background: var(--secondary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">
                <?php echo strtoupper(substr($doctor['DoctorName'], 4, 1)); ?>
            </div>
            
            <h3><?php echo htmlspecialchars($doctor['DoctorName']); ?></h3>
            <p style="color: #a855f7; font-weight: 500; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($doctor['Specialization']); ?></p>
            
            <div style="background: rgba(255,255,255,0.05); padding: 0.75rem; border-radius: 0.5rem; margin: 1rem 0; font-size: 0.9rem;">
                <i class="far fa-clock" style="margin-right: 0.5rem;"></i> Available Mon-Fri
            </div>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="book.php?doctor_id=<?php echo $doctor['DoctorID']; ?>" class="btn btn-primary" style="width: 100%; text-align: center; font-size: 0.9rem;">Book Appointment</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline" style="width: 100%; text-align: center; font-size: 0.9rem;">Login to Book</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
