<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn More - Organ Donation</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background: url('images/banner6.jpg') no-repeat center center/cover;
            height: 300px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero h1 {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 10px;
        }
        .fact-card {
            border-left: 5px solid #28a745;
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .fact-card i {
            color: #28a745;
            font-size: 30px;
            margin-right: 15px;
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
                <li class="nav-item"><a class="nav-link" href="learn_more.php"><i class="fas fa-info-circle"></i> Learn More</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <h1><i class="fas fa-book-medical"></i> Learn More About Organ Donation</h1>
</div>

<!-- Facts Section -->
<div class="container mt-5">
    <h2 class="text-center"><i class="fas fa-heartbeat text-danger"></i> Health Facts About Organ Donation</h2>
    <p class="text-center">Organ donation saves lives. Here are some important facts to help you understand its impact.</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="fact-card d-flex align-items-center">
                <i class="fas fa-user-plus"></i>
                <div>
                    <h5>One Donor Can Save 8 Lives</h5>
                    <p>By donating organs, a single person can save or improve up to 8 lives.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="fact-card d-flex align-items-center">
                <i class="fas fa-lungs"></i>
                <div>
                    <h5>Organs That Can Be Donated</h5>
                    <p>Heart, lungs, liver, kidneys, pancreas, intestines, and even hands & faces can be donated.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="fact-card d-flex align-items-center">
                <i class="fas fa-hands-helping"></i>
                <div>
                    <h5>Living Donors Are Possible</h5>
                    <p>Some organs, like kidneys and part of the liver, can be donated by living donors.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="fact-card d-flex align-items-center">
                <i class="fas fa-hand-holding-heart"></i>
                <div>
                    <h5>Medical Condition Doesn't Always Matter</h5>
                    <p>Most people can donate regardless of age or medical history.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="fact-card d-flex align-items-center">
                <i class="fas fa-users"></i>
                <div>
                    <h5>Organ Shortage is a Crisis</h5>
                    <p>Thousands die every year waiting for an organ that never comes. Donors save lives!</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="fact-card d-flex align-items-center">
                <i class="fas fa-donate"></i>
                <div>
                    <h5>Religious & Cultural Acceptance</h5>
                    <p>Most major religions support organ donation as an act of kindness and saving lives.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; <?php echo date("Y"); ?> Organ Donation System | All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
