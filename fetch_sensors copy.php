<?php
include('db_conn.php');

// Get the sensor number and parking ID from the request
$sensor_number = filter_input(INPUT_POST, 'sensor_number', FILTER_VALIDATE_INT);
$parking_id = filter_input(INPUT_POST, 'parking_id', FILTER_VALIDATE_INT);

if ($sensor_number && $parking_id) {
    try {
        // Check if the sensor already exists in any parking ID
        $checkQuery = 'SELECT COUNT(*) FROM sensor_data WHERE sensor_number = :sensor_number';
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $checkStmt->execute();

        $exists = $checkStmt->fetchColumn() > 0;
        echo json_encode(['exists' => $exists]);
    } catch (PDOException $e) {
        // Handle any errors
        error_log("Database Error: " . $e->getMessage());
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['exists' => false]);
}
?>
