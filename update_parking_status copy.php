<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Status</title>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" 
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">  

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function preventBack() {
            window.history.forward();
        }
        setTimeout(preventBack, 0);
        window.onunload = function () { null; }
    </script>

    <style>

.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}
.modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    text-align: center;
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
.close:hover {
    color: black;
}

select, button {
      padding: 10px 20px;
      font-size: 18px;
      margin: 10px;
    }
    .sensor-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      position: relative;
    }
    .sensor-box {
      border: 20px solid #ccc;
      padding: 20px;
      margin: 10px;
      width: 200px;
      position: absolute;
      background-color: transparent;
    }
    .delete-button {
      position: absolute;
      top: 2px;
      right: 2px;
      color: red;
      cursor: pointer;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      text-align: center;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .close:hover {
      color: black;
    }
    .sensor-box.taken {
      border-color: #ff0000;
    }
    .sensor-box.available {
      border-color: #00ff00;
    }
    </style>
</head>

<body>

<?php
include('db_conn.php');

if (!isset($_GET['id'])) {
    die("No parking area ID provided.");
}
$id = $_GET['id'];

try {
    $query = 'SELECT * FROM `parking_area` WHERE `parking_id` = :id';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $parking_area = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parking_area) {
        die("No parking area found.");
    }

    // Fetch sensor data
    $query_sensors = 'SELECT * FROM `sensor_data`';
    $stmt_sensors1 = $conn->prepare($query_sensors);
    //$stmt_sensors->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_sensors1->execute();
    $sensors_option = $stmt_sensors1->fetchAll(PDO::FETCH_ASSOC);
    

    // Fetch sensor data
    $query_sensors = 'SELECT * FROM `sensor_data`  WHERE `parking_id` = :id';
    $stmt_sensors = $conn->prepare($query_sensors);
    $stmt_sensors->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_sensors->execute();
    $sensors = $stmt_sensors->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query Failed: " . $e->getMessage());
}
?>

<header>    
    <div class="logo-header">
        <img src="images/logo.png" alt="Logo" class="logo">
        <h1>Northwestern Mindanao State College</h1>
    </div>

    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="menu-icon">&#9776;</label>

    <nav>
        <button onclick="openModal()" class="tbtn">Add Sensor</button>
        <button onclick="openAdjustModal()" class="tbtn">Edit Sensor</button>
        <a href="admin.php" class="tbtn">Parking Area</a>
    </nav>
</header>

<div id="addSensorModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Add Sensor</h2>

      <select id="sensorSelector">
        <?php foreach ($sensors_option as $key => $sensor): ?>
            <option value="<?php echo $sensor['id']; ?>">Sensor @ <?= $sensor['sensor_ip'] ?> # <?= $sensor['sensor_number']; ?></option>
        <?php endforeach; ?>
      </select>
      <button onclick="addSensor()">Add Sensor</button>
    </div>
  </div>

  <div id="adjustModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeAdjustModal()">&times;</span>
      <h2>Edit Sensor</h2>
      <select id="adjustSensorSelector">
        <?php foreach ($sensors_option as $key => $sensor): ?>
            <option value="<?php echo $sensor['id']; ?>">Sensor @ <?= $sensor['sensor_ip'] ?> # <?= $sensor['sensor_number']; ?></option>
        <?php endforeach; ?>
      </select>
      <label for="width">Width:</label>
      <input type="number" id="width" min="50" value="200">
      <label for="height">Height:</label>
      <input type="number" id="height" min="50" value="200">
      <label for="top">Top:</label>
      <input type="number" id="top" min="0" value="0">
      <label for="left">Left:</label>
      <input type="number" id="left" min="0" value="0">
      <button onclick="adjustSensorBox()">Edit</button>
    </div>
  </div>

  <div class="sensor-container" id="sensorContainer"></div>

<div class="parking_image">
<div class="back-button">
<a href="admin.php" id="backButton" class="btn btn-primary">Back</a>
</div>
    <h2><?php echo htmlspecialchars($parking_area['name']); ?></h2>
    <p><?php echo htmlspecialchars($parking_area['description']); ?></p>

    <?php if (!empty($parking_area['image'])): ?>
        <img src="./image/<?php echo htmlspecialchars($parking_area['image']); ?>" alt="Parking Area Image">
    <?php else: ?>
        <p>No image available.</p>
    <?php endif; ?>
</div>

<!-- Sensor Container -->
<div class="sensor-container" id="sensorContainer"></div>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        const sensors = <?php echo json_encode($sensors); ?>;
        const sensorContainer = document.getElementById("sensorContainer");

        console.log(sensors)

        sensors.forEach(sensor => {
            const sensorId = sensor.id;
            const sensorNumber = sensor.sensor_number;
            const status = sensor.sensor_value;
            const width = sensor.width || 200; // Default width if missing
            const height = sensor.height || 200;
            const top = sensor.top || 0;
            const left = sensor.left || 0;
            const ip = sensor.sensor_ip;

            addSensorToUI(sensorNumber, sensorId, status, width, height, top, left,ip);

            setInterval(async () => {
                const updatedStatus = await fetchSensorData(ip,sensorNumber);
                updateSensorStatus(sensorId,sensorNumber, updatedStatus);
            }, 2000);
        });
    });

    function addSensorToUI(sensorNumber, sensorId, status, width = 200, height = 200, top = 0, left = 0,ip) {
        const sensorContainer = document.getElementById("sensorContainer");

        if (document.getElementById(`sensor-${sensorId}`)) return; // Avoid duplicates

        const sensorBox = document.createElement("div");
        sensorBox.id = `sensor-${sensorId}`;
        sensorBox.className = "sensor-box";
        sensorBox.style.width = `${width}px`;
        sensorBox.style.height = `${height}px`;
        sensorBox.style.top = `${top}px`;
        sensorBox.style.left = `${left}px`;

        sensorBox.innerHTML = `
            <h3> ${sensorNumber}</h3>
            <p> ${status}</p>
            <button class="delete-button" onclick="deleteSensor(${sensorId})">×</button>
        `;

        sensorContainer.appendChild(sensorBox);
        setInterval(async () => {
            const updatedStatus = await fetchSensorData(ip,sensorNumber);
            updateSensorStatus(sensorId, sensorNumber, updatedStatus);
        }, 2000);
    }



    function openModal() {
        document.getElementById("addSensorModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("addSensorModal").style.display = "none";
    }

    function openAdjustModal() {
        document.getElementById("adjustModal").style.display = "block";
    }

    function closeAdjustModal() {
        document.getElementById("adjustModal").style.display = "none";
    }

    async function fetchSensorData(ip,sensorNumber) {
        try {
            const response = await fetch(`http://${ip}/data?sensor=${sensorNumber}`);
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            return data.status.toLowerCase();
        } catch (error) {
            console.error(`Error fetching data for Sensor ${sensorNumber}:`, error);
            return "unknown";
        }
    }

    async function addSensor() {
        const sensorId = document.getElementById("sensorSelector").value;

        if (document.getElementById(`sensor-${sensorId}`)) {
            alert(`Sensor ${sensorId} is already added.`);
            return;
        }

        const urlParams = new URLSearchParams(window.location.search);
        const parkingId = urlParams.get('id'); 

        // Check if the sensor exists in another parking_id
        // const checkResponse = await fetch("fetch_sensors.php", {
        //     method: "POST",
        //     headers: { "Content-Type": "application/x-www-form-urlencoded" },
        //     body: `sensor_number=${sensorId}&parking_id=${parkingId}`
        // });

        // const checkData = await checkResponse.json();
        // if (checkData.exists) {
        //     alert(`Sensor ${sensorId} is already assigned to another parking area.`);
        //     return;
        // }

        const status = await fetchSensorData(sensorId);
        

        // Corrected fetch request
        fetch("add_sensor.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `sensor_value=${status}&sensor_id=${sensorId}&parking_id=${parkingId}&top=0&left=0&width=200&height=200`
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            if(data.message != "Sensor already assigned to another parking area") {
                alert("Sensor added successfully!");
                window.location.reload()
            }

        })
        .catch(error => console.error("Error saving sensor:", error));

        closeModal();
    }

    async function addSensor1() {
        const sensorId = document.getElementById("sensorSelector").value;
        const sensorIp = document.getElementById("sensorIpSelector").value; // Assuming you have an IP input or dropdown

        if (document.getElementById(`sensor-${sensorId}`)) {
            alert(`Sensor ${sensorId} is already added.`);
            return;
        }

        const urlParams = new URLSearchParams(window.location.search);
        const parkingId = urlParams.get('id'); 

        // Check if the sensor exists in another parking_id
        const checkResponse = await fetch("fetch_sensors.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `sensor_number=${sensorId}&parking_id=${parkingId}`
        });

        const checkData = await checkResponse.json();
        if (checkData.exists) {
            alert(`Sensor ${sensorId} is already assigned to another parking area.`);
            return;
        }

        const status = await fetchSensorData(sensorIp, sensorId); // Fetch status from the IP

        // Send the data to the database
        fetch("add_sensor.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `sensor_value=${status}&sensor_number=${sensorId}&sensor_ip=${sensorIp}&parking_id=${parkingId}&top=0&left=0&width=200&height=200`
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            alert("Sensor added successfully!");
        })
        .catch(error => console.error("Error saving sensor:", error));

        closeModal();
    }



    function addSensorToUIold(sensorId, status) {
        const sensorContainer = document.getElementById("sensorContainer");

        // Avoid adding the same sensor more than once
        if (document.getElementById(`sensor-${sensorId}`)) return;

        const sensorBox = document.createElement("div");
        sensorBox.id = `sensor-${sensorId}`;
        sensorBox.className = "sensor-box";
        sensorBox.style.width = "200px";  // Default width
        sensorBox.style.height = "200px"; // Default height
        sensorBox.style.top = "0px";      // Default top position
        sensorBox.style.left = "0px";     // Default left position
        sensorBox.innerHTML = `
            <h3>Sensor ${sensorId}</h3>
            <p>Status: ${status}</p>
            <button class="delete-button" onclick="deleteSensor(${sensorId})">×</button>
        `;

        if (status === "taken") {
            sensorBox.classList.add("taken");
        } else if (status === "available") {
            sensorBox.classList.add("available");
        }

        sensorContainer.appendChild(sensorBox);

        setInterval(async () => {
            const updatedStatus = await fetchSensorData(sensorId);
            updateSensorStatus(sensorId, updatedStatus);
        }, 2000);
    }

    function updateSensorStatus(sensorId, sensorNumber, status) {
        const sensorBox = document.getElementById(`sensor-${sensorId}`);
        if (!sensorBox) return;

        sensorBox.innerHTML = `
            <h3> ${sensorNumber}</h3>
            <p> ${status}</p>
            <button class="delete-button" onclick="deleteSensor(${sensorId})">×</button>
        `;

        sensorBox.classList.remove("taken", "available", "unknown");
        if (status === "taken") {
            sensorBox.classList.add("taken");
        } else if (status === "available") {
            sensorBox.classList.add("available");
        } else {
            sensorBox.classList.add("unknown");
        }
    }

    function openAdjustModalForSensor(sensorId) {
        document.getElementById("adjustSensorSelector").value = sensorId;
        const sensorBox = document.getElementById(`sensor-${sensorId}`);
        if (sensorBox) {
            document.getElementById("width").value = sensorBox.offsetWidth;
            document.getElementById("height").value = sensorBox.offsetHeight;
            document.getElementById("top").value = sensorBox.offsetTop;
            document.getElementById("left").value = sensorBox.offsetLeft;
        }
        openAdjustModal();
    }

    async function adjustSensorBox() {
    const sensorId = document.getElementById("adjustSensorSelector").value;
    const width = document.getElementById("width").value;
    const height = document.getElementById("height").value;
    const top = document.getElementById("top").value;
    const left = document.getElementById("left").value;

    const urlParams = new URLSearchParams(window.location.search);
    const parkingId = urlParams.get('id');

    // Check if the sensor belongs to the current parking_id
    // const checkResponse = await fetch("fetch_sensors.php", {
    //     method: "POST",
    //     headers: { "Content-Type": "application/x-www-form-urlencoded" },
    //     body: `sensor_number=${sensorId}&parking_id=${parkingId}`
    // });

    // const checkData = await checkResponse.json();
    // if (checkData.exists === false) {
    //     alert("This sensor is assigned to another parking area and cannot be moved.");
    //     return;
    // }

    await fetch("sensor_position.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `sensor_id=${sensorId}&width=${width}&height=${height}&top=${top}&left=${left}&parking_id=${parkingId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            console.log(data.message);
            alert("Sensor position updated successfully!");
        }
    })
    .catch(error => console.error("Error updating sensor position:", error));

    closeAdjustModal();
}



    async function deleteSensor(sensorId) {
        const sensorBox = document.getElementById(`sensor-${sensorId}`);
        if (sensorBox) {
            sensorBox.remove();
            await fetch("remove_sensor.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `sensor_id=${sensorId}`
            }).then(response => response.json())
                .then(data => console.log(data.message))
                .catch(error => console.error("Error deleting sensor:", error));
        }
    }



</script>


<?php include 'footer.php'; ?>

</body>
</html>
