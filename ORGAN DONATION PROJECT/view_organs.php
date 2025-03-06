<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include("db_connect.php"); // Database connection

// ✅ Fetch available organs from the donors table (Fixed Consent Condition)
$query = "SELECT donor_id, organs_donated, blood_type, health_status, availability, consent, registered_at 
          FROM donors 
          WHERE LOWER(consent) = 'approved' AND LOWER(availability) = 'available' 
          ORDER BY registered_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Organs</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial', sans-serif; }
        body {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            background-size: 400% 400%;
            animation: gradientBG 10s infinite alternate;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            width: 90%;
            max-width: 900px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        h2 { color: #333; margin-bottom: 15px; }
        .search-container { margin-bottom: 15px; }
        .search-input {
            padding: 8px; width: 90%; max-width: 400px; border: 1px solid #ccc; border-radius: 5px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: rgba(0, 123, 255, 0.1); }
        .dashboard-btn {
            display: block; padding: 12px; margin-top: 15px; background: #007bff;
            color: white; border-radius: 5px; text-decoration: none; font-size: 16px; font-weight: bold;
            transition: 0.3s;
        }
        .dashboard-btn:hover { background: #0056b3; }
        .status-available { color: green; font-weight: bold; }
        @media (max-width: 600px) { th, td { font-size: 14px; padding: 10px; } }
    </style>
</head>
<body>

    <div class="container">
        <h2><i class="fas fa-heartbeat"></i> Available Organs</h2>

        <!-- ✅ Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" onkeyup="searchTable()" placeholder="Search by organ type, blood type, or status">
        </div>

        <!-- ✅ Organ Table -->
        <table>
            <thead>
                <tr>
                    <th>Donor ID</th>
                    <th>Organ(s) Donated</th>
                    <th>Blood Type</th>
                    <th>Health Status</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['donor_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['organs_donated']); ?></td>
                            <td><?php echo htmlspecialchars($row['blood_type']); ?></td>
                            <td class="status-available"><?php echo ucfirst(htmlspecialchars($row['health_status'])); ?></td>
                            <td><?php echo date("d M Y", strtotime($row['registered_at'])); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5">No available organs found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- ✅ Back to Dashboard -->
        <a href="admin_dashboard.php" class="dashboard-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <!-- ✅ JavaScript for Search Functionality -->
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>

</body>
</html>
