<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food Item</title>
    <style>
        /* Add your CSS styles here */
        /* ... */
    </style>
</head>
<body>
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

    // Process form data when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $food_name = $_POST['food_name'];
        $is_vegetarian = isset($_POST['is_vegetarian']) ? 1 : 0;

        // Handle file upload
        $target_dir = "uploads/";
        $food_image = $target_dir . basename($_FILES["food_image"]["name"]);
        move_uploaded_file($_FILES["food_image"]["tmp_name"], $food_image);

        $food_price = $_POST['food_price'];

        // SQL insert statement
        $sql = "INSERT INTO food_items (food_name, is_vegetarian, food_image, food_price)
                VALUES ('$food_name', $is_vegetarian, '$food_image', $food_price)";

        if ($conn->query($sql) === TRUE) {
            echo "New food item added successfully.";
        } else {
            echo "Error adding food item: " . $conn->error;
        }
    }
    ?>
    

    <nav>
        <a href="home.php">Home</a>
        <a href="food_list.php">Food List</a>
    </nav>

    <h2>Add Food Item</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label for="food_name">Food Name:</label>
        <input type="text" id="food_name" name="food_name" required><br>

        <label for="is_vegetarian">Is Vegetarian:</label>
        <input type="checkbox" id="is_vegetarian" name="is_vegetarian"><br>

        <label for="food_image">Food Image:</label>
        <input type="file" id="food_image" name="food_image" accept="image/*" required><br>

        <label for="food_price">Food Price:</label>
        <input type="number" id="food_price" name="food_price" required><br>

        <input type="submit" value="Add Food">
    </form>
</body>
</html>
