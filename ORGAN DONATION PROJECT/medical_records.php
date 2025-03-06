<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recipient') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "organ_donation"); // Update with actual DB details
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch recipient details
$sql_recipient = "SELECT * FROM recipients WHERE user_id = $user_id";
$result_recipient = $conn->query($sql_recipient);
$recipient = $result_recipient->fetch_assoc();

if (!$recipient) {
    die("Recipient details not found.");
}

$recipient_id = $recipient['recipient_id'];
$required_organ = $recipient['required_organ'];
$urgency_level = $recipient['urgency_level'];
$medical_condition = $recipient['medical_condition'];
$doctor_notes = $recipient['doctor_notes'];

// Fetch medical reports
$sql_reports = "SELECT * FROM reports WHERE recipient_id = $recipient_id ORDER BY report_date DESC";
$result_reports = $conn->query($sql_reports);
$reports = $result_reports->fetch_all(MYSQLI_ASSOC);

// List of available organs for drop-down
$organs = ["Heart", "Kidney", "Liver", "Lungs", "Pancreas", "Small Intestine", "Cornea", "Skin", "Bone Marrow"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_name = $conn->real_escape_string($_POST['doctor_name']);
    $diagnosis = $conn->real_escape_string($_POST['diagnosis']);
    $treatment_plan = $conn->real_escape_string($_POST['treatment_plan']);
    $additional_notes = $conn->real_escape_string($_POST['additional_notes']);
    $new_required_organ = $conn->real_escape_string($_POST['required_organ']);
    $new_medical_condition = $conn->real_escape_string($_POST['medical_condition']);
    $new_urgency_level = $conn->real_escape_string($_POST['urgency_level']);
    $report_date = date("Y-m-d H:i:s");

    // Insert into reports table
    $sql_insert = "INSERT INTO reports (recipient_id, doctor_name, diagnosis, treatment_plan, additional_notes, report_date) 
                   VALUES ('$recipient_id', '$doctor_name', '$diagnosis', '$treatment_plan', '$additional_notes', '$report_date')";
    $conn->query($sql_insert);

    // Update recipients table (required_organ, medical_condition, urgency_level, doctor_notes)
    $sql_update = "UPDATE recipients 
                   SET required_organ = '$new_required_organ', 
                       medical_condition = '$new_medical_condition', 
                       urgency_level = '$new_urgency_level', 
                       doctor_notes = '$additional_notes' 
                   WHERE recipient_id = $recipient_id";
    $conn->query($sql_update);

    // Refresh the page to show the updated data
    header("Location: medical_records.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
            margin-bottom: 20px;
        }
        h2 {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background: #007bff;
            color: white;
        }
        .form-group {
            margin-bottom: 10px;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Medical Records</h2>
        <p><strong>Required Organ:</strong> <?php echo htmlspecialchars($required_organ); ?></p>
        <p><strong>Urgency Level:</strong> <?php echo htmlspecialchars($urgency_level); ?></p>
        <p><strong>Medical Condition:</strong> <?php echo htmlspecialchars($medical_condition); ?></p>
        <p><strong>Doctor's Notes:</strong> <?php echo htmlspecialchars($doctor_notes); ?></p>

        <h3>Medical Reports</h3>
        <?php if (!empty($reports)): ?>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Diagnosis</th>
                    <th>Treatment Plan</th>
                </tr>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['report_date']); ?></td>
                        <td><?php echo htmlspecialchars($report['doctor_name']); ?></td>
                        <td><?php echo htmlspecialchars($report['diagnosis']); ?></td>
                        <td><?php echo htmlspecialchars($report['treatment_plan']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No reports available.</p>
        <?php endif; ?>
    </div>

    <div class="container">
        <h3>Submit New Medical Report</h3>
        <form method="POST">
            <div class="form-group">
                <label>Doctor's Name:</label>
                <input type="text" name="doctor_name" required>
            </div>
            <div class="form-group">
                <label>Diagnosis:</label>
                <textarea name="diagnosis" required></textarea>
            </div>
            <div class="form-group">
                <label>Treatment Plan:</label>
                <textarea name="treatment_plan" required></textarea>
            </div>
            <div class="form-group">
                <label>Additional Notes:</label>
                <textarea name="additional_notes"></textarea>
            </div>
            <div class="form-group">
                <label>Required Organ:</label>
                <select name="required_organ" required>
                    <?php foreach ($organs as $organ): ?>
                        <option value="<?php echo $organ; ?>" <?php echo ($organ == $required_organ) ? "selected" : ""; ?>>
                            <?php echo $organ; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Medical Condition:</label>
                <textarea name="medical_condition" required><?php echo htmlspecialchars($medical_condition); ?></textarea>
            </div>
            <div class="form-group">
                <label>Urgency Level:</label>
                <select name="urgency_level" required>
                    <option value="Low" <?php echo ($urgency_level == "Low") ? "selected" : ""; ?>>Low</option>
                    <option value="Medium" <?php echo ($urgency_level == "Medium") ? "selected" : ""; ?>>Medium</option>
                    <option value="High" <?php echo ($urgency_level == "High") ? "selected" : ""; ?>>High</option>
                    <option value="Critical" <?php echo ($urgency_level == "Critical") ? "selected" : ""; ?>>Critical</option>
                </select>
            </div>
            <button type="submit">Submit Report</button>
        </form>
    </div>

</body>
</html>
