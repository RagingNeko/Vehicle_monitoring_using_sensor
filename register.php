<?php
// Initialize variables
$full_name = $email = $password = $phone = $facebook = $twitter = $linkedin = $instagram = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $facebook = htmlspecialchars(trim($_POST['facebook']));
    $twitter = htmlspecialchars(trim($_POST['twitter']));
    $instagram = htmlspecialchars(trim($_POST['instagram']));

    // Check if fields are filled
    if (empty($full_name)) $errors[] = "Full Name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (empty($password)) $errors[] = "Password is required";

    // If no errors, proceed to database insertion
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $servername = "localhost";
        $username = "root"; // Replace with your DB username
        $dbpassword = ""; // Replace with your DB password
        $dbname = "admin_system"; // Database name

        $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL to insert data
        $sql = "INSERT INTO admin (full_name, email, password, phone, facebook, twitter,  instagram)
                VALUES ('$full_name', '$email', '$hashed_password', '$phone', '$facebook', '$twitter', '$instagram')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Linking to the CSS file -->
</head>
<body>
    <div class="registration-container">
        <h2>Admin Registration Form</h2>
        <!-- Display validation errors -->
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required value="<?php echo $full_name; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
            </div>
            <div class="form-group">
                <label for="facebook">Facebook Profile:</label>
                <input type="text" id="facebook" name="facebook" value="<?php echo $facebook; ?>">
            </div>
            <div class="form-group">
                <label for="twitter">Twitter Profile:</label>
                <input type="text" id="twitter" name="twitter" value="<?php echo $twitter; ?>">
            </div>
            <div class="form-group">
                <label for="instagram">Instagram Profile:</label>
                <input type="text" id="instagram" name="instagram" value="<?php echo $instagram; ?>">
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Don't have an account? <a href="log_in.php">Login here</a></p>
    </div>
</body>

<?php include 'footer.php' ?>
</html>
