<?php
include 'db_conn.php';

if (isset($_POST['add_parking'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];

    if ($name == "" || empty($name)) {
        header('Location: admin.php?message=you need to fill up!');
    } else {
        // Prepare the SQL query using PDO
        $query = "INSERT INTO `parking_area` (`name`, `description`, `barangay`, `city`) VALUES (:name, :description, :barangay, :city)";
        
        // Prepare the statement to prevent SQL injection
        $stmt = $conn->prepare($query);

        // Bind the form data to the query parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':barangay', $barangay);
        $stmt->bindParam(':city', $city);

        // Execute the query
        if ($stmt->execute()) {
            header('Location: admin.php?insert_msg=added successfully');
        } else {
            echo "Query Failed";
        }
    }
}
?>
