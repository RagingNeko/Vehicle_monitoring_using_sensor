<?php
// Include database connection
require_once 'db_config.php'; // Include your database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $width = $_POST['width'];
    $height = $_POST['height'];
    $top = $_POST['top'];
    $left = $_POST['left'];  // The column 'left' is a reserved keyword, so we will escape it.
    $background_color = $_POST['background_color'];
    $border_color = $_POST['border_color'];

    // Insert box properties into the database
    $sql = "INSERT INTO box_properties (width, height, top, `left`, background_color, border_color) 
            VALUES (:width, :height, :top, :left, :background_color, :border_color)";
    
    // Prepare and execute the query
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':width' => $width,
            ':height' => $height,
            ':top' => $top,
            ':left' => $left,
            ':background_color' => $background_color,
            ':border_color' => $border_color
        ]);
        echo "Box properties saved successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
