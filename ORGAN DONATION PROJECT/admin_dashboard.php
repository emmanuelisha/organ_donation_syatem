<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'];

include("db_connect.php");

// Fetch system statistics
$recipients_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM recipients"))[0];
$donors_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM donors"))[0];
$organs_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM organs WHERE status = 'available'"))[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: url('images/banner3.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            padding-top: 80px;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            width: 85%;
            max-width: 1200px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            background: linear-gradient(45deg, #007bff, #00c6ff, #007bff);
            background-size: 200% 200%;
            animation: gradientAnimation 5s ease infinite;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            color: white;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .card i {
            font-size: 40px;
            color: white;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 22px;
            margin: 10px 0;
        }

        .card p {
            font-size: 18px;
        }

        .dashboard-btn, .donate-btn {
            display: block;
            padding: 12px;
            margin-top: 15px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
            border: 1px solid white;
        }

        .dashboard-btn:hover, .donate-btn:hover {
            background: white;
            color: #007bff;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #dc3545;
            padding: 10px 15px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .cards-container {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>

    <a href="index.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>

    <div class="dashboard-container">
        <h2><i class="fas fa-user-shield"></i> Admin Dashboard</h2>

        <!-- Profile Card -->
        <div class="card">
            <i class="fas fa-user-circle"></i>
            <h3>Admin Profile</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($admin_name); ?></p>
            <p><strong>Role:</strong> Administrator</p>
            <a href="edit_admin_profile.php" class="dashboard-btn">Edit Profile</a>
        </div>

        <div class="cards-container">
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Recipients</h3>
                <p><?php echo $recipients_count; ?> Registered</p>
                <a href="view_recipients.php" class="dashboard-btn">View Recipients</a>
            </div>

            <div class="card">
                <i class="fas fa-user-plus"></i>
                <h3>Donors</h3>
                <p><?php echo $donors_count; ?> Registered</p>
                <a href="view_donors.php" class="dashboard-btn">View Donors</a>
            </div>

            <div class="card">
                <i class="fas fa-heartbeat"></i>
                <h3>Available Organs</h3>
                <p><?php echo $organs_count; ?> Organs</p>
                <a href="view_organs.php" class="dashboard-btn">View Organs</a>
            </div>

            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>Transplant Operations</h3>
                <p>Manage transplant operations</p>
                <a href="view_transplants.php" class="dashboard-btn">View Transplants</a>
            </div>

            <div class="card">
                <i class="fas fa-user-md"></i>
                <h3>Schedule Operations</h3>
                <p>Plan and manage surgeries</p>
                <a href="schedule_transplant.php" class="dashboard-btn">Schedule Operations</a>
            </div>

            <div class="card">
                <i class="fas fa-user-check"></i>
                <h3>Approve Registrations</h3>
                <p>Approve new users</p>
                <a href="approve_users.php" class="dashboard-btn">Approve Users</a>
            </div>

            <div class="card">
                <i class="fas fa-envelope"></i>
                <h3>Messages</h3>
                <p>View New Messages</p>
                <a href="view_messages.php" class="dashboard-btn">View Messages</a>
            </div>

            <!-- Consent Update Card -->
            <div class="card">
                <i class="fas fa-user-shield"></i>
                <h3>Manage Donor</h3>
                <p>Manage your organ donation consent status.</p>
                <a href="update_consent.php" class="donate-btn">
                    <i class="fas fa-edit"></i> Update Consent
                </a>
            </div>
        </div>
    </div>

</body>
</html>
