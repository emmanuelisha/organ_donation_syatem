<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recipient') {
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION['full_name'];
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "organ_donation"); // Update with actual DB details
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch notifications
$sql = "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipient Dashboard</title>

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            width: 500px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
            position: relative;
        }

        /* Notification Bell Icon */
        .notification-icon {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            cursor: pointer;
            color: #007bff;
        }
        .notification-badge {
            position: absolute;
            top: 5px;
            right: 10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 3px 6px;
            border-radius: 50%;
        }

        /* Notification Popup */
        .notification-popup {
            display: none;
            position: absolute;
            top: 40px;
            right: 15px;
            width: 300px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 10px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
        }
        .notification-popup h4 {
            margin: 0;
            padding: 10px;
            background: #007bff;
            color: white;
            text-align: center;
            border-radius: 5px 5px 0 0;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }
        .notification-item {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            text-align: left;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 style="color: #007bff;"><i class="fas fa-user-injured"></i> Recipient Dashboard</h2>
        <p>Welcome, <strong><?php echo htmlspecialchars($full_name); ?></strong></p>

        <!-- Notification Bell Icon -->
        <div class="notification-icon" id="notificationIcon">
            <i class="fas fa-bell"></i>
            <?php if (!empty($notifications)) { ?>
                <span class="notification-badge"><?php echo count($notifications); ?></span>
            <?php } ?>
        </div>

        <!-- Notification Popup -->
        <div class="notification-popup" id="notificationPopup">
            <h4>Notifications <span class="close-btn" onclick="closePopup()">&times;</span></h4>
            <?php
            if (!empty($notifications)) {
                foreach ($notifications as $notification) {
                    echo "<div class='notification-item'>" . htmlspecialchars($notification['message']) . "<br><small>" . $notification['created_at'] . "</small></div>";
                }
            } else {
                echo "<div class='notification-item'>No new notifications</div>";
            }
            ?>
        </div>

        <a href="match_status.php" style="display: block; padding: 10px; margin-top: 10px; background: #ffc107; color: white; border-radius: 5px; text-decoration: none;">
            <i class="fas fa-heartbeat"></i> Check Match Status
        </a>

        <a href="medical_records.php" style="display: block; padding: 10px; margin-top: 10px; background: #17a2b8; color: white; border-radius: 5px; text-decoration: none;">
            <i class="fas fa-file-medical"></i> View Medical Records
        </a>

        <a href="index.php" style="display: block; padding: 10px; margin-top: 10px; background: #dc3545; color: white; border-radius: 5px; text-decoration: none;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <script>
        $(document).ready(function() {
            $("#notificationIcon").click(function() {
                $("#notificationPopup").toggle();
            });
        });

        function closePopup() {
            $("#notificationPopup").hide();
        }
    </script>

</body>
</html>
