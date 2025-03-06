<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'];

include("db_connect.php"); // Database connection

// Fetch all messages with admin reply
$messages_query = "SELECT * FROM messages ORDER BY sent_on DESC";
$messages_result = mysqli_query($conn, $messages_query);

// Handle the reply
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply'])) {
    $message_id = $_POST['message_id'];
    $admin_reply = mysqli_real_escape_string($conn, $_POST['admin_reply']);

    // Update the message with the admin's reply
    $update_query = "UPDATE messages SET admin_reply = '$admin_reply' WHERE message_id = $message_id";
    if (mysqli_query($conn, $update_query)) {
        echo "Reply sent successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Messages</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Gradient background */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient from purple to blue */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            color: #333;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .message-card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 600px;
            margin: 20px auto;
        }

        .message-card h4 {
            font-size: 18px;
            color: #333;
            margin: 0;
        }

        .message-card .message-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 16px;
        }

        .message-card p {
            margin: 0;
        }

        .message-card .reply-container {
            display: flex;
            justify-content: flex-end;
        }

        .reply-btn {
            padding: 8px 15px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .reply-btn:hover {
            background: #218838;
        }

        .reply-form {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
        }

        .reply-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 16px;
            resize: vertical;
        }

        .reply-form button {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .reply-form button:hover {
            background: #0056b3;
        }

        /* Styling for the back button */
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            transition: 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        /* Icon Style */
        .fa {
            margin-right: 8px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Messages</h2>

        <?php while($message = mysqli_fetch_assoc($messages_result)): ?>
        <div class="message-card">
            <h4>From: <?php echo htmlspecialchars($message['name']); ?> (<?php echo htmlspecialchars($message['email']); ?>)</h4>

            <div class="message-details">
                <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($message['message'])); ?></p>

                <?php if ($message['admin_reply']): ?>
                    <p><strong>Admin Reply:</strong> <?php echo nl2br(htmlspecialchars($message['admin_reply'])); ?></p>
                <?php else: ?>
                    <!-- Reply Form -->
                    <form method="POST" class="reply-form">
                        <input type="hidden" name="message_id" value="<?php echo $message['message_id']; ?>" />
                        <textarea name="admin_reply" placeholder="Write your reply..." required></textarea>
                        <button type="submit" name="reply"><i class="fa fa-paper-plane"></i> Send Reply</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>

        <a href="admin_dashboard.php" class="back-btn"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
    </div>

</body>
</html>
