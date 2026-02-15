<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];


    $stmt = $conn->prepare("
        UPDATE Appointments 
        SET Status = 'Cancelled' 
        WHERE AppointmentID = ? AND PatientID = ? AND Status IN ('Pending', 'Confirmed')
    ");
    
    if ($stmt->execute([$appointment_id, $user_id])) {
        header("Location: dashboard.php?cancelled=success");
        exit;
    } else {
        header("Location: dashboard.php?cancelled=error");
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
