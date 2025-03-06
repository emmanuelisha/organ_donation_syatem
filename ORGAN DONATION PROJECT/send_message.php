<?php
session_start();

// Check if the user is logged in and is a donor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'organ_donation');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // Get the user's ID from session
$message = $_POST['message']; // Get the message from the form

// Prepare the SQL query to insert the message
$sql = "INSERT INTO messages (user_id, name, email, message, sent_on) 
        VALUES (?, ?, ?, ?, NOW())";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("isss", $user_id, $_SESSION['full_name'], $_SESSION['email'], $message);

// Execute the statement
if ($stmt->execute()) {
    // Redirect back to the dashboard page after sending the message
    header("Location: donor_dashboard.php?message_sent=true");
} else {
    // In case of error, redirect with error message
    header("Location: donor_dashboard.php?message_sent=false");
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
