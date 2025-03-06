<?php
session_start();
include('db_connect.php'); // Include database connection

// Fetch recipients from the database
$sql = "SELECT recipient_id, user_id, required_organ, urgency_level, medical_condition, doctor_notes, registered_at FROM recipients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recipients - Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .logout-icon {
            font-size: 20px;
            color: white;
            cursor: pointer;
            transition: color 0.3s;
        }
        .logout-icon:hover {
            color: #ff4d4d;
        }
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="admin_dashboard.php">
            <i class="fas fa-user-shield"></i> Admin Panel
        </a>
        <div class="ms-auto">
            <!-- Logout Icon -->
            <a href="admin_dashboard.php" class="text-decoration-none">
                <i class="fas fa-sign-out-alt logout-icon"></i>
            </a>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container table-container">
    <h2 class="text-center"><i class="fas fa-procedures"></i> List of Recipients</h2>
    
    <!-- Recipients Table -->
    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Recipient ID</th>
                <th>User ID</th>
                <th>Required Organ</th>
                <th>Urgency Level</th>
                <th>Medical Condition</th>
                <th>Doctor Notes</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['recipient_id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['required_organ']}</td>
                        <td>{$row['urgency_level']}</td>
                        <td>{$row['medical_condition']}</td>
                        <td>{$row['doctor_notes']}</td>
                        <td>{$row['registered_at']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No recipients found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; <?php echo date("Y"); ?> Organ Donation System | Admin Panel
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
