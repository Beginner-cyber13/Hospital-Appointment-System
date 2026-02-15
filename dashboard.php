<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $conn->query("
        UPDATE Appointments 
        SET Status = 'Confirmed' 
        WHERE Status = 'Pending' 
        AND BookingTime IS NOT NULL 
        AND DATEDIFF(MINUTE, BookingTime, GETDATE()) >= 60
    ");

    $conn->query("
        UPDATE Appointments 
        SET Status = 'Done' 
        WHERE Status IN ('Pending', 'Confirmed')
        AND (CAST(AppointmentDate AS DATETIME) + CAST(AppointmentTime AS DATETIME)) < GETDATE()
    ");
} catch (PDOException $e) {
}

$stmt = $conn->prepare("
    SELECT a.AppointmentID, a.AppointmentDate, a.AppointmentTime, a.Status, a.Symptoms, d.DoctorName, d.Specialization 
    FROM Appointments a 
    JOIN Doctors d ON a.DoctorID = d.DoctorID 
    WHERE a.PatientID = ? 
    ORDER BY a.AppointmentDate DESC, a.AppointmentTime DESC
");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();

include 'includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1>My Dashboard</h1>
    <div style="display: flex; gap: 1rem; align-items: center;">
        <?php if(isset($_GET['cancelled']) && $_GET['cancelled'] == 'success'): ?>
            <span style="color: #34d399; font-size: 0.9rem; background: rgba(52, 211, 153, 0.1); padding: 0.5rem 1rem; border-radius: 0.5rem; border: 1px solid rgba(52, 211, 153, 0.2);">
                <i class="fas fa-check-circle"></i> Appointment cancelled successfully
            </span>
        <?php endif; ?>
        <a href="book.php" class="btn btn-primary"><i class="fas fa-plus"></i> New Appointment</a>
    </div>
</div>

<div class="glass-card" style="padding: 0;">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($appointments)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem;">You have no appointments yet.</td>
                </tr>
                <?php else: ?>
                    <?php foreach($appointments as $appt): ?>
                    <?php 
                        $statusClass = 'status-pending';
                        if($appt['Status'] == 'Confirmed') $statusClass = 'status-confirmed';
                        if($appt['Status'] == 'Cancelled') $statusClass = 'status-cancelled';
                        if($appt['Status'] == 'Done') $statusClass = 'status-done';
                        
                        $dateStr = $appt['AppointmentDate'] . ' ' . $appt['AppointmentTime'];

                    ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600;"><?php echo htmlspecialchars($appt['DoctorName']); ?></div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);"><?php echo htmlspecialchars($appt['Specialization']); ?></div>
                            <?php if(!empty($appt['Symptoms'])): ?>
                                <div style="font-size: 0.75rem; color: #a855f7; margin-top: 0.4rem; padding: 0.2rem 0.5rem; background: rgba(168, 85, 247, 0.1); border-radius: 4px; display: inline-block;">
                                    <i class="fas fa-notes-medical" style="font-size: 0.7rem;"></i> <?php echo htmlspecialchars($appt['Symptoms']); ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $appt['AppointmentDate']; ?> <br>
                            <span style="color: var(--text-muted); font-size: 0.9rem;"><?php echo $appt['AppointmentTime']; ?></span>
                        </td>
                        <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo $appt['Status']; ?></span></td>
                        <td>
                            <?php 
                                if($appt['Status'] == 'Pending' || $appt['Status'] == 'Confirmed'): 
                            ?>
                                <a href="cancel_appointment.php?id=<?php echo $appt['AppointmentID']; ?>" 
                                   class="btn btn-outline" 
                                   style="padding: 0.25rem 0.75rem; font-size: 0.8rem; color: #ef4444; border-color: rgba(239,68,68,0.3); text-decoration: none;"
                                   onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                    Cancel
                                </a>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
