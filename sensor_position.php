<?php
include('db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $sensor_ip = filter_input(INPUT_POST, 'sensor_ip', FILTER_VALIDATE_INT);
    $sensor_id = filter_input(INPUT_POST, 'sensor_id', FILTER_VALIDATE_INT);  // Use sensor_number instead of sensor_id
    $width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_INT);
    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);
    $top = filter_input(INPUT_POST, 'top', FILTER_VALIDATE_INT);
    $left = filter_input(INPUT_POST, 'left', FILTER_VALIDATE_INT);
    $parking_id = filter_input(INPUT_POST, 'parking_id', FILTER_VALIDATE_INT);

    // Check if the inputs are valid
    if (!$sensor_id || $width === false || $height === false || $top === false || $left === false || $parking_id === false) {
        echo json_encode(['error' => 'Invalid input data']);
        return;
    }

    try {
        // Check if the sensor exists in the specified parking_id
        $checkQuery = 'SELECT COUNT(*) FROM sensor_data WHERE id = :sensor_id AND parking_id = :parking_id';
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':sensor_id', $sensor_id, PDO::PARAM_INT);
        $checkStmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() == 0) {
            // Sensor does not exist for this parking area
            echo json_encode(['error' => 'Sensor not found in the specified parking area']);
            return;
        }

        // Check if the sensor is already assigned to another parking_id
        $checkQuery = 'SELECT COUNT(*) FROM sensor_data WHERE id = :sensor_id AND parking_id != :parking_id';
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':sensor_id', $sensor_id, PDO::PARAM_INT);
        $checkStmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        $checkStmt->execute();

        $existsInOtherParking = $checkStmt->fetchColumn() > 0;

        if ($existsInOtherParking) {
            // If the sensor is assigned to another parking_id, don't allow position update
            echo json_encode(['error' => 'This sensor is already assigned to another parking area and cannot be moved.']);
            return;
        }

        // Update the sensor position
        $query = 'UPDATE `sensor_data` SET `width` = :width, `height` = :height, `top` = :top, `left` = :left WHERE `id` = :sensor_id AND `parking_id` = :parking_id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':width', $width, PDO::PARAM_INT);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);
        $stmt->bindParam(':top', $top, PDO::PARAM_INT);
        $stmt->bindParam(':left', $left, PDO::PARAM_INT);
        $stmt->bindParam(':sensor_id', $sensor_id, PDO::PARAM_INT);
        $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['message' => 'Sensor position updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Failed to update sensor position: ' . $e->getMessage()]);
    }
}
?>
