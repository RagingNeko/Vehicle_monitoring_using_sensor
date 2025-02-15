<html>
    <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Update Parking Area</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
      <title>User Dashboard</title>
      <script type="text/javascript">
          function preventBack(){window.history.forward()};
          setTimeout("preventBack()",0);
          window.onunload=function(){null;}
          </script></head>
    <body>

</head>
<?php
include('header.php');
include('db_conn.php');

// Check if 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Sensor ID is missing!");
}

// Fetch the ID from the URL and sanitize it
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid sensor ID!");
}

// Retrieve the existing data for this sensor
$query = "SELECT * FROM sensor_data WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data was retrieved
if (!$row) {
    die("Sensor not found!");
}

// Processing the form update if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_sensor_ip'])) {
    // Debugging: Check if form variables are being received
    echo "<pre>POST Data:\n";
    print_r($_POST);
    echo "</pre>";

    // Sanitize and validate input
    $sensor_ip = filter_input(INPUT_POST, 'sensor_ip', FILTER_SANITIZE_STRING);
    $sensor_number = filter_input(INPUT_POST, 'sensor_number', FILTER_VALIDATE_INT);

    // Debugging: Check sanitized variables
    echo "Sanitized Data: Sensor IP: $sensor_ip, Sensor Number: $sensor_number<br>";

    // Validate input fields
    if (!$sensor_ip || !$sensor_number) {
        die("Invalid input! Sensor IP and Sensor Number are required.");
    }

    // Update the sensor data
    $sql = "UPDATE sensor_data SET sensor_ip = ?, sensor_number = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$sensor_ip, $sensor_number, $id])) {
        // Debugging: Check if any row was updated
        if ($stmt->rowCount() > 0) {
            echo "Sensor data updated successfully!";
            header('Location: sensor_registration.php?insert_msg=Successfully updated the data');
            exit;
        } else {
            echo "No changes were made. Check if the new values are different from the old ones.";
        }
    } else {
        die("Error updating sensor data!");
    }
}
?>

<div class="sudlanan">
    <h2>Update Sensor</h2> 
  
    <form action="update_sensor_ip.php?id=<?php echo $id; ?>" method="post">
        <div class="form-group">
            <label for="sensor_ip">Sensor IP</label>
            <input type="text" name="sensor_ip" class="form-control" value="<?php echo htmlspecialchars($row['sensor_ip']); ?>" required>
        </div>
        <div class="form-group">
            <label for="sensor_number">Sensor Number</label>
            <input type="number" name="sensor_number" class="form-control" value="<?php echo htmlspecialchars($row['sensor_number']); ?>" required>
        </div>

        <input type="submit" class="btn btn-success" name="update_sensor_ip" value="Update">
        <a href="sensor_registration.php" class="btn btn-primary">Back</a>
    </form>
</div>


<?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</html>
