<?php include('db_conn.php'); ?>

<!-- parking area -->
<?php 
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete query
    $query = "DELETE FROM `parking_area` WHERE `parking_id` = :id";
    $stmt = $conn->prepare($query);  // Use $conn instead of $pdo
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        header('location:admin.php?delete_msg=Deleted Successfully');
        exit();  // Add exit after header redirect
    } else {
        echo "Query Failed: " . implode(", ", $stmt->errorInfo());
    }
}
?>
