<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check admin login
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($password === $row['password']) {  // Check plain text password (change later to password_verify)
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body style="font-family: Arial, sans-serif; background: url('images/banner3.jpg') no-repeat center center fixed; background-size: cover; display: flex; justify-content: center; align-items: center; height: 100vh;">

    <div style="background: rgba(255, 255, 255, 0.95); padding: 30px; width: 400px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.2); text-align: center;">
        <h2 style="color: #007bff;"><i class="fas fa-user-shield"></i> Admin Login</h2>

        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required style="width: 90%; padding: 10px; margin: 10px 0;">
            <input type="password" name="password" placeholder="Password" required style="width: 90%; padding: 10px; margin: 10px 0;">
            <button type="submit" style="background: #28a745; color: white; padding: 10px; width: 100%; border-radius: 5px; border: none;">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>

</body>
</html>
