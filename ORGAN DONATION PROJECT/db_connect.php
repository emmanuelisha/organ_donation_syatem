<?php
// Database configuration
$host = "localhost";  // Change this if your database is on a remote server
$dbname = "organ_donation";
$username = "root";   // Change if you have a different MySQL username
$password = "";       // Change if your MySQL has a password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character encoding to UTF-8
$conn->set_charset("utf8");

// Uncomment this line for debugging
// echo "Connected successfully!";
?>
