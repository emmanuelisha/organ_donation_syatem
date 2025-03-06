<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include("db_connect.php");

// Fetch current admin data
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin WHERE id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Process form submission to update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Ensure password is hashed

    // Update admin data
    $update_query = "UPDATE admin SET username = '$new_username', password = '$hashed_password' WHERE id = '$admin_id'";
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['admin_name'] = $new_username; // Update session with new username
        echo "<script>alert('Profile updated successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again later.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin Profile</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Same styling as the original dashboard page */
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

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            width: 85%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .update-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .update-btn:hover {
            background: #0056b3;
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
    </style>
</head>
<body>

    <a href="admin_dashboard.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>

    <div class="form-container">
        <h2>Edit Profile</h2>
        <form action="edit_admin_profile.php" method="POST">
            <input type="text" name="username" placeholder="New Username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
            <input type="password" name="password" placeholder="New Password" required>
            <button type="submit" class="update-btn">Update Profile</button>
        </form>
    </div>

</body>
</html>
