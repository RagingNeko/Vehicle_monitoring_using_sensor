const express = require('express');
const mysql = require('mysql');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

// MySQL database connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root', // Replace with your MySQL username
  password: '', // Replace with your MySQL password
  database: 'arduino_db' // Change to 'arduino_db' to match your actual database
});

// Connect to MySQL
db.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err);
    return;
  }
  console.log('Connected to MySQL database');
});

// API to fetch all sensors
app.get('/sensors', (req, res) => {
  const query = 'SELECT * FROM sensor_data';

  db.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching sensors:', err);
      return res.status(500).json({ error: 'Failed to fetch sensors' });
    }

    res.json(results);
  });
});

// API to add a sensor
app.post('/add-sensor', (req, res) => {
  const { sensor_value, sensor_number, parking_id, top, left, width, height } = req.body;
  const query = `
    INSERT INTO sensor_data (sensor_value, sensor_number, parking_id, top, left, width, height)
    VALUES (?, ?, ?, ?, ?, ?, ?)`;

  db.query(query, [sensor_value, sensor_number, parking_id, top, left, width, height], (err, results) => {
    if (err) {
      console.error('Error adding sensor:', err);
      return res.status(500).json({ error: 'Failed to add sensor' });
    }

    res.json({ message: 'Sensor added successfully' });
  });
});

// API to update sensor position (width, height, top, left)
app.post('/update-sensor-position', (req, res) => {
  const { sensor_number, width, height, top, left } = req.body;
  const query = `
    UPDATE sensor_data
    SET width = ?, height = ?, top = ?, left = ?
    WHERE sensor_number = ?`;

  db.query(query, [width, height, top, left, sensor_number], (err, results) => {
    if (err) {
      console.error('Error updating sensor position:', err);
      return res.status(500).json({ error: 'Failed to update sensor position' });
    }

    res.json({ message: 'Sensor position updated successfully' });
  });
});

// API to delete a sensor
app.delete('/delete-sensor/:sensorId', (req, res) => {
  const sensorId = req.params.sensorId;
  const query = 'DELETE FROM sensor_data WHERE sensor_number = ?';

  db.query(query, [sensorId], (err, results) => {
    if (err) {
      console.error('Error deleting sensor:', err);
      return res.status(500).json({ error: 'Failed to delete sensor' });
    }

    res.json({ message: 'Sensor deleted successfully' });
  });
});

// Start the server
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server running on http://192.168.48.28:${PORT}`);
});
