<?php
require_once 'db_connect.php';

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $message = "<p style='color: red; text-align: center;'>Email already exists!</p>";
    } else {
        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phone, address, role, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("ssssss", $full_name, $email, $password, $phone, $address, $role);

        if ($stmt->execute()) {
            $message = "<p style='color: green; text-align: center;'>Registration successful! Await admin approval.</p>";
        } else {
            $message = "<p style='color: red; text-align: center;'>Error: " . $conn->error . "</p>";
        }

        $stmt->close();
    }
    $checkEmail->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Organ Donation System</title>
</head>
<body style="font-family: Arial, sans-serif; background: url('images/banner2.jpg') no-repeat center center fixed; background-size: cover; display: flex; justify-content: center; align-items: center; height: 100vh;">

    <div style="background: rgba(255, 255, 255, 0.9); padding: 20px; width: 400px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #333;">User Registration</h2>
        
        <?php echo $message; ?>

        <form method="POST" action="" style="display: flex; flex-direction: column;">
            <label style="margin-bottom: 5px;">Full Name</label>
            <input type="text" name="full_name" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label style="margin-bottom: 5px;">Email</label>
            <input type="email" name="email" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label style="margin-bottom: 5px;">Password</label>
            <input type="password" name="password" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label style="margin-bottom: 5px;">Phone</label>
            <input type="text" name="phone" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label style="margin-bottom: 5px;">Address</label>
            <textarea name="address" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>

            <label style="margin-bottom: 5px;">Role</label>
            <select name="role" required style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="donor">Donor</option>
                <option value="recipient">Recipient</option>
                <option value="hospital">Hospital</option>
            </select>

            <button type="submit" style="background: #28a745; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">Register</button>
        </form>

        <p style="text-align: center; margin-top: 10px;">Already have an account? <a href="login.php">Login</a></p>
    </div>

</body>
</html>
