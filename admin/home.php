
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <style>
        /* Add your CSS styles here */
        /* ... */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: orchid;
            color: white;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .nav-left, .nav-center, .nav-right {
            margin :10px;
        }

        .nav-item {
            margin-right: 20px;
            margin-bottom: 10px;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
        }

        

        main {
            padding: 20px;
        }

        .card {
            background-color: olivedrab;
            border: 4px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 4, 3);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .food-details {
            font-size: 0.9em;
            margin-bottom: 10px;
            width: 100%;
        }

        table {
            background-color: aqua;
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
         /* Styles for payment buttons */
         .payment-button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        .payment-button:disabled {
            background-color: lightgray;
            cursor: not-allowed;
        }
        .payment-card {
            background-color: #f2f2f2;
            border: 2px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
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

    // if (!isset($_SESSION['admin'])) {
    //     header('Location: index.php');
    //     exit();
    // }

    $adminName = $_SESSION['username']; // Get admin name

    // Fetch admin's full name
    $sql = "SELECT username FROM admin WHERE username='$adminName'";
    $result = $conn->query($sql);

    $adminName = "Unknown"; // Default if the admin info is not found

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $adminName = $row['username'];
    }
    ?>

    <nav>
        <div class="nav-left">
            <span>Welcome, Admin <?php echo $adminName; ?></span>
        </div>

        <div class="nav-center">
            <a href="add_food.php" class="nav-item">Add Foods</a>
        </div>
        <div class="nav-center">
            <a href="food_list.php" class="nav-item">Food_list</a>
        </div>

        <div class="nav-right">
            <a href="index.php" class="nav-item">Logout</a>
        </div>
        
    </nav>

    <main>
        <h2>Food Details</h2>
        

        <!-- Display food details here -->
        <?php
        // Display food details (name and ID)
        // Modify this section to fetch and display food details as needed
       
        ?>

        <h2>Order List</h2>
        
        <!-- Payment buttons -->
        <!-- <div class="payment-card">
            <h2>Payment Details</h2>
            <p><strong>Order ID:</strong> <?php echo $orderID; ?></p>
            <p><strong>User Name:</strong> <?php echo $adminName; ?></p>
            <p><strong>Payment Status:</strong> <?php echo $paymentStatus; ?></p>

            Payment buttons -->
            <!-- <h3>Select Payment Option</h3>
            <button class="payment-button" disabled>Cash Payment</button>
            <button class="payment-button" disabled>Online Payment</button>
</div> -->
        <!-- Fetch and display order list here -->
        <?php
        // Fetch orders with food details and username
        $sql = "SELECT orders.order_id, orders.username, orders.order_time, GROUP_CONCAT(order_items.food_name SEPARATOR ', ') as food_names FROM orders INNER JOIN order_items ON orders.order_id = order_items.order_id GROUP BY orders.order_id ORDER BY orders.order_id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h3>Order ID: ' . $row['order_id'] .'<p>Username: ' . $row['username'] . '</p><p>Order Time: ' . $row['order_time'] . '</h3>'; 
                echo '<div class="food-details">';
                $foodNames = explode(', ', $row['food_names']);
                echo '<table>';
                echo '<tr><th>Food Item</th><th>Quantity</th></tr>';
                $foodCounts = array_count_values($foodNames);
                foreach ($foodCounts as $food => $count) {
                    echo '<tr><td>' . $food . '</td><td>' . $count . '</td></tr>';
                }
                echo '</table>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No orders found.";
        }

        $conn->close();
        ?>
    </main>
</body>
</html>
