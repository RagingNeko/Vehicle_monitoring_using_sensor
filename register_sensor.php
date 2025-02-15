<?php
include('db_conn.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $sensor_number = filter_input(INPUT_POST, 'sensor_number', FILTER_VALIDATE_INT);
    $sensor_ip = filter_input(INPUT_POST, 'sensor_ip', FILTER_SANITIZE_STRING);

    // Check if all required fields are valid
    if (!$sensor_number || !$sensor_ip) {
        header("Location: sensor_registration.php?error=Invalid or missing required fields");
        exit;
    }

    try {
        // Prepare the SQL query to insert sensor data
        $query = 'INSERT INTO sensor_data (sensor_number, sensor_ip) VALUES (:sensor_number, :sensor_ip)';
        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $stmt->bindParam(':sensor_ip', $sensor_ip, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Redirect after successful insertion
        header("Location: sensor_registration.php?insert_msg=Sensor registered successfully");
        exit;
    } catch (PDOException $e) {
        // Log the error and return a generic message
        error_log("Database Error: " . $e->getMessage());
        header("Location: sensor_registration.php?error=An error occurred. Please try again later.");
        exit;
    }
} else {
    // Redirect if the request method is not POST
    header("Location: sensor_registration.php?error=Invalid request method");
    exit;
}
?>
