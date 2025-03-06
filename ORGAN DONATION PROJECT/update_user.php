<?php
include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];
    $newName = mysqli_real_escape_string($conn, $_POST['name']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newPhone = mysqli_real_escape_string($conn, $_POST['phone']);
    $newAddress = mysqli_real_escape_string($conn, $_POST['address']);
    $newRole = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Update user details query
    $query = "UPDATE users SET full_name = '$newName', email = '$newEmail', phone = '$newPhone', address = '$newAddress', role = '$newRole' WHERE user_id = $userId";
    
    if (mysqli_query($conn, $query)) {
        echo "User details updated successfully.";
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}
?>
