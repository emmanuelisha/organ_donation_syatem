<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include("db_connect.php"); // Ensure database connection

// Check if the status and user_id are set from the form
if (isset($_POST['status']) && isset($_POST['user_id'])) {
    $status = $_POST['status'];
    $user_id = $_POST['user_id'];

    // Sanitize inputs to prevent SQL injection
    $status = mysqli_real_escape_string($conn, $status);
    $user_id = mysqli_real_escape_string($conn, $user_id);

    // Update the status in the database
    $query = "UPDATE users SET status='$status' WHERE user_id='$user_id'";

    if (mysqli_query($conn, $query)) {
        // Redirect back to the page where users are listed after successful status update
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
