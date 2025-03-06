<?php
include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];
    
    // Delete user query
    $query = "DELETE FROM users WHERE user_id = $userId";
    if (mysqli_query($conn, $query)) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}
?>
