<?php
include('db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive the sensor position details
    $sensor_number = $_POST['sensor_id'];  // Use sensor_number instead of sensor_id
    $width = $_POST['width'];
    $height = $_POST['height'];
    $top = $_POST['top'];
    $left = $_POST['left'];
    $parking_id = $_POST['parking_id'];  // Get the parking_id where you want to update the sensor position

    try {
        // Check if the sensor is already assigned to another parking_id
        $checkQuery = 'SELECT COUNT(*) FROM sensor_data WHERE sensor_number = :sensor_number AND parking_id != :parking_id';
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $checkStmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        $checkStmt->execute();

        $existsInOtherParking = $checkStmt->fetchColumn() > 0;

        if ($existsInOtherParking) {
            // If the sensor is assigned to another parking_id, don't allow position update
            echo json_encode(['error' => 'This sensor is already assigned to another parking area and cannot be moved.']);
            return;
        }

        // Update the sensor position based on the sensor_number
        $query = 'UPDATE `sensor_data` SET `width` = :width, `height` = :height, `top` = :top, `left` = :left WHERE `sensor_number` = :sensor_number AND `parking_id` = :parking_id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':width', $width, PDO::PARAM_INT);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);
        $stmt->bindParam(':top', $top, PDO::PARAM_INT);
        $stmt->bindParam(':left', $left, PDO::PARAM_INT);
        $stmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);  // Ensure the update is for the correct parking_id
        $stmt->execute();

        echo json_encode(['message' => 'Sensor position updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Failed to update sensor position: ' . $e->getMessage()]);
    }
}
?>
