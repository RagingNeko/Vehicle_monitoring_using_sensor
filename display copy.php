
<?php

// Database configuration
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "arduino_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the database
$sql = "SELECT * FROM sensor_data WHERE sensor_number = ". $_GET['area'] ." ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of the most recent row
    
    $row = $result->fetch_assoc();
    $response = array(
        'sensor_value' => $row["sensor_value"]
    );

    echo json_encode($response);
} else {
    echo "no data";
}

$conn->close();
?>

