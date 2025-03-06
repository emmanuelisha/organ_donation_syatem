<?php
session_start();
include('db_connect.php'); // Ensure this file correctly connects to the database

// Ensure only admins can access this page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Approve or Reject User
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];
    $role = $_POST['role']; // Donor or Recipient

    if ($action == "approve") {
        // Fetch user details
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($role == "donor") {
            // Insert into donors table
            $insert_sql = "INSERT INTO donors (user_id, blood_type, organs_donated, health_status, availability, consent, registered_at) 
                           VALUES (?, 'Unknown', 'None', 'Healthy', 'Available', 'Yes', NOW())";
        } elseif ($role == "recipient") {
            // Insert into recipients table
            $insert_sql = "INSERT INTO recipients (user_id, required_organ, urgency_level, medical_condition, doctor_notes, registered_at) 
                           VALUES (?, 'Unknown', 'Medium', 'Not specified', 'Pending evaluation', NOW())";
        }

        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Update user status to 'approved'
        $update_sql = "UPDATE users SET status = 'approved' WHERE user_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

    } elseif ($action == "reject") {
        // Delete user from users table
        $delete_sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch Pending Users (Donors & Recipients)
$pending_users_sql = "SELECT user_id, full_name, email, phone, role FROM users WHERE status = 'pending'";
$pending_users = $conn->query($pending_users_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Approve Pending Users</h2>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $pending_users->fetch_assoc()) { ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= ucfirst($user['role']) ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <input type="hidden" name="role" value="<?= $user['role'] ?>">
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="admin_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
