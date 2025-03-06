<?php
include 'db_connect.php'; // Ensure this file contains your database connection code

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if (mysqli_query($conn, $sql)) {
        $success_msg = "Message sent successfully!";
    } else {
        $error_msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/banner5.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }
        /* Logout Button */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 20px;
            background: none;
            border: none;
            cursor: pointer;
            color: white;
        }
        .logout-btn:hover {
            color: #ff4747;
        }
        .contact-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
        }
        .contact-container h2 {
            color: #007bff;
            margin-bottom: 15px;
        }
        .contact-container input, .contact-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .contact-container button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .contact-container button:hover {
            background: #218838;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <!-- Logout Icon -->
    <a href="index.php" class="logout-btn" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
    </a>

    <div class="contact-container">
        <h2><i class="fas fa-envelope"></i> Contact Us</h2>

        <!-- Success/Error Message -->
        <?php if (isset($success_msg)) echo "<div class='message success'>$success_msg</div>"; ?>
        <?php if (isset($error_msg)) echo "<div class='message error'>$error_msg</div>"; ?>

        <form action="contact.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="4" placeholder="Your Message" required></textarea>
            <button type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
        </form>
    </div>

</body>
</html>
