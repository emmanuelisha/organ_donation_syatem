<?php
include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];
    
    // Fetch current status
    $query = "SELECT status FROM users WHERE user_id = $userId";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Toggle status
    $newStatus = ($row['status'] == 'active') ? 'inactive' : 'active';
    
    $updateQuery = "UPDATE users SET status = '$newStatus' WHERE user_id = $userId";
    if (mysqli_query($conn, $updateQuery)) {
        echo "User status updated to $newStatus.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>
