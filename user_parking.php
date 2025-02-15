<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
    <title>User Dashboard</title>
  <body>
 

    <?php include('db_conn.php'); ?>


    	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
            <i class='bx bxs-car'></i>
			<span class="text">Welcome!</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="user_parking.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
		
		<!--	<li>
				<a href="contact.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
				</a>
			</li>-->
	
		</ul>
		<ul class="side-menu">
            <li>
				<a href="logout.php" class="logout">
                    <i class='bx bx-exit'></i>
					<span class="text">Exit</span>
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
		<!-- <a href="#" class="nav-link">Categories</a>  -->
        <form action="user_parking.php" method="get">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
			<input type="checkbox" id="switch-mode" hidden> 
			<label for="switch-mode" class="switch-mode"></label>
			<!-- <a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span> -->
			</a>
			<a href="home.php" class="profile">
				<img src="images/admin.png">
			</a>
		</nav>
		<!-- NAVBAR -->

        <div class="container mt-10">


        <div class="box1">
        <h2>PARKING AREAS</h2>
            </div>

        <div class="container">
        
        <table class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Brgy.</th>
                <th>City</th>
                <th>View</th>
            </tr>
            </thead>
            <tbody>

         
            <?php
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Get the search query
$query = "SELECT * FROM parking_area";

if (!empty($search)) {
    // Add WHERE clause if search input is provided
    $query .= " WHERE name LIKE :search OR description LIKE :search OR barangay LIKE :search OR city LIKE :search";
    $stmt = $conn->prepare($query); // Prepare the query with placeholders
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR); // Bind the search value
    $stmt->execute(); // Execute the prepared statement
} else {
    $stmt = $conn->query($query); // Directly execute the query if no search input
}

if ($stmt) {
    // Fetch and display results
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $row['parking_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['barangay']; ?></td>
            <td><?php echo $row['city']; ?></td>
            <td><a href="user_view_status.php?id=<?php echo $row['parking_id']; ?>" class="btn btn-primary">View</a></td>
        </tr>
        <?php
    }

    // Show message about search results if search term is provided
    if (!empty($search)) {
        echo "<h6>Showing results for: " . htmlspecialchars($search) . "</h6>";
    }
} else {
    die("Query failed."); // Handle query failure
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


    </div>
    
    <script src="admin.js"></script>
  

    </body>
    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    </html>