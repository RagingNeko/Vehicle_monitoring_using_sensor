<html>

<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
      <title>User Dashboard</title>
</header>
<?php include 'header.php' ?>

    <body>
        <div class="sudlanan">
        <?php
if (isset($_POST["submit"])) {
    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Image upload
    $profileImage = $_FILES["profile_image"];
    $imageName = $profileImage["name"];
    $imageTmpName = $profileImage["tmp_name"];
    $imageSize = $profileImage["size"];
    $imageError = $profileImage["error"];
    $imageType = $profileImage["type"];

    // Set allowed file extensions
    $allowed = array("jpg", "jpeg", "png", "gif");
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Initialize error array
    $errors = array();

    // Validate fields
    if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    if ($password !== $passwordRepeat) {
        array_push($errors, "Passwords do not match");
    }
    if ($imageError === 0) {
        if ($imageSize > 5000000) {
            array_push($errors, "Image file is too large (max 5MB)");
        }
        if (!in_array($imageExt, $allowed)) {
            array_push($errors, "Invalid image type. Allowed types: jpg, jpeg, png, gif");
        }
    } else {
        array_push($errors, "Error uploading the image");
    }

    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        array_push($errors, "Email already exists!");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Move the uploaded image to a directory
        $imageDestination = 'images/' . uniqid('', true) . "." . $imageExt;
        move_uploaded_file($imageTmpName, $imageDestination);

        // Insert user info and image path into the database
        $sql = "INSERT INTO users (full_name, email, password, images) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $fullName, $email, $passwordHash, $imageDestination);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>You are registered successfully.</div>";
        } else {
            die("Something went wrong");
        }
    }
}
?>

    <form action="registration.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
    </div>
    <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Email:">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password:">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
    </div>
    <!-- New file input for image -->
    <div class="form-group">
        <input type="file" class="form-control" name="profile_image" accept="image/*">
    </div>
    <div class="form-btn">
        <input type="submit" class="btn btn-primary" value="Register" name="submit">
    </div>
</form>

            <div>
            <div><p>Already Registered? <a href="login.php">Login Here</a></p></div>
        </div>
        </div>
        </body>


        <?php include 'footer.php';?>
    </html>
    