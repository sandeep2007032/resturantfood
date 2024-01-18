
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .navbar-buttons {
            display: flex;
            justify-content: space-around;
            width: 30%;
        }

        .navbar-buttons button {
            padding: 10px;
            margin: 0 5px;
            border: none;
            cursor: pointer;
        }

        .navbar-buttons button:hover {
            background-color: #555;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 600px) {
            .navbar-buttons {
                width: 70%;
            }
        }
    </style>
</head>
<body>
    
<?php
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $username = "Guest";
    }
?>

<nav>
    <div id="user-info">
        Welcome, <?php echo $username; ?>
    </div>
    <div class="navbar-buttons">
        <a href="book.php">BOOK FOOD</a>
        <a href="index.php">LOGOUT</a>
        <!-- Removed Button 3 -->
    </div>
</nav>

<div class="container">
<?php

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    

    // Database connection parameters
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "res";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch order history for the user
    $sql = "SELECT orders.order_id, orders.order_time, GROUP_CONCAT(order_items.food_name SEPARATOR ', ') AS food_names, SUM(order_items.food_price) AS total_price
            FROM orders
            INNER JOIN order_items ON orders.order_id = order_items.order_id
            WHERE orders.username = '$username'
            GROUP BY orders.order_id
            ORDER BY orders.order_id DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Your Order History:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "Order ID: " . $row['order_id'] . "<br>";
            echo "Food: " . $row['food_names'] . "<br>";
            echo "Total Price: $" . $row['total_price'] . "<br>";
            echo "Timestamp: " . $row['order_time'] . "<br><br>";
        }
    } else {
        echo "No order history available.";
    }

    $conn->close();
} else {
    echo "Please log in to view your order history.";
}
?>
</div>

</body>
</html>

