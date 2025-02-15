<?php
include('db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sensor_id = $_POST['sensor_id'];

    try {
        $query = "UPDATE sensor_data SET parking_id = NULL WHERE id = :sensor_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sensor_id', $sensor_id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(["success" => true, "message" => "Sensor deleted successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}
?>
