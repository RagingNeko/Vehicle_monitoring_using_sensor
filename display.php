<?php
// Database configuration
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "auth_db";

// Validate input
$parking_id = isset($_GET['area']) ? intval($_GET['area']) : null;
$sensor_number = isset($_GET['sensor_number']) ? intval($_GET['sensor_number']) : null;

// Check if required parameters are present
if (!$parking_id || !$sensor_number) {
    echo json_encode(['error' => 'Invalid parameters.']);
    exit;
}

// Create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Prepare and execute the query using a prepared statement
$sql = "SELECT sensor_value 
        FROM sensor_data 
        WHERE parking_id = ? AND sensor_number = ? 
        ORDER BY id DESC 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $parking_id, $sensor_number);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the most recent row
    $row = $result->fetch_assoc();
    $response = [
        'sensor_value' => $row["sensor_value"]
    ];
    echo json_encode($response);
} else {
    // No data found for the given parameters
    echo "no data";
}

// Close the connection
$stmt->close();
$conn->close();
?>
