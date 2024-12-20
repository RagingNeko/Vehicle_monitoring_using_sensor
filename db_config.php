<?php
// db_config.php

$host = "localhost";  // Change this if necessary
$db = "auth_db";  // Replace with your actual database name
$user = "root";  // Replace with your actual username
$pass = "";  // Replace with your actual password
$charset = 'utf8mb4';

// Set up DSN and options for PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Establish the PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Handle the exception if connection fails
    echo "Database connection failed: " . $e->getMessage();
    exit;
}
?>
