<?php
session_start();
require 'db_connect.php'; // Ensure this file connects to your database

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch recipients who need a transplant
$query = "SELECT * FROM recipients ORDER BY urgency_level DESC, registered_at ASC";
$result = $conn->query($query);

// Schedule Transplant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schedule'])) {
    $recipient_id = $_POST['recipient_id'];
    $user_id = $_POST['user_id'];
    $organ = $_POST['required_organ'];
    $surgery_date = $_POST['surgery_date'];

    // Insert into Transplant Schedule (Assuming you have a 'transplant_schedule' table)
    $stmt = $conn->prepare("INSERT INTO transplant_schedule (recipient_id, surgery_date) VALUES (?, ?)");
    $stmt->bind_param("is", $recipient_id, $surgery_date);
    if ($stmt->execute()) {
        // Send Automatic Notification
        $message = "Your transplant surgery for $organ has been scheduled on $surgery_date.";
        $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, message, status) VALUES (?, ?, 'Unread')");
        $notif_stmt->bind_param("is", $user_id, $message);
        $notif_stmt->execute();
        $notif_stmt->close();

        echo "<script>alert('Transplant scheduled successfully! Notification sent.'); window.location.href='schedule_transplant.php';</script>";
    } else {
        echo "<script>alert('Error scheduling transplant.');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Transplant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #fad0c4, #ffdde1);
            background-size: 400% 400%;
            animation: gradientBG 6s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            width: 80%;
            margin: auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #ff9a9e;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            color: white;
        }

        .schedule-btn {
            background: #28a745;
        }

        .schedule-btn:hover {
            background: #218838;
        }

        .logout {
            position: absolute;
            top: 15px;
            right: 15px;
            background: red;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .logout i {
            margin-right: 5px;
        }

        .icon {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<a href="admin_dashboard.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>

<div class="container">
    <h2><i class="fas fa-calendar-check icon"></i> Schedule Transplant Surgery</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Recipient</th>
            <th>Organ Required</th>
            <th>Urgency Level</th>
            <th>Medical Condition</th>
            <th>Doctor Notes</th>
            <th>Schedule Surgery</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['recipient_id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['required_organ']; ?></td>
            <td><?php echo $row['urgency_level']; ?></td>
            <td><?php echo $row['medical_condition']; ?></td>
            <td><?php echo $row['doctor_notes']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="recipient_id" value="<?php echo $row['recipient_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <input type="hidden" name="required_organ" value="<?php echo $row['required_organ']; ?>">
                    <input type="date" name="surgery_date" required>
                    <button type="submit" name="schedule" class="btn schedule-btn"><i class="fas fa-calendar-plus"></i> Schedule</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
