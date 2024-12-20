<html>
    <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
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


    <header>

<img src="images/logo.png" alt="Startup Company Logo">
        <h1> <a href="index.php">NMSC</h1></a>
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
<nav>
        <a href="parkingArea.php" class="tbtn">Parking Areas</a>
        <a href="admin.php" class="tbtn">Back</a>
    </nav>
</header>
    <?php include('db_conn.php'); ?>

    <?php 

    if(isset($_GET['id'])){
        $id = $_GET['id'];



        $query = "select * from `parking_area` where `parking_id` = '$id'";
        
        $result = mysqli_query($conn, $query);

        if(!$result){
            die("query Failed".mysqli_error());
        }
        else{

            $row = mysqli_fetch_assoc($result);  
    }
    }
    ?>

    <?php

    if(isset($_POST['update_parking'])){

        if(isset($_GET['id_new'])){
            $idnew = $_GET['id_new'];
        }
        

        $name = $_POST['name'];
        $description = $_POST['description'];
        $barangay = $_POST['barangay'];
        $city = $_POST['city'];

        $query = "update `parking_area` set `name`='$name', `description`='$description', `barangay`='$barangay', `city`='$city' where `parking_id` = '$idnew'";
        $result = mysqli_query($conn, $query);

        if(!$result){
            die("query Failed".mysqli_error());
        }
        else{
            header('location:admin.php?update_msg=Succesfully updated the data');
        }
    }

    ?>

    <div class="sudlanan">

    <h2> Update Parking Areas
    </h2>

            <form action ="admin_update.php?id_new=<?php echo $id; ?>" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $row['name']  ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="form-control" value="<?php echo $row['description'] ?>">
                </div>
                <div class="form-group">
                    <label for="barangay">Barangay</label>
                    <input type="text" name="barangay" class="form-control" value="<?php echo $row['barangay'] ?>">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $row['city'] ?>">
                </div>
                <input type="submit" class="btn btn-success" name="update_parking" value="Update">
            </form>
                </div>

    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>