<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fetch Sensor Data</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin-top: 50px;
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
  <h1>Fetch Sensor Data from NodeMCU</h1>

  <button onclick="openModal()">Add Sensor</button>
  <button onclick="openAdjustModal()">Adjust Sensor Box</button>

  <div id="addSensorModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Add Sensor</h2>
      <select id="sensorSelector">
        <option value="1">Sensor 1</option>
        <option value="2">Sensor 2</option>
      </select>
      <button onclick="addSensor()">Add Sensor</button>
    </div>
  </div>

  <div id="adjustModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeAdjustModal()">&times;</span>
      <h2>Adjust Sensor Box</h2>
      <select id="adjustSensorSelector">
        <option value="1">Sensor 1</option>
        <option value="2">Sensor 2</option>
      </select>
      <label for="width">Width:</label>
      <input type="number" id="width" min="50" value="200">
      <label for="height">Height:</label>
      <input type="number" id="height" min="50" value="200">
      <label for="top">Top:</label>
      <input type="number" id="top" min="0" value="0">
      <label for="left">Left:</label>
      <input type="number" id="left" min="0" value="0">
      <button onclick="adjustSensorBox()">Adjust</button>
    </div>
  </div>

  <div class="sensor-container" id="sensorContainer"></div>

  <script>
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

    async function fetchSensorData(sensorId) {
      try {
        const response = await fetch(`http://192.168.48.100/data?sensor=${sensorId}`);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        const data = await response.json();
        return data.status.toLowerCase();
      } catch (error) {
        console.error(`Error fetching data for Sensor ${sensorId}:`, error);
        return "unknown";
      }
    }

    async function addSensor() {
      const sensorId = document.getElementById("sensorSelector").value;

      if (document.getElementById(`sensor-${sensorId}`)) {
        alert(`Sensor ${sensorId} is already added.`);
        return;
      }

      const status = await fetchSensorData(sensorId);
      addSensorToUI(sensorId, status);

      fetch("register_sensor.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `sensor_id=${sensorId}&sensor_value=${sensor_value}`
      }).then(response => response.json())
        .then(data => console.log(data.message))
        .catch(error => console.error("Error saving sensor:", error));

      closeModal();
    }

    function addSensorToUI(sensorId, status) {
      const sensorContainer = document.getElementById("sensorContainer");

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
        <button class="adjust-button" onclick="openAdjustModalForSensor(${sensorId})">Adjust</button>
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

    function updateSensorStatus(sensorId, status) {
      const sensorBox = document.getElementById(`sensor-${sensorId}`);
      if (!sensorBox) return;

      sensorBox.innerHTML = `
        <h3>Sensor ${sensorId}</h3>
        <p>Status: ${status}</p>
        <button class="delete-button" onclick="deleteSensor(${sensorId})">×</button>
        <button class="adjust-button" onclick="openAdjustModalForSensor(${sensorId})">Adjust</button>
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

      const sensorBox = document.getElementById(`sensor-${sensorId}`);
      if (sensorBox) {
        sensorBox.style.width = `${width}px`;
        sensorBox.style.height = `${height}px`;
        sensorBox.style.top = `${top}px`;
        sensorBox.style.left = `${left}px`;
      }

      fetch("fetch_sensors.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `sensor_id=${sensorId}&width=${width}&height=${height}&top=${top}&left=${left}`
      }).then(response => response.json())
        .then(data => console.log(data.message))
        .catch(error => console.error("Error updating sensor position:", error));

      closeAdjustModal();
    }

    async function deleteSensor(sensorId) {
      const sensorBox = document.getElementById(`sensor-${sensorId}`);
      if (sensorBox) {
        sensorBox.remove();
        await fetch("delete_sensor.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `sensor_id=${sensorId}`
        }).then(response => response.json())
          .then(data => console.log(data.message))
          .catch(error => console.error("Error deleting sensor:", error));
      }
    }
  </script>
</body>
</html>
