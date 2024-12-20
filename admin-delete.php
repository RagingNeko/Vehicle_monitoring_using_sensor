<?php include('database.php');?>

<!-- parking area -->

<?php 

if(isset($_GET['id'])){
    $id = $_GET['id'];


$query = "delete from `parking_area` where `parking_id` = '$id'";

$result = mysqli_query($conn, $query);

if(!$result) {
die("Query Failed".mysqli_error());
}

else{
    header('location:admin.php? delete_msg= Deleted Successfully');
}
}

?>

<!-- parking space -->


