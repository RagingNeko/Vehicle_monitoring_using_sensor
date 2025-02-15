<?php
include('db_conn.php'); // Include database connection

// Check if 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: sensor_registration.php?error=Sensor ID is missing!");
    exit;
}

// Get the sensor ID from the URL
$id = $_GET['id'];

try {
    // Prepare delete query
    $query = "DELETE FROM sensor_data WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute query
    if ($stmt->execute()) {
        header("Location: sensor_registration.php?insert_msg=Sensor deleted successfully!");
        exit;
    } else {
        header("Location: sensor_registration.php?error=Failed to delete sensor.");
        exit;
    }
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    header("Location: sensor_registration.php?error=An error occurred.");
    exit;
}
?>
