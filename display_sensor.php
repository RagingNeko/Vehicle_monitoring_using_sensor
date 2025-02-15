<?php
include 'db_conn.php';

try {
    // Define the parking area ID (this can be dynamically set as needed)
    $id = 1; // Replace with the actual parking area ID, or set dynamically

    // Query to fetch sensors based on parking_area_id
    $query = "SELECT sensor_number, sensor_ip, parking_id,status
              FROM sensors
              WHERE parking_id = :id
              ORDER BY sensor_number";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $sensors = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Sensor Status</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Sensor ID</th>
                <th>Sensor IP</th>
                <th>Parking Area ID</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sensors)): ?>
                <?php foreach ($sensors as $index => $sensor): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($sensor['sensor_number']) ?></td>
                        <td><?= htmlspecialchars($sensor['sensor_ip']) ?></td>
                        <td><?= htmlspecialchars($sensor['parking_id']) ?></td>
                        <td>
                            <?php
                            if ($sensor['status'] === 'occupied') {
                                echo '<span class="badge bg-danger">Occupied</span>';
                            } elseif ($sensor['status'] === 'available') {
                                echo '<span class="badge bg-success">Available</span>';
                            } else {
                                echo '<span class="badge bg-secondary">Offline</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No sensors registered yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
