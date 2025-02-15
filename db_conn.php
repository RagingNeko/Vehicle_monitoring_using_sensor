<?php
$sName = "localhost";  // Database host
$uName = "root";       // Database username
$pass = "";            // Database password (empty for localhost with default MySQL setup)
$db_name = "auth_db";  // Database name

try {
    // Create a new PDO instance with additional attributes for better error handling and security
    $conn = new PDO("mysql:host=$sName;dbname=$db_name;charset=utf8", $uName, $pass);
    
    // Set error mode to exceptions for better error reporting
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optionally, you can set the fetch mode for your queries
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If connection fails, output an error message with the exception details
    die("Connection failed: " . $e->getMessage());
}
?>
