<?php
session_start();
include('db_connect.php'); // Ensure database connection is established

// Ensure only admins can access
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle approval or rejection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $type = $_POST['type']; // Type: donor or donation

    if ($type == "donor") {
        if ($action == "approve") {
            $update_sql = "UPDATE donors SET consent = 'approved' WHERE donor_id = ?";
        } elseif ($action == "reject") {
            $update_sql = "DELETE FROM donors WHERE donor_id = ?";
        }
    } elseif ($type == "donation") {
        if ($action == "approve") {
            $update_sql = "UPDATE donors SET consent = 'approved' WHERE donor_id = ?";
        } elseif ($action == "reject") {
            $update_sql = "DELETE FROM donors WHERE donor_id = ?";
        }
    }

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch pending donors
$pending_donors_sql = "SELECT donors.donor_id, users.full_name, users.email, donors.blood_type, donors.health_status, donors.availability 
                        FROM donors 
                        JOIN users ON donors.user_id = users.user_id 
                        WHERE donors.consent = 'pending'";
$pending_donors = $conn->query($pending_donors_sql);

// Fetch pending donations
$pending_donations_sql = "SELECT donors.donor_id, users.full_name, users.email, donors.blood_type, donors.organs_donated, donors.health_status 
                          FROM donors 
                          JOIN users ON donors.user_id = users.user_id 
                          WHERE donors.consent = 'pending'";
$pending_donations = $conn->query($pending_donations_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Donations & Donors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Approve Pending Donors</h2>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Donor ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Blood Type</th>
                    <th>Health Status</th>
                    <th>Availability</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donor = $pending_donors->fetch_assoc()) { ?>
                <tr>
                    <td><?= $donor['donor_id'] ?></td>
                    <td><?= htmlspecialchars($donor['full_name']) ?></td>
                    <td><?= htmlspecialchars($donor['email']) ?></td>
                    <td><?= htmlspecialchars($donor['blood_type']) ?></td>
                    <td><?= htmlspecialchars($donor['health_status']) ?></td>
                    <td><?= htmlspecialchars($donor['availability']) ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $donor['donor_id'] ?>">
                            <input type="hidden" name="type" value="donor">
                            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2 class="text-center mt-5">Approve Pending Donations</h2>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Donor ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Blood Type</th>
                    <th>Organs Donated</th>
                    <th>Health Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donation = $pending_donations->fetch_assoc()) { ?>
                <tr>
                    <td><?= $donation['donor_id'] ?></td>
                    <td><?= htmlspecialchars($donation['full_name']) ?></td>
                    <td><?= htmlspecialchars($donation['email']) ?></td>
                    <td><?= htmlspecialchars($donation['blood_type']) ?></td>
                    <td><?= htmlspecialchars($donation['organs_donated']) ?></td>
                    <td><?= htmlspecialchars($donation['health_status']) ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $donation['donor_id'] ?>">
                            <input type="hidden" name="type" value="donation">
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
