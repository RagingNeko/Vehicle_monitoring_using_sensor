<?php
include('db_conn.php');

$sensor_number = $_POST['sensor_number'] ?? null;
$parking_id = $_POST['parking_id'] ?? null;
$top = $_POST['top'] ?? null;
$left = $_POST['left'] ?? null;
$width = $_POST['width'] ?? null;
$height = $_POST['height'] ?? null;

// Validate input
if (!$sensor_number || !$parking_id || !$top || !$left || !$width || !$height) {
    header("Location: update_parking_status.php?id=$parking_id&error=Missing+parameters");
    exit;
}

$query = "UPDATE sensor_data 
          SET top = :top, `left` = :left, width = :width, height = :height 
          WHERE sensor_number = :sensor_number AND parking_id = :parking_id";

try {
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':top', $top, PDO::PARAM_INT);
    $stmt->bindParam(':left', $left, PDO::PARAM_INT);
    $stmt->bindParam(':width', $width, PDO::PARAM_INT);
    $stmt->bindParam(':height', $height, PDO::PARAM_INT);
    $stmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
    $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);

    $stmt->execute();

    // Check if the update affected any rows
    if ($stmt->rowCount() > 0) {
        header("Location: update_parking_status.php?id=$parking_id&success=Sensor+updated");
    } else {
        header("Location: update_parking_status.php?id=$parking_id&error=No+changes+made");
    }
    exit;
} catch (PDOException $e) {
    // Log the error to a file
    error_log("Sensor Update Error: " . $e->getMessage());
    header("Location: update_parking_status.php?id=$parking_id&error=Failed+to+update+sensor");
    exit;
}
?>
