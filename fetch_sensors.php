<?php
$nodeMCUIp = "192.168.29.28"; // Replace with NodeMCU IP address
$nodeMCUPort = 8081; // Port used by NodeMCU

// Fetch data from NodeMCU
$url = "http://$nodeMCUIp:$nodeMCUPort/arduino/sensors";
$response = file_get_contents($url);

// Decode JSON response
$data = json_decode($response, true);

if ($data) {
    echo "<h3>NodeMCU Details</h3>";
    echo "NodeMCU IP: " . htmlspecialchars($data['nodeMCU_ip']) . "<br>";
    echo "Sensor 1 ID: " . htmlspecialchars($data['sensor_1_id']) . "<br>";
    echo "Sensor 2 ID: " . htmlspecialchars($data['sensor_2_id']) . "<br>";
} else {
    echo "Failed to fetch data from NodeMCU.";
}
?>
