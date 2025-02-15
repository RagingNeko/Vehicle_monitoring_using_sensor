<?php
include('db_conn.php');

// Get the sensor number from the request
$sensor_number = filter_input(INPUT_POST, 'sensor_number', FILTER_VALIDATE_INT);

if ($sensor_number) {
    try {
        // Query to fetch the sensor IP based on sensor number
        $query = "SELECT sensor_ip FROM sensor_data WHERE sensor_number = :sensor_number";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $stmt->execute();
        
        $sensor = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($sensor) {
            // Return the sensor IP as a response
            echo json_encode(['sensor_ip' => $sensor['sensor_ip']]);
        } else {
            // No sensor found for the given sensor number
            echo json_encode(['sensor_ip' => null]);
        }
    } catch (PDOException $e) {
        // Handle any errors
        error_log("Database Error: " . $e->getMessage());
        echo json_encode(['sensor_ip' => null]);
    }
} else {
    echo json_encode(['sensor_ip' => null]);
}
?>
