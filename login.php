<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
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
	<script type="text/javascript">
        function preventBack(){window.history.forward()};
        setTimeout("preventBack()",0);
        window.onunload=function(){null;}
        </script>
		</head>

		<style>
			body{
				background-image: url('images/about.jpg');
			}
		</style>

<body>
<?php include 'header.php' ?>
    <div class="sudlanan">
    	
    
	<form action="php/login.php"  method="post">

    		<h4>login</h4><br>
    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>

		  <div class="form-group">
		    <input type="text" 
		           class="form-control"
		           name="uname"
				    placeholder="enter username:"
		           value="<?php echo (isset($_GET['uname']))?$_GET['uname']:"" ?>">
		  </div>

		  <div class="form-group">
		    <input type="password" 
		           class="form-control"
				   placeholder="Enter Password:"
		           name="pass">
		  </div>
		  
		  <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
	  <!-- 	<div><p>Not registered yet? <a href="registration.php">Register Here</a></p></div> -->
		</form>
    </div>
	
</body>
<?php include 'footer.php' ?>
</html>