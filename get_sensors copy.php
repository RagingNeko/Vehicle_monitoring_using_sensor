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
    .sensor-data {
      font-size: 24px;
      margin: 20px;
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
    }
    .sensor-box {
      border: 1px solid #ccc;
      padding: 20px;
      margin: 10px;
      width: 200px;
      position: relative;
    }
    .delete-button {
      position: absolute;
      top: 2px;
      right: 2px;
      color: red;
      cursor: pointer;
    }
    /* Modal styles */
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
  </style>
</head>
<body>
  <h1>Fetch Sensor Data from NodeMCU</h1>
  
  <!-- Button to open the modal -->
  <button onclick="openModal()">Add Sensor</button>

  <!-- Modal structure -->
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

  <!-- Container to display sensor data -->
  <div class="sensor-container" id="sensorContainer">
    <!-- Sensor data will be dynamically added here -->
  </div>

  <script>
    // Function to open the modal
    function openModal() {
      document.getElementById("addSensorModal").style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
      document.getElementById("addSensorModal").style.display = "none";
    }

    // Function to fetch data for a specific sensor
    async function fetchSensorData(sensorId, elementId) {
      try {
        const response = await fetch(`http://192.168.48.100/data?sensor=${sensorId}`); // Replace with your NodeMCU IP
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();

        // Update the webpage with fetched sensor data
        document.getElementById(elementId).innerHTML = `
          <h3> ${sensorId}</h3>
          <p> ${data.status}</p>
          <button class="delete-button" onclick="deleteSensor('${elementId}')">×</button>
        `;
      } catch (error) {
        console.error(`Error fetching data for Sensor ${sensorId}:`, error);
      }
    }

    // Function to add a sensor to the display
    function addSensor() {
      const sensorId = document.getElementById("sensorSelector").value;
      const sensorContainer = document.getElementById("sensorContainer");

      // Check if the sensor is already displayed
      if (document.getElementById(`sensor-${sensorId}`)) {
        alert(`Sensor ${sensorId} is already added.`);
        return;
      }

      // Create a new div for the sensor data
      const sensorBox = document.createElement("div");
      sensorBox.id = `sensor-${sensorId}`;
      sensorBox.className = "sensor-box";
      sensorBox.innerHTML = `
        <h3>Sensor ${sensorId}</h3>
        <p>: Loading...</p>
        <button class="delete-button" onclick="deleteSensor('sensor-${sensorId}')">×</button>
      `;
      sensorContainer.appendChild(sensorBox);

      // Fetch data for the selected sensor
      fetchSensorData(sensorId, `sensor-${sensorId}`);

      // Update the sensor data every 2 seconds
      setInterval(() => fetchSensorData(sensorId, `sensor-${sensorId}`), 2000);

      // Close the modal after adding the sensor
      closeModal();
    }

    // Function to delete a sensor from the display
    function deleteSensor(elementId) {
      const sensorBox = document.getElementById(elementId);
      if (sensorBox) {
        sensorBox.remove(); // Remove the sensor box from the DOM
      }
    }
  </script>
</body>
</html>