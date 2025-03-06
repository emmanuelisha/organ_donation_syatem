<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php"); // Ensure database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id']; // Ensure user_id is an integer

// Fetch donation history details
$donor_query = $conn->prepare("SELECT * FROM donors WHERE user_id = ?");
$donor_query->bind_param("i", $user_id);
$donor_query->execute();
$result_donor = $donor_query->get_result();

if ($result_donor->num_rows == 0) {
    die("<div class='alert alert-danger'>Error: You have no donation history.</div>");
} else {
    $donor = $result_donor->fetch_assoc();
}

// Format the registered date
$registered_at = date("F j, Y", strtotime($donor['registered_at']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-image: url('images/banner8.jpg'); /* Background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-container {
            max-width: 700px;
            width: 100%;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background for readability */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .logout-icon {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <!-- Logout icon -->
        <a href="donor_dashboard.php" class="logout-icon"><i class="fas fa-sign-out-alt fa-2x"></i></a>

        <!-- Card to display the donor's donation history -->
        <div class="card p-4 shadow">
            <h2 class="text-center">Donation History</h2>
            <div class="mb-3">
                <p><strong>User ID:</strong> <?php echo $donor['user_id']; ?></p>
                <p><strong>Blood Type:</strong> <?php echo $donor['blood_type']; ?></p>
                <p><strong>Organs Donated:</strong> <?php echo $donor['organs_donated']; ?></p>
                <p><strong>Health Status:</strong> <?php echo $donor['health_status']; ?></p>
                <p><strong>Availability:</strong> <?php echo $donor['availability']; ?></p>
                <p><strong>Consent:</strong> <?php echo $donor['consent']; ?></p>
                <p><strong>Registered At:</strong> <?php echo $registered_at; ?></p>
            </div>
           
        </div>
    </div>
</body>
</html>
