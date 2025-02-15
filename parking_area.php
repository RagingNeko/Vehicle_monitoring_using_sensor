<?php
include('db_conn.php');

$parking_id = $_GET['id'] ?? null;

if ($parking_id) {
    $query = 'SELECT * FROM sensor_data WHERE parking_id = :parking_id';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':parking_id', $parking_id, PDO::PARAM_INT);
    $stmt->execute();
    $list_sensors = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="parking_image">
    <?php foreach ($list_sensors as $sensor): ?>
        <div 
            id="status-box-<?php echo $sensor['sensor_number']; ?>" 
            class="status-box status-<?php echo strtolower($sensor['status']); ?>"
            style="position: absolute; top: <?php echo $sensor['top']; ?>px; left: <?php echo $sensor['left']; ?>px; width: <?php echo $sensor['width']; ?>px; height: <?php echo $sensor['height']; ?>px;">
            <?php echo ucfirst($sensor['status']); ?>
        </div>
    <?php endforeach; ?>
</div>


<script>
    function fetchParkingStatus(parkingArea, sensorNumber, statusBoxId) {
        $.ajax({
            url: `display.php?area=${parkingArea}&sensor_number=${sensorNumber}`,
            type: "POST",
            success: function (response) {
                let statusBox = $(statusBoxId);
                if (response !== "no data") {
                    response = JSON.parse(response);
                    let sensorValue = response.sensor_value.toLowerCase();

                    if (sensorValue === "available") {
                        statusBox.html("Available").removeClass('status-taken').addClass('status-available');
                    } else if (sensorValue === "taken") {
                        statusBox.html("Taken").removeClass('status-available').addClass('status-taken');
                    }
                }
            }
        });
    }
    
    setInterval(() => {
        <?php foreach ($list_sensors as $sensor): ?>
            fetchParkingStatus(<?php echo json_encode($parking_id); ?>, <?php echo json_encode($sensor['sensor_number']); ?>, '#status-box-<?php echo htmlspecialchars($sensor['sensor_number']); ?>');
        <?php endforeach; ?>
    }, 2000);
</script>
