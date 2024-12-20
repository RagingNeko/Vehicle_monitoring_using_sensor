<?php
// Include database connection
require_once 'db_config.php'; // Include your database connection

// Retrieve the box properties from the database
$sql = "SELECT * FROM box_properties ORDER BY id DESC LIMIT 1"; // Get the most recent entry
$stmt = $pdo->query($sql);
$box = $stmt->fetch(PDO::FETCH_ASSOC);

if ($box) {
    echo '<div style="width: ' . $box['width'] . '; height: ' . $box['height'] . '; position: absolute; top: ' . $box['top'] . '; left: ' . $box['left'] . '; background-color: ' . $box['background_color'] . '; border: 1px solid ' . $box['border_color'] . ';"></div>';
} else {
    echo "No box properties found.";
}
?>
