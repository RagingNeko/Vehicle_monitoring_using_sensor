<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <!-- Font Awesome -->
     <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap"
      rel="stylesheet"
    />  

<!-- Bootstrap Bundle with Popper (for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function fetchSensorDetails() {
            const response = await fetch('fetch_sensors.php');
            const data = await response.text();
            document.getElementById('sensor-details').innerHTML = data;
        }

        window.onload = fetchSensorDetails;
    </script>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sensor1Id = $_POST['sensor1_id'];
    $sensor2Id = $_POST['sensor2_id'];

    // Validate and update logic
    if (is_numeric($sensor1Id) && is_numeric($sensor2Id)) {
        // Save IDs to database or configuration
        // Example: Update a table in the database
        $pdo = new PDO('mysql:host=localhost;dbname=arduino_db', 'username', 'password');
        $stmt = $pdo->prepare("UPDATE sensors SET sensor_id = ? WHERE sensor_number = ?");
        $stmt->execute([$sensor1Id, 1]); // Sensor 1
        $stmt->execute([$sensor2Id, 2]); // Sensor 2

        echo "Sensor IDs updated successfully!";
    } else {
        echo "Invalid IDs!";
    }
} else {
    echo "Invalid request method.";
}
?>

    <h1>Sensor Information</h1>
    <div id="sensor-details">Loading...</div>

    <form method="POST" action="update_sensor_ids.php">
    <label for="sensor1">Sensor 1 ID:</label>
    <input type="number" id="sensor1" name="sensor1_id" required><br>

    <label for="sensor2">Sensor 2 ID:</label>
    <input type="number" id="sensor2" name="sensor2_id" required><br>

    <button type="submit">Update Sensor IDs</button>
</form>

</body>
</html>
