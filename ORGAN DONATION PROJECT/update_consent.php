<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Donors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Animated Gradient Background */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(-45deg, #ff6b6b, #556270, #4ecdc4, #ffcc00);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Logout Icon Styling */
        .logout-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .logout-container a {
            text-decoration: none;
            color: white;
            font-size: 20px;
            background: #dc3545;
            padding: 10px 15px;
            border-radius: 50%;
            transition: 0.3s ease;
        }

        .logout-container a:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        /* Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            max-width: 90%;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            margin: 0;
            color: #333;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* Dropdowns & Inputs */
        select, input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f5f5f5;
        }

        /* Button Styling */
        button {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Logout Icon -->
    <div class="logout-container">
        <a href="admin_dashboard.php" title="Go to Dashboard">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>

    <div class="container">
        <h2>Manage Donors</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Blood Type</th>
                <th>Organs Donated</th>
                <th>Health Status</th>
                <th>Availability</th>
                <th>Consent</th>
                <th>Action</th>
            </tr>

            <?php
            session_start();
            $conn = new mysqli('localhost', 'root', '', 'organ_donation');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_donor'])) {
                $donor_id = $_POST['donor_id'];
                $blood_type = $_POST['blood_type'];
                $organs_donated = $_POST['organs_donated'];
                $health_status = $_POST['health_status'];
                $availability = $_POST['availability'];
                $consent = $_POST['consent'];

                $update_query = "UPDATE donors SET blood_type=?, organs_donated=?, health_status=?, availability=?, consent=? WHERE donor_id=?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("sssssi", $blood_type, $organs_donated, $health_status, $availability, $consent, $donor_id);

                if ($stmt->execute()) {
                    echo "<p style='color:green;'>Donor details updated successfully!</p>";
                } else {
                    echo "<p style='color:red;'>Error updating details: " . $conn->error . "</p>";
                }
            }

            $query = "SELECT donor_id, blood_type, organs_donated, health_status, availability, consent FROM donors";
            $result = $conn->query($query);

            while ($donor = $result->fetch_assoc()) { ?>
                <tr>
                    <form method="POST">
                        <td><?php echo $donor['donor_id']; ?></td>

                        <td>
                            <select name="blood_type">
                                <?php $blood_types = ["A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-"];
                                foreach ($blood_types as $type) {
                                    echo "<option value='$type' " . ($donor['blood_type'] == $type ? "selected" : "") . ">$type</option>";
                                } ?>
                            </select>
                        </td>

                        <td>
                            <select name="organs_donated">
                                <?php $organs = ["Kidney", "Liver", "Heart", "Lung", "Pancreas", "Cornea"];
                                foreach ($organs as $organ) {
                                    echo "<option value='$organ' " . ($donor['organs_donated'] == $organ ? "selected" : "") . ">$organ</option>";
                                } ?>
                            </select>
                        </td>

                        <td>
                            <select name="health_status">
                                <?php $health_status_options = ["Healthy", "Stable", "Critical"];
                                foreach ($health_status_options as $status) {
                                    echo "<option value='$status' " . ($donor['health_status'] == $status ? "selected" : "") . ">$status</option>";
                                } ?>
                            </select>
                        </td>

                        <td>
                            <select name="availability">
                                <option value="available" <?php echo ($donor['availability'] == 'available') ? "selected" : ""; ?>>Available</option>
                                <option value="unavailable" <?php echo ($donor['availability'] == 'unavailable') ? "selected" : ""; ?>>Unavailable</option>
                            </select>
                        </td>

                        <td>
                            <select name="consent">
                                <option value="pending" <?php echo ($donor['consent'] == 'pending') ? "selected" : ""; ?>>Pending</option>
                                <option value="approved" <?php echo ($donor['consent'] == 'approved') ? "selected" : ""; ?>>Approved</option>
                                <option value="rejected" <?php echo ($donor['consent'] == 'rejected') ? "selected" : ""; ?>>Rejected</option>
                            </select>
                        </td>

                        <td>
                            <input type="hidden" name="donor_id" value="<?php echo $donor['donor_id']; ?>">
                            <button type="submit" name="update_donor">Save</button>
                        </td>
                    </form>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
