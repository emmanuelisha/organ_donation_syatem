<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "organ_donation"); // Update with actual DB credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch match details and donor information
$sql = "SELECT m.*, 
               d.blood_type, 
               d.organs_donated, 
               d.health_status 
        FROM matches m
        JOIN donors d ON m.donor_id = d.donor_id
        WHERE m.recipient_id = $user_id 
        ORDER BY m.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Status</title>

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/banner3.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            width: 90%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
            overflow: auto;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-confirmed {
            color: #28a745;
            font-weight: bold;
        }
        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }
        .status-transplanted {
            color: #17a2b8;
            font-weight: bold;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-back:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2><i class="fas fa-heartbeat"></i> Match Status</h2>

        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>Match ID</th>
                    <th>Blood Type</th>
                    <th>Organ</th>
                    <th>Health Status</th>
                    <th>Hospital</th>
                    <th>Transplant Date</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['match_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['blood_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['organ']); ?></td>
                        <td><?php echo htmlspecialchars($row['health_status']); ?></td>
                        <td><?php echo htmlspecialchars($row['hospital']); ?></td>
                        <td><?php echo $row['transplant_date'] ? htmlspecialchars($row['transplant_date']) : 'Pending'; ?></td>
                        <td class="<?php echo 'status-' . strtolower($row['match_status']); ?>">
                            <?php echo ucfirst($row['match_status']); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No matches found at the moment.</p>
        <?php } ?>

        <a href="recipient_dashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

</body>
</html>
