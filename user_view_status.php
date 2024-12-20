<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Status</title>
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
    
    <style>
.status-box {
    position: absolute;
    background-color: transparent;
    border: 20px solid black;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 40px;
    height: 30px;  /* Makes it thinner */
    width: 150px;  /* Adjust width as needed for the line */
    text-align: center;
    padding: 5px;
    border-radius: 5px;
    box-sizing: border-box;
}

.status-available {
    border-color: #32de84;
    color: green;
}

.status-taken {
    border-color: #fd5c63;
    color: red;
}

.status-unknown {
    border-color: gray;
    color: white;
}

</style>
</head>

<header>    
    <div class="logo-header">
    <img src="images/logo.png" alt="Logo" class="logo">
    <h1>  Northwestern Mindanao State College </h1>
</div>

        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>

        <nav>
        <a href="login.php" class="tbtn">Admin</a>
        <a href="about_us.php" class="tbtn">about</a>
        <a href="user_parking.php" class="tbtn">Parking Area</a>
    </nav>
</header>


<body>
<?php
include('db_conn.php');

// Check if the 'id' parameter exists in the GET request
if (!isset($_GET['id'])) {
    die("No parking area ID provided.");
}
$id = $_GET['id'];

try {
    // Query 1: Fetch parking area details
    $query = 'SELECT * FROM `parking_area` WHERE `parking_id` = :id';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $parking_area = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parking_area) {
        die("No parking area found with the provided ID.");
    }
    
    // Query 2: Fetch sensor data
    $query2 = "SELECT * FROM sensor_data WHERE parking_id = :id GROUP BY sensor_number, parking_id";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt2->execute();
    $list_sensors = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    if (empty($list_sensors)) {
        echo "No sensor data found.";
    }

} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
?>

<!-- Sensor Data Display -->
<div class="parking_image">

    <!-- Back button 
    <div class="back-button">
        <a href="user_parking.php" class="btn btn-secondary">Back</a>
    </div>-->

    <?php if (!empty($list_sensors)): ?>
    <?php foreach ($list_sensors as $sensor): ?>
        <!-- Status Box -->
        <div 
            id="status-box-<?php echo htmlspecialchars($sensor['sensor_number']); ?>" 
            class="status-box status-unknown"
            style="position: absolute; top: <?php echo htmlspecialchars($sensor['top']); ?>px; left: <?php echo htmlspecialchars($sensor['left']); ?>px; width: <?php echo htmlspecialchars($sensor['width']); ?>px; height: <?php echo htmlspecialchars($sensor['height']); ?>px;">
            Loading...
        </div>
    <?php endforeach; ?>

    
    <?php else: ?>
        <p>No sensor data found.</p>
    <?php endif; ?>

       
    <h2><?php echo htmlspecialchars($parking_area['name']); ?></h2>
        <p><?php echo htmlspecialchars($parking_area['description']); ?></p>

        <?php if (!empty($parking_area['image'])): ?>
            <img src="./image/<?php echo htmlspecialchars($parking_area['image']); ?>" alt="Parking Area Image">
        <?php else: ?>
            <p>No image available.</p>
        <?php endif; ?>
</div>

<?php include 'footer.php'?>

</body>
</html>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    function fetchParkingStatus(parkingArea, sn, statusBoxId) {
        $.ajax({
            url: `http://192.168.29.28:8081/arduino/display.php?area=${parkingArea}&sensor_number=${sn}`,
            type: "POST",
            success: function (response) {
                let statusBox = $(statusBoxId);

                if (response !== "no data") {
                    try {
                        response = JSON.parse(response);
                        let sensorValue = response.sensor_value.toLowerCase();

                        if (sensorValue === "available") {
                            statusBox.html("Available");
                            statusBox.removeClass('status-taken status-unknown').addClass('status-available');
                        } else if (sensorValue === "taken") {
                            statusBox.html("Taken");
                            statusBox.removeClass('status-available status-unknown').addClass('status-taken');
                        } else {
                            statusBox.html("Unknown Status");
                            statusBox.removeClass('status-available status-taken').addClass('status-unknown');
                        }
                    } catch (error) {
                        statusBox.html("Invalid Data Format");
                        statusBox.removeClass('status-available status-taken').addClass('status-unknown');
                    }
                } else {
                    statusBox.html("NO DATA");
                    statusBox.removeClass('status-available status-taken').addClass('status-unknown');
                }
            },
            error: function () {
                $(statusBoxId).html("Error: Unable to fetch data.");
                $(statusBoxId).removeClass('status-available status-taken').addClass('status-unknown');
            }
        });
    }

    setInterval(() => {
        <?php foreach ($list_sensors as $sensor): ?>
            fetchParkingStatus(<?php echo json_encode($id); ?>, <?php echo json_encode($sensor['sensor_number']); ?>, '#status-box-<?php echo htmlspecialchars($sensor['sensor_number']); ?>');
        <?php endforeach; ?>
    }, 1000);
</script>