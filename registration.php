<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up</title>
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
        <a href="admin.php" class="tbtn">Back</a>
    </nav>
</header>


<body>
    <div class="sudlanan">
    	
	<form action="php/signup.php" 
    	      method="post"
    	      enctype="multipart/form-data">

    		<h4 class="display-4  fs-1">Create Account</h4><br>
    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>

		    <?php if(isset($_GET['success'])){ ?>
    		<div class="alert alert-success" role="alert">
			  <?php echo $_GET['success']; ?>

		    <?php } ?>
		  <div class="form-group">
		    <input type="text" 
		           class="form-control"
				   placeholder="Enter Full Name:"
		           name="fname"
		           value="<?php echo (isset($_GET['fname']))?$_GET['fname']:"" ?>">


		  <div class="form-group">
		    <input type="text" 
		           class="form-control"
				   placeholder="Enter username:"
		           name="uname"
		           value="<?php echo (isset($_GET['uname']))?$_GET['uname']:"" ?>">
				   </div>
				   
				   <div class="form-group">
		    <input type="text" 
		           class="form-control"
				   placeholder="Enter email:"
		           name="email"
		           value="<?php echo (isset($_GET['email']))?$_GET['email']:"" ?>">
				   </div>

			<!--	   <div class="form-group">
		    <input type="text" 
		           class="form-control"
				   placeholder="Enter Role:"
		           name="role"
		           value="<?php echo (isset($_GET['role']))?$_GET['role']:"" ?>">
				   </div> -->

				   <div class="form-group">
		    <input type="text" 
		           class="form-control"
				   placeholder="Enter Phone Number:"
		           name="phone"
		           value="<?php echo (isset($_GET['phone']))?$_GET['phone']:"" ?>">
				   </div>

		  <div class="form-group">
		    <input type="password" 
		           class="form-control"
				   placeholder="Enter password:"
		           name="pass">
				   </div>

		  <div class="form-group">
		    <label class="form-label">Profile Picture</label>
		    <input type="file" 
		           class="form-control"
		           name="pp">
				   </div>

		  
		  <button type="submit" class="btn btn-primary">Sign Up</button>
		  <a href="login.php" class="link-secondary">Login</a>
		  </form>
    </div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>