<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '';
$message = '';
$error = '';

$doctorName = '';
if($doctor_id) {
    $stmt = $conn->prepare("SELECT DoctorName FROM Doctors WHERE DoctorID = ?");
    $stmt->execute([$doctor_id]);
    $doc = $stmt->fetch();
    if($doc) $doctorName = $doc['DoctorName'];
}

$allDoctors = $conn->query("SELECT DoctorID, DoctorName, Specialization FROM Doctors")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_id = $_SESSION['user_id'];
    $d_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time']; // Separate inputs for better UX
    $reason = $_POST['reason'];
    
    $fullDate = $date . ' ' . $time;
    
    if (empty($d_id) || empty($date) || empty($time)) {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO Appointments (PatientID, DoctorID, AppointmentDate, AppointmentTime, Symptoms) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$p_id, $d_id, $date, $time, $reason])) {
            // Update the Patients table 'discription' attribute as requested
            $updateStmt = $conn->prepare("UPDATE Patients SET discription = ? WHERE PatientID = ?");
            $updateStmt->execute([$reason, $p_id]);
            
            $message = "Appointment booked successfully!";
        } else {
            $error = "Failed to book appointment.";
        }
    }
}

include 'includes/header.php';
?>

<div style="max-width: 600px; margin: 0 auto; padding-top: 2rem;">
    <div class="glass-card">
        <h2 style="margin-bottom: 2rem;">Book an Appointment</h2>
        
        <?php if($message): ?>
            <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                <?php echo $message; ?> <a href="dashboard.php" style="color: white; text-decoration: underline;">View Dashboard</a>
            </div>
        <?php endif; ?>

        <form action="book.php" method="POST">
            <div class="form-group">
                <label class="form-label">Select Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <option value="">-- Choose a Specialist --</option>
                    <?php foreach($allDoctors as $d): ?>
                        <option value="<?php echo $d['DoctorID']; ?>" <?php echo ($doctor_id == $d['DoctorID']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($d['DoctorName']) . " (" . htmlspecialchars($d['Specialization']) . ")"; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label class="form-label">Date</label>
                    <input type="date" name="appointment_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div>
                    <label class="form-label">Time</label>
                    <input type="time" name="appointment_time" class="form-control" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Reason for Visit</label>
                <textarea name="reason" class="form-control" rows="3" placeholder="Briefly describe your symptoms..."></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Confirm Booking</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
