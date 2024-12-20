<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <script defer src="app.js"></script>
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
    <!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-car'></i>
        <span class="text">AdminHub</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <!-- Parking Areas Link -->
        <li>
            <a href="admin.php">
                <i class='bx bxs-parking'></i>
                <span class="text">Parking Areas</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class='bx bxs-group'></i>
                <span class="text">Users</span>
            </a>
        </li>

        <li>
            <a href="contact.php">
                <i class='bx bxs-message-dots'></i>
                <span class="text">Message</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu">
        <li>
            <a href="#">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>
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
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div> 
			</form>
			<input type="checkbox" id="switch-mode" hidden> 
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="home.php" class="profile">
				<img src="images/admin.png">
			</a>
		</nav>
        <div class="main-content">
        
        <div class="dashboard-cards">
            <div class="card teal">6<br>Vehicles
            <i class='bx bxs-car'></i></div>

            <div class="card yellow">10<br>Parking Areas
            <i class='bx bxs-parking'></i></div>

            <div class="card light-blue">2<br>Users
            <i class='bx bxs-group'></i></div>
            
        </div>

        <!-- Date and Time Table -->
        <div class="container mt-10">


<div class="box1">
<h2>Date and Time</h2>
    <button class ="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"> ADD</button>
    </div>

<div class="container">

<table class="table table-hover table-bordered table-striped">

            
            <table>
                <thead>
                    <tr>
                        <th>Current Date</th>
                        <th>Current Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo date("Y-m-d"); ?></td>
                        <td><?php echo date("H:i:s"); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <footer>
            <p>Data last updated: <span id="lastUpdate">Loading...</span></p>
        </footer>
    </div>
    <script src="admin.js"></script>
    
</body>
<?php include 'footer.php'?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>
