<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organ Donation Management System</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background-color:rgb(44, 124, 230);
        }

        /* Hero Section with Gradient and Blackish Overlay */
        .hero {
            background: url('images/banner.jpg') no-repeat center center/cover;
            height: 450px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .hero h1 {
            background: rgba(65, 56, 56, 0.8);
            padding: 20px;
            border-radius: 10px;
            font-size: 2.5rem;
        }

        /* Marquee Section */
        .marquee-container {
            background: linear-gradient(to left,rgb(33, 139, 51),rgb(34, 86, 230));
            color: #fff;
            padding: 3px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        /* Nav Bar Customization */
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9);
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

    </style>
</head>
<body>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-hand-holding-medical"></i> Organ Donation
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php"><i class="fas fa-info-circle"></i> About</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_login.php" title="Admin Panel">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <h1><i class="fas fa-heartbeat"></i> Give the Gift of Life - Become an Organ Donor</h1>
</div>

<!-- Marquee Section for Organ Donation Awareness -->
<div class="container mt-4">
    <div class="alert alert-info marquee-container" role="alert">
        <marquee behavior="scroll" direction="left" scrollamount="7">
            <strong>Organ Donation Saves Lives!</strong> Every 10 minutes, someone is added to the national transplant waiting list. Becoming an organ donor can help save up to 8 lives. Organ donation is a simple and selfless act that can give hope to patients in need of a transplant. <em>Did you know? A single organ donor can save multiple lives, including kidneys, liver, heart, and lungs.</em> Your decision to donate can make a profound difference. Register today to help those in need and become a hero. <a href="register.php" class="btn btn-success">Become a Donor</a> | <a href="learn_more.php" class="btn btn-danger">Learn More</a>
        </marquee>
    </div>
</div>

<!-- About Section -->
<div class="container mt-5">
    <h2 class="text-center"><i class="fas fa-hands-helping"></i> Welcome to the Organ Donation System</h2>
    <p class="text-center">Our platform connects donors, recipients, and hospitals to make life-saving transplants possible.</p>

    <div class="row mt-4">
        <!-- Become a Donor -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-hand-holding-medical fa-3x text-success"></i>
                    <h4 class="mt-3">Become a Donor</h4>
                    <p>Save lives by registering as an organ donor today.</p>
                    <a href="register.php" class="btn btn-success"><i class="fas fa-user-plus"></i> Register Now</a>
                </div>
            </div>
        </div>

        <!-- Find a Donor -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-search-heart fa-3x text-primary"></i>
                    <h4 class="mt-3">Find a Donor</h4>
                    <p>Looking for an organ? Register as a recipient to find a match.</p>
                    <a href="register.php" class="btn btn-primary"><i class="fas fa-search"></i> Find a Donor</a>
                </div>
            </div>
        </div>

        <!-- Organ Donation Awareness -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-ribbon fa-3x text-danger"></i>
                    <h4 class="mt-3">Organ Donation Awareness</h4>
                    <p>Learn how organ donation saves lives and how you can help.</p>
                    <a href="learn_more.php" class="btn btn-danger"><i class="fas fa-info-circle"></i> Learn More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; <?php echo date("Y"); ?> Organ Donation System | LAIKIPIA UNIVERSITY.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
