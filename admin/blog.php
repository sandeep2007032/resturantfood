<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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

    </style>
</head>
<body>
    <h1>blog</h1>

    <nav>
        

        <div class="nav-center">
            <a href="add_food.php" class="nav-item">Add Foods</a>
        </div>
        <div class="nav-center">
            <a href="food_list.php" class="nav-item">Food_list</a>
        </div>

        <div class="nav-right">
            <a href="index.php" class="nav-item">Logout</a>
        </div>
        <div class="nav-right">
            <a href="addblog.php" class="nav-item">AddBlog</a>
        </div>
    </nav>
</body>
</html>