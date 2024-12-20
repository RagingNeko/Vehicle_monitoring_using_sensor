<?php
// Database configuration
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "auth_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize POST data
$sensor_value = $_POST['status'];
$sensor_number = $_POST['sensor'];
$area = $_POST['area'];

// Prepare and execute SQL query
$sql = "INSERT INTO sensor_data (sensor_number,sensor_value,parking_id) VALUES (".$sensor_number.",'" . $sensor_value . "',".$area.")";
$stmt = $conn->prepare($sql);

if ($stmt->execute()) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
