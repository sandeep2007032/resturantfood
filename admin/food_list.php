<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food List</title>
    <style>
        /* Add your CSS styles for the card view */
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            width: 300px;
            display: inline-block;
        }

        /* Additional CSS for responsiveness */
        @media (max-width: 768px) {
            .card {
                width: 100%; /* Adjust width for smaller screens */
            }
        }

        /* Style for the navbar */
        nav {
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Style for the popup message */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="add_food.php">Add Food</a>
        <a href="index.php">Logout</a>
    </nav>

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

    // Check if a food item should be deleted
    if (isset($_GET['delete_food_name'])) {
        $delete_food_name = $_GET['delete_food_name'];  // Fixed variable name here

        // Use proper SQL escaping to prevent SQL injection
        $delete_food_name = mysqli_real_escape_string($conn, $delete_food_name);

        $delete_sql = "DELETE FROM food_items WHERE food_name='$delete_food_name'";
        if ($conn->query($delete_sql) === TRUE) {
            echo '<script>showSuccessMessage();</script>';
        } else {
            echo "Error deleting food item: " . $conn->error;
        }
    }

    // Fetch food items from the database
    $sql = "SELECT * FROM food_items";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<h2>' . $row['food_name'] . '</h2>';
            echo '<p>Is Vegetarian: ' . ($row['is_vegetarian'] ? 'Yes' : 'No') . '</p>';
            echo '<p>Price: $' . $row['food_price'] . '</p>';
            echo '<img src="' . $row['food_image'] . '" alt="' . $row['food_name'] . '" style="width: 100%;">';
            echo '<br><a href="?delete_food_name=' . $row['food_name'] . '">Delete</a>';
            echo '</div>';
        }
    } else {
        echo "No food items available.";
    }

    $conn->close();
    ?>

    <script>
        function showSuccessMessage() {
            var popup = document.querySelector('.popup');
            if (popup) {
                popup.style.display = 'block';
                setTimeout(function() {
                    popup.style.display = 'none';
                }, 3000); // Hide after 3 seconds
            }
        }
    </script>

    <div class="popup">Food item deleted successfully.</div>
</body>
</html>
