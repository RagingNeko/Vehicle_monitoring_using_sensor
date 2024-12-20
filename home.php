<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {

include "db_conn.php";
include 'php/User.php';
$user = getUserById($_SESSION['id'], $conn);


 ?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Profile</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
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

<header>    
    <div class="logo-header">
    <img src="images/logo.png" alt="Logo" class="logo">
    <h1>  Northwestern Mindanao State College </h1>
</div>

        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>

        <nav>
        <a href="registration.php" class="tbtn">Register</a>
        <a href="admin.php" class="tbtn">Back</a>
    </nav>
</header>


<body>
    <?php if ($user) { ?>

		<div class="profile-container">
 
 <div class="profile-header">
    		<img src="upload/<?=$user['pp']?>"
    		     class="profile-picture">
            <p class="display-4 "><?=$user['username']?></p>
            <p class="display-4 ">Administrator</p>
			</div>
			</div>
            
<div class="profile-container">
<div class="profile-details">
            <h3>Profile Information:</h3>
			<p><strong>Full Name:</strong> <?=$user['fname']?></p>
            <p><strong>Email:</strong> <?=$user['email']?></p>
            <p><strong>Phone Number:</strong> <?=$user['phone']?></p>
            <a href="edit.php" class="btn btn-primary">
            	Edit Profile
            </a>
			</div>

			   <!-- Social media section with icons -->
			   <div class="profile-socials">
            <h3>Connect with me</h3>
            <a href="https://www.youtube.com/watch?v=ZHgyQGoeaB0">
                <img src="images/fb.png" alt="Facebook" class="social-icon"> Facebook
            </a>
            <a href="<?php echo $admin['socials']['twitter']; ?>" target="_blank">
                <img src="images/twitter.png" alt="Twitter" class="social-icon"> Twitter
            </a>
            <a href="<?php echo $admin['socials']['instagram']; ?>" target="_blank">
                <img src="images/instagram.JPG" alt="Instagram" class="social-icon"> Instagram
            </a>
        </div>
        </div>
        </div>

        <?php include 'footer.php' ?>
  
    <?php }else { 
     header("Location: login.php");
     exit;
    } ?>


<?php }else {
	header("Location: login.php");
	exit;
} ?>

</body>
</html>
