<?php
include('db_conn.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $sensor_value = filter_input(INPUT_POST, 'sensor_value', FILTER_SANITIZE_STRING);
    $sensor_number = filter_input(INPUT_POST, 'sensor_number', FILTER_VALIDATE_INT);
    $sensor_ip = filter_input(INPUT_POST, 'sensor_ip', FILTER_SANITIZE_STRING);
    $parking_id = filter_input(INPUT_POST, 'parking_id', FILTER_VALIDATE_INT);
    $top = filter_input(INPUT_POST, 'top', FILTER_VALIDATE_INT);
    $left = filter_input(INPUT_POST, 'left', FILTER_VALIDATE_INT);
    $width = filter_input(INPUT_POST, 'width', FILTER_VALIDATE_INT);
    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_INT);

    // Check if all required fields are valid
    if (!$sensor_value || !$sensor_number || !$sensor_ip || !$parking_id || $top === false || $left === false || $width === false || $height === false) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Invalid or missing required fields']);
        exit;
    }

    // Fetch the sensor data from the sensor's IP
    $sensor_data = fetchSensorData($sensor_ip);
    if ($sensor_data === false) {
        // If fetching the sensor data fails, return an error
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to fetch sensor data']);
        exit;
    }

    // You can now use the fetched sensor data for your process
    // For example, using the sensor value from the fetched data:
    $sensor_value = $sensor_data['value']; // Adjust based on actual structure of the data

    try {
        // Check if the sensor already exists in the given parking_id
        $checkQuery = 'SELECT COUNT(*) FROM sensor_data WHERE sensor_number = :sensor_number AND parking_id = :parking_id';
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $checkStmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            http_response_code(409); // Conflict
            echo json_encode(['message' => 'Sensor already assigned to this parking area']);
            exit;
        }

        // Prepare the SQL query to insert sensor data
        $query = 'INSERT INTO sensor_data
            (sensor_value, sensor_number, sensor_ip, parking_id, top, `left`, width, height) 
            VALUES 
            (:sensor_value, :sensor_number, :sensor_ip, :parking_id, :top, :left, :width, :height)';
        
        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':sensor_value', $sensor_value, PDO::PARAM_STR);
        $stmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $stmt->bindParam(':sensor_ip', $sensor_ip, PDO::PARAM_STR);
        $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        $stmt->bindParam(':top', $top, PDO::PARAM_INT);
        $stmt->bindParam(':left', $left, PDO::PARAM_INT);
        $stmt->bindParam(':width', $width, PDO::PARAM_INT);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);

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

// Function to fetch sensor data from the sensor's IP
function fetchSensorData($sensor_ip) {
    $url = "http://$sensor_ip/sensor_data";  // Assuming the sensor provides data at this endpoint
    
    // Use file_get_contents to fetch the data
    $data = @file_get_contents($url);

    // Check if the request was successful
    if ($data === false) {
        // If the request fails, return a failure response
        return false;
    }

    return json_decode($data, true);  // Assuming the sensor returns JSON data
}
?>
