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
$sensor_id = $_POST['sensor_id']; // Unique sensor ID
$sensor_value = $_POST['status']; // Sensor status (e.g., "Available" or "Taken")
$area = $_POST['area']; // Area ID

// Prepare and execute SQL query with a prepared statement
$sql = "INSERT INTO sensor_data (sensor_id, sensor_value, parking_id) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
        sensor_value = VALUES(sensor_value), 
        parking_id = VALUES(parking_id)";

$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind parameters to the prepared statement
    $stmt->bind_param("ssi", $sensor_id, $sensor_value, $area);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted/updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
