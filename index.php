<?php 
session_start();
include 'includes/header.php'; 
?>

<section class="hero">
    <h1>Healthcare Reimagined.</h1>
    <p>Experience the future of medical care with our streamlined appointment management system. Fast, secure, and always available.</p>
    
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="register.php" class="btn btn-primary">Get Started <i class="fas fa-arrow-right"></i></a>
        <a href="doctors.php" class="btn btn-outline">Find a Doctor</a>
    </div>
</section>

<section class="features" style="margin-top: 5rem;">
    <div class="dashboard-grid">
        <div class="glass-card">
            <div style="font-size: 2rem; color: #a855f7; margin-bottom: 1rem;"><i class="fas fa-calendar-check"></i></div>
            <h3>Easy Booking</h3>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Schedule appointments in seconds with our intuitive calendar interface.</p>
        </div>
        <div class="glass-card">
            <div style="font-size: 2rem; color: #6366f1; margin-bottom: 1rem;"><i class="fas fa-user-md"></i></div>
            <h3>Expert Doctors</h3>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Access a network of top-tier specialists dedicated to your well-being.</p>
        </div>
        <div class="glass-card">
            <div style="font-size: 2rem; color: #3b82f6; margin-bottom: 1rem;"><i class="fas fa-shield-alt"></i></div>
            <h3>Secure Records</h3>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Your health data is encrypted and protected with enterprise-grade security.</p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
