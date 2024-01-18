<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "res";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch food items
$sql = "SELECT * FROM food_items";
$result = $conn->query($sql);

$foodItems = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $foodItems[] = $row;
    }
}

$conn->close();

// Return the food items as JSON
header('Content-Type: application/json');
echo json_encode($foodItems);
?>
