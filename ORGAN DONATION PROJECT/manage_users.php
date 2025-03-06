<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'];

include("db_connect.php"); // Ensure database connection

// Fetch users data
$query = "SELECT * FROM users"; // Assuming your table is named 'users'
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* General Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f4f7fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 50px;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: left;
            margin: 20px auto;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }

        /* Logout Icon */
        .logout-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 24px;
            background-color: #dc3545;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logout-icon:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-btn {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .action-btn:hover {
            background-color: #0056b3;
        }

        .edit-btn {
            background-color: #ffc107;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .status-btn {
            background-color: #28a745;
        }

        .status-btn.deactivated {
            background-color: #dc3545;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            overflow: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 8px;
        }

        .modal-header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            float: right;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal input[type="text"], .modal input[type="email"], .modal input[type="phone"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .modal button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .modal button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Logout Icon -->
    <a href="admin_dashboard.php" class="logout-icon">
        <i class="fas fa-sign-out-alt"></i>
    </a>

    <div class="container">
        <h2><i class="fas fa-users-cog"></i> Manage Users</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='user-" . $row['user_id'] . "'>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>
                                <form method='POST' action='update_status.php'>
                                    <select name='status' onchange='this.form.submit()'>
                                        <option value='approved' " . ($row['status'] == 'approved' ? 'selected' : '') . ">Approved</option>
                                        <option value='pending' " . ($row['status'] == 'pending' ? 'selected' : '') . ">Pending</option>
                                        <option value='rejected' " . ($row['status'] == 'rejected' ? 'selected' : '') . ">rejected</option>
                                    </select>
                                    <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                </form>
                            </td>";
                        echo "<td>
                                <button class='action-btn edit-btn' onclick='openModal(" . $row['user_id'] . ", \"" . $row['full_name'] . "\", \"" . $row['email'] . "\", \"" . $row['phone'] . "\", \"" . $row['address'] . "\", \"" . $row['role'] . "\")'><i class='fas fa-pencil-alt'></i> Edit</button>
                                <button class='action-btn delete-btn' onclick='deleteUser(" . $row['user_id'] . ")'><i class='fas fa-trash-alt'></i> Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h3>Edit User Details</h3>
            </div>
            <form id="edit-form" method="POST" action="update_user.php">
                <input type="hidden" id="user-id" name="user_id">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="role">Role:</label>
                <input type="text" id="role" name="role" required>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Open the modal with the user data pre-filled
        function openModal(id, name, email, phone, address, role) {
            document.getElementById("user-id").value = id;
            document.getElementById("full_name").value = name;
            document.getElementById("email").value = email;
            document.getElementById("phone").value = phone;
            document.getElementById("address").value = address;
            document.getElementById("role").value = role;
            document.getElementById("editModal").style.display = "block";
        }

        // Close the modal
        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // Handle logout functionality
        $(".logout-icon").on("click", function() {
            window.location.href = "admin_dashboard.php";
        });

        // Add your AJAX functions for toggling status, editing users, etc.
    </script>
</body>
</html>
