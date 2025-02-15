<?php 
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "auth_db";

try {
    // Create a new PDO instance and assign it to $conn
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
