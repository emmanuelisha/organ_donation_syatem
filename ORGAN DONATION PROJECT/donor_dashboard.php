<?php
session_start();

// Check if the user is logged in and is a donor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: login.php");
    exit();
}

$full_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Guest'; // Default if not set
$avatar_path = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'avatars/default-avatar.jpg'; // Default avatar if not set

// Database connection (fix the credentials)
$conn = new mysqli('localhost', 'root', '', 'organ_donation'); // Replace with actual database details

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <!-- Include Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('images/banner3.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            background: rgba(0, 0, 0, 0.5); /* Transparent black background */
            backdrop-filter: blur(8px); /* Glass blur effect */
            padding: 20px;
            width: 300px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .card h2 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #007bff;
            margin-bottom: 15px;
        }

        .card a {
            display: block;
            padding: 14px;
            margin-top: 15px;
            background-color: rgb(21, 37, 54);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
        }

        .card a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .card .logout-btn {
            background-color: #dc3545;
        }

        .card .logout-btn:hover {
            background-color: #c82333;
        }

        .message-card {
            width: 600px;
            padding: 20px;
            background: rgba(0, 123, 255, 0.5);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            color: white;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
        }

        .message-card textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .message-card button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .message-card button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Donor Dashboard Card -->
        <div class="card">
            <h2><i class="fas fa-hand-holding-medical"></i> Donor Dashboard</h2>
            <p>Welcome, <strong><?php echo htmlspecialchars($full_name); ?></strong></p>

            <a href="donate_organ.php" class="donate-btn">
                <i class="fas fa-donate"></i> Donate an Organ
            </a>
            
            <a href="donation_history.php" class="history-btn">
                <i class="fas fa-history"></i> Donation History
            </a>

            <!-- Removed Profile Update link -->
            <a href="index.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <!-- Message Card -->
        <div class="message-card">
            <h2><i class="fas fa-comment-dots"></i> Send a Message to Admin</h2>
            <form action="send_message.php" method="POST">
                <textarea name="message" placeholder="Enter your message here..."></textarea>
                <button type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
            </form>
        </div>
    </div>

</body>
</html>
