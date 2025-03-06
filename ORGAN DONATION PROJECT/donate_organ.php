<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php"); // Ensure database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id']; // Ensure user_id is an integer
$message = "";

// Step 1: Check if user is registered as a donor
$check_donor = $conn->prepare("SELECT donor_id, organs_donated FROM donors WHERE user_id = ?");
$check_donor->bind_param("i", $user_id);
$check_donor->execute();
$result_donor = $check_donor->get_result();

if ($result_donor->num_rows == 0) {
    die("<div class='alert alert-danger'>Error: You are not registered as a donor.</div>");
} else {
    $row = $result_donor->fetch_assoc();
    $donor_id = $row['donor_id']; 
    $existing_organs = $row['organs_donated']; // Get current organs donated
}

// Step 2: Process organ update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_organ = trim($_POST['organ']);

    if (!empty($new_organ)) {
        // Append the new organ to existing ones (if not empty)
        if (!empty($existing_organs)) {
            $updated_organs = $existing_organs . ", " . $new_organ;
        } else {
            $updated_organs = $new_organ;
        }

        // Update the donors table
        $update_query = $conn->prepare("UPDATE donors SET organs_donated = ? WHERE donor_id = ?");
        $update_query->bind_param("si", $updated_organs, $donor_id);

        if ($update_query->execute()) {
            $message = "<div class='alert alert-success'>Donation updated successfully! New organs list: <b>$updated_organs</b></div>";
        } else {
            $message = "<div class='alert alert-danger'>Error updating donation.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please select a valid organ.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Organ Donation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-image: url('images/banner7.jpg'); /* Ensure the image is in the same directory or provide full path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-container {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for readability */
            border-radius: 10px;
        }
        .logout-icon {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <!-- Logout icon -->
        <a href="donor_dashboard.php" class="logout-icon"><i class="fas fa-sign-out-alt fa-2x"></i></a>

        <!-- Card to center the content -->
        <div class="card p-4 shadow">
            <h2 class="text-center">Update Organ Donation</h2>
            <?php echo $message; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="organ" class="form-label">Select Organ to Donate:</label>
                    <select class="form-select" name="organ" required>
                        <option value="" disabled selected>Select an organ</option>
                        <option value="Heart"><i class="fas fa-heart"></i> Heart</option>
                        <option value="Kidney"><i class="fas fa-kidney"></i> Kidney</option>
                        <option value="Liver"><i class="fas fa-lungs"></i> Liver</option>
                        <option value="Lungs"><i class="fas fa-lungs"></i> Lungs</option>
                        <option value="Pancreas"><i class="fas fa-cogs"></i> Pancreas</option>
                        <option value="Cornea"><i class="fas fa-eye"></i> Cornea</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Donation</button>
            </form>
        </div>
    </div>
</body>
</html>
