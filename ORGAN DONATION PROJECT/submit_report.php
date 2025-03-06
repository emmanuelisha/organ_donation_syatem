<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recipient') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "organ_donation");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recipient_id = $_POST['recipient_id'];
$user_id = $_POST['user_id'];
$required_organ = $_POST['required_organ'];
$urgency_level = $_POST['urgency_level'];
$medical_condition = $_POST['medical_condition'];
$doctor_notes = $_POST['doctor_notes'];

// Insert into reports table
$sql = "INSERT INTO reports (recipient_id, user_id, required_organ, urgency_level, medical_condition, doctor_notes) 
        VALUES ('$recipient_id', '$user_id', '$required_organ', '$urgency_level', '$medical_condition', '$doctor_notes')";
$conn->query($sql);

// Update recipients table
$sql_update = "UPDATE recipients SET required_organ='$required_organ', urgency_level='$urgency_level', medical_condition='$medical_condition', doctor_notes='$doctor_notes' 
               WHERE recipient_id='$recipient_id'";
$conn->query($sql_update);

header("Location: medical_records.php");
exit();
?>
