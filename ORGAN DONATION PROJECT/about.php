<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Organ Transplant System</title>

    <!-- ✅ Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url('images/banner4.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card i {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .card h3 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }

        .contact-info p {
            font-size: 14px;
            color: #333;
        }

        .dashboard-btn {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }

        .dashboard-btn:hover {
            background: #0056b3;
        }

        @media (max-width: 600px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <i class="fas fa-hands-helping"></i>
            <h3>Our Mission</h3>
            <p>We aim to simplify organ donation and transplantation by connecting donors, recipients, and healthcare professionals through an efficient, transparent, and secure system.</p>
        </div>

        <div class="card">
            <i class="fas fa-hospital"></i>
            <h3>How It Works</h3>
            <p>Our platform allows donors to register, tracks available organs in real-time, and helps match them with recipients based on compatibility and urgency.</p>
        </div>

        <div class="card">
            <i class="fas fa-shield-alt"></i>
            <h3>Why Choose Us?</h3>
            <p>✔ Secure data management<br>✔ AI-powered donor-recipient matching<br>✔ Fast and reliable system.</p>
        </div>

        <div class="card">
            <i class="fas fa-phone-alt"></i>
            <h3>Contact Us</h3>
            <p>Email: support@organsystem.com</p>
            <p>Phone: +254 797 339 041</p>
        </div>
    </div>

    <a href="index.php" class="dashboard-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>

</body>
</html>
