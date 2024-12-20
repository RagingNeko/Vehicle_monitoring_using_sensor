<?php
include('db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parking_id = $_POST['parking_id'];
    $sensor_number = $_POST['sensor_number'];
    $top = $_POST['top'];
    $left = $_POST['left'];
    $width = $_POST['width'];
    $height = $_POST['height'];

    try {
        $query = "INSERT INTO sensor_data (parking_id, sensor_number, top, left, width, height) 
                  VALUES (:parking_id, :sensor_number, :top, :left, :width, :height)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
        $stmt->bindParam(':sensor_number', $sensor_number, PDO::PARAM_INT);
        $stmt->bindParam(':top', $top, PDO::PARAM_INT);
        $stmt->bindParam(':left', $left, PDO::PARAM_INT);
        $stmt->bindParam(':width', $width, PDO::PARAM_INT);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);

        $stmt->execute();
        header("Location: update_parking_status.php?id=$parking_id");
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
