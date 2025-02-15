<?php
include('db_conn.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $sensor_value = filter_input(INPUT_POST, 'sensor_value', FILTER_SANITIZE_STRING);
    $sensor_id = filter_input(INPUT_POST, 'sensor_id', FILTER_VALIDATE_INT);
    $parking_id = filter_input(INPUT_POST, 'parking_id', FILTER_VALIDATE_INT);
    $top = filter_input(INPUT_POST, 'top', FILTER_VALIDATE_INT);
    $left = filter_input(INPUT_POST, 'left', FILTER_VALIDATE_INT);
    $width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_INT);
    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);

    // Check if all required fields are valid
    if (!$sensor_value || !$sensor_id || !$parking_id || $top === false || $left === false || $width === false || $height === false) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Invalid or missing required fields']);
        exit;
    }

    try {
        //Check if the sensor already exists in any parking_id
        $checkQuery = 'SELECT COUNT(*) FROM sensor_data WHERE id = :sensor_id AND parking_id IS NOT NULL';
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':sensor_id', $sensor_id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            http_response_code(409); // Conflict
            echo json_encode(['message' => 'Sensor already assigned to another parking area']);
            exit;
        }

        // Prepare the SQL query to insert sensor data
        $query = 'UPDATE sensor_data SET parking_id = :parking_id WHERE id = :sensor_id';
        
        $stmt = $conn->prepare($query);

        // Bind the parameters
        //$stmt->bindParam(':sensor_value', $sensor_value, PDO::PARAM_STR);
        $stmt->bindParam(':sensor_id', $sensor_id, PDO::PARAM_INT);
        $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        //$stmt->bindParam(':top', $top, PDO::PARAM_INT);
        //$stmt->bindParam(':left', $left, PDO::PARAM_INT);
        //$stmt->bindParam(':width', $width, PDO::PARAM_INT);
        //$stmt->bindParam(':height', $height, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Return success response
        http_response_code(201); // Created
        echo json_encode(['message' => 'Sensor added successfully']);
    } catch (PDOException $e) {
        // Log the error and return a generic message
        error_log("Database Error: " . $e->getMessage());
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'An error occurred. Please try again later.']);
    }
} else {
    // Return error if the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Invalid request method']);
}
?>
