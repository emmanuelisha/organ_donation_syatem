<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db_connect.php'; // Ensure this file exists and correctly connects to the database

// Fetch total donors
$query_donors = "SELECT COUNT(*) AS total_donors FROM donors WHERE consent = 'approved'";
$result_donors = mysqli_query($conn, $query_donors);
$row_donors = mysqli_fetch_assoc($result_donors);
$total_donors = $row_donors['total_donors'] ?? 0;

// Fetch total recipients
$query_recipients = "SELECT COUNT(*) AS total_recipients FROM recipients";
$result_recipients = mysqli_query($conn, $query_recipients);
$row_recipients = mysqli_fetch_assoc($result_recipients);
$total_recipients = $row_recipients['total_recipients'] ?? 0;

// Fetch pending donors
$query_pending_donors = "SELECT COUNT(*) AS pending_donors FROM donors WHERE consent = 'pending'";
$result_pending_donors = mysqli_query($conn, $query_pending_donors);
$row_pending_donors = mysqli_fetch_assoc($result_pending_donors);
$pending_donors = $row_pending_donors['pending_donors'] ?? 0;

// Fetch pending users (awaiting approval)
$query_pending_users = "SELECT COUNT(*) AS pending_users FROM users WHERE status = 'pending'";
$result_pending_users = mysqli_query($conn, $query_pending_users);
$row_pending_users = mysqli_fetch_assoc($result_pending_users);
$pending_users = $row_pending_users['pending_users'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Statistics</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body style="font-family: Arial, sans-serif; background: url('images/banner3.jpg') no-repeat center center fixed; background-size: cover; display: flex; justify-content: center; align-items: center; height: 100vh;">

    <div style="background: rgba(255, 255, 255, 0.95); padding: 30px; width: 600px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); text-align: center;">
        <h2 style="color: #007bff;"><i class="fas fa-chart-bar"></i> System Statistics</h2>

        <div style="margin-top: 20px;">
            <p><strong>Total Approved Donors:</strong> <?php echo $total_donors; ?></p>
            <p><strong>Total Recipients:</strong> <?php echo $total_recipients; ?></p>
            <p><strong>Pending Donor Approvals:</strong> <?php echo $pending_donors; ?></p>
            <p><strong>Pending User Registrations:</strong> <?php echo $pending_users; ?></p>
        </div>

        <a href="admin_dashboard.php" style="display: block; padding: 10px; margin-top: 20px; background: #007bff; color: white; border-radius: 5px; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

</body>
</html>
