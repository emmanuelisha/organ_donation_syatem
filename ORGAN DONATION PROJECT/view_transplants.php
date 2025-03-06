<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include("db_connect.php");

// Handle status update
if (isset($_POST['update_status'])) {
    $transplant_id = $_POST['transplant_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE transplants SET status = '$status' WHERE transplant_id = '$transplant_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating status');</script>";
    }
}

// Fetch all transplants
$transplants_result = mysqli_query($conn, "SELECT * FROM transplants");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transplants</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        select {
            padding: 5px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h2>Scheduled Transplants</h2>
    <table>
        <tr>
            <th>Transplant ID</th>
            <th>Recipient ID</th>
            <th>Organ Type</th>
            <th>Transplant Date</th>
            <th>Follow-Up Date</th>
            <th>Status</th>
            <th>Update Status</th>
            <th>Date Added</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($transplants_result)) { ?>
        <tr>
            <td><?php echo $row['transplant_id']; ?></td>
            <td><?php echo $row['recipient_id']; ?></td>
            <td><?php echo $row['organ_type']; ?></td>
            <td><?php echo $row['transplant_date']; ?></td>
            <td><?php echo $row['follow_up_date']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="transplant_id" value="<?php echo $row['transplant_id']; ?>">
                    <select name="status">
                        <option value="Scheduled" <?php if ($row['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Postponed" <?php if ($row['status'] == 'Postponed') echo 'selected'; ?>>Postponed</option>
                        <option value="Cancelled" <?php if ($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status">Update</button>
                </form>
            </td>
            <td><?php echo $row['date_added']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
