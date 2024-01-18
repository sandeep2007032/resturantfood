<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "res";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 // Include your database connection code

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the request contains the cart items as JSON in the body
    $cartItems = json_decode(file_get_contents('php://input'), true);
    

    // Get the username from the session
    $username = $_SESSION['username'];

    // Calculate total price
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['foodPrice'];
    }

    // Insert order information
    $insertOrderQuery = "INSERT INTO orders (username, order_time, total_price) 
                         VALUES ('$username', NOW(), $totalPrice)";

    if ($conn->query($insertOrderQuery) === TRUE) {
        $orderId = $conn->insert_id; // Get the order ID

        // Insert order items
        foreach ($cartItems as $item) {
            $foodName = $item['foodName'];
            $foodPrice = $item['foodPrice'];
            $insertOrderItemQuery = "INSERT INTO order_items (order_id, food_name, food_price)
                                    VALUES ($orderId, '$foodName', $foodPrice)";
            $conn->query($insertOrderItemQuery);
        }

        echo json_encode(['success' => true, 'order_id' => $orderId]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

$conn->close();
?>
