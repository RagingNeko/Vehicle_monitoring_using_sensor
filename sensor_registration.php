<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {

include "db_conn.php";
include 'php/User.php';
$user = getUserById($_SESSION['id'], $conn);
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
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
</head>


<body>
<?php if ($user) { ?>
<?php include('db_conn.php'); ?>


<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-car'></i>
        <span class="text">AdminHub</span>
    </a>

    
    <ul class="side-menu top">
        <!--
        <li class="active">
            <a href="dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        -->

        <!-- Parking Areas Link -->
        <li>
            <a href="admin.php">
                <i class='bx bxs-parking'></i>
                <span class="text">Parking Areas</span>
            </a>
        </li>

        <li>
            <a href="sensor_registration.php">
                <i class='bx bxs-registered'></i>
                <span class="text">Register Sensor</span>
            </a>
        </li>

      <!--   <li>
           <a href="contact.php">
                <i class='bx bxs-message-dots'></i>
                <span class="text">Message</span>
            </a>
        </li>-->
    </ul>

    <ul class="side-menu">
      <!--    <li>
            <a href="#">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>-->
        <li>
            <a href="logout.php" class="logout">
                <i class='bx bx-exit'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>
<!-- SIDEBAR -->


	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
		<!--	<a href="#" class="nav-link">Categories</a> -->
        <form action="sensor_registration.php" method="get">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>

			<input type="checkbox" id="switch-mode" hidden> 
			<label for="switch-mode" class="switch-mode"></label>
			<!--<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>-->
			<a href="home.php" class="profile">
				<img src="images/admin.png">
			</a>
		</nav>
		<!-- NAVBAR -->

        <div class="container mt-10">


        <div class="box1">
        <h2>SENSORS</h2>
            <button class ="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> Register</button>
            </div>

        <div class="container">
        
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th>Sensor_ID</th>
                <th>Sensor_ip</th>
                <th>Sensor_Number</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            </thead>

<tbody>

            <?php
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Get the search query
$query = "SELECT * FROM sensor_data";

if (!empty($search)) {
    // Add WHERE clause if search input is provided
    $query .= " WHERE id LIKE :search 
                OR sensor_ip LIKE :search 
                OR sensor_number LIKE :search ";
               // Ensure 'number' is a valid column

    $stmt = $conn->prepare($query); // Prepare the query
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR); // Bind search value
} else {
    $stmt = $conn->prepare($query); // Prepare query without search filter
}

// Execute query
$stmt->execute();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['sensor_number']); ?></td>
            <td><?php echo htmlspecialchars($row['sensor_ip']); ?></td>
            <td><a href="update_sensor_ip.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-success">Update</a></td>
            <td><a href="delete_sensor.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger">Delete</a></td>
        </tr>
        <?php
    }
    // Show search result message
    if (!empty($search)) {
        echo "<h6>Showing results for: <strong>" . htmlspecialchars($search) . "</strong></h6>";
    }
} else {
    echo "<h6>No results found for: <strong>" . htmlspecialchars($search) . "</strong></h6>";
}
?>

        </tbody>
    </table>
</div>
    
<?php

if(isset($_GET['message'])){
    echo "<h6>" .$_GET['message']."</h6>";
}
?>

<?php

if(isset($_GET['insert_msg'])){
echo "<h6>" .$_GET['insert_msg']."</h6>";
}
?>

<?php

if(isset($_GET['update_msg'])){
echo "<h6>" .$_GET['update_msg']."</h6>";
}
?>

<?php

if(isset($_GET['delete_msg'])){
echo "<h6>" .$_GET['delete_msg']."</h6>";
}
?>

        <!-- Modal -->
        <form action="register_sensor.php" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Register Sensor</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

<div class="form-group">
        <label for="sensor_ip" class="form-label">Sensor IP Address:</label>
        <input type="text" id="sensor_ip" name="sensor_ip" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="sensor_number" class="form-label">Sensor Number:</label>
        <input type="number" id="sensor_number" name="sensor_number" class="form-control" required>
    </div>
    </div>
    <div class="modal-footer">
            <button type="submit" class="btn btn-success">Register</button>
                     </div>
                 </div> 
            </div> 
        </div> 
    </form>

</div>


<script src="admin.js"></script>

<?php }else { 
     header("Location: login.php");
     exit;
    } ?>


<?php }else {
	header("Location: login.php");
	exit;
} ?>

</body>
<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>