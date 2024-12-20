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


<?php include 'header.php' ?>

</head>
<?php
include('db_conn.php');

// Check if 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Parking area ID is missing!";
    exit;
}

// Fetch the ID from the URL
$id = $_GET['id'];

// Retrieve the existing data for this parking area
$query = "SELECT * FROM parking_area WHERE parking_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data was retrieved
if (!$row) {
    echo "Parking area not found!";
    exit;
}

// Processing the form update if submitted
if (isset($_POST['update_parking'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];

    // Check if a new image was uploaded
    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);

            $allowed_exs = array('jpg', 'jpeg', 'png');
            if (in_array($img_ex_to_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_to_lc;
                $img_upload_path = './image/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Update the database with the new image
                $sql = "UPDATE parking_area SET name = ?, description = ?, barangay = ?, city = ?, image = ? WHERE parking_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $description, $barangay, $city, $new_img_name, $id]);
            } else {
                echo "You can't upload files of this type";
                exit;
            }
        } else {
            echo "An error occurred during the file upload";
            exit;
        }
    } else {
        // Update the database without changing the image
        $sql = "UPDATE parking_area SET name = ?, description = ?, barangay = ?, city = ? WHERE parking_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $description, $barangay, $city, $id]);
    }

    header('location:admin.php?update_msg=Succesfully updated the data');
    exit;
}
?>

<div class="sudlanan">
    <h2>Update Parking Areas</h2> 
  
    <!-- Added enctype attribute to allow file upload -->
    <form action="admin_update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($row['description']); ?>">
        </div>
        <div class="form-group">
            <label for="barangay">Barangay</label>
            <input type="text" name="barangay" class="form-control" value="<?php echo htmlspecialchars($row['barangay']); ?>">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($row['city']); ?>">
        </div>
        <div class="form-group">
            <label for="image">Update Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <input type="submit" class="btn btn-success" name="update_parking" value="Update">
        
        <a href="admin.php" class="btn btn-primary">Back</a>
    
    </form>
</div>

    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>