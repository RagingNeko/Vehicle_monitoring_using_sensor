<?php
// Include database connection
include('db_conn.php');

// Get POST data
$sensor_number = $_POST['sensor_number'] ?? null;
$parking_id = $_POST['parking_id'] ?? null;
$top = $_POST['top'] ?? null;
$left = $_POST['left'] ?? null;
$width = $_POST['width'] ?? null;
$height = $_POST['height'] ?? null;

// Ensure required fields are present
if (!$sensor_number || !$parking_id || !$top || !$left || !$width || !$height) {
    die("Missing required parameters.");
}

// Prepare the update query
$query = "UPDATE sensor_data SET top = :top, `left` = :left, width = :width, height = :height WHERE sensor_number = :sensor_number AND parking_id = :parking_id";

try {
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':top', $top, PDO::PARAM_INT);
    $stmt->bindParam(':left', $left, PDO::PARAM_INT);
    $stmt->bindParam(':width', $width, PDO::PARAM_INT);
    $stmt->bindParam(':height', $height, PDO::PARAM_INT);
    $stmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
    $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);

    // Execute the update
    $stmt->execute();

    // Redirect back to the page to see changes
    header("Location: update_parking_status.php?id=" . $parking_id);
    exit;
} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
?>
