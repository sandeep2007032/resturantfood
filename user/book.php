<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        nav {
            background-color: #333;
            color: white;
            padding: 10px 20px;
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
            margin-left: 20px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .menu-icon {
            display: none;
            cursor: pointer;
        }

        .menu-icon i {
            font-size: 24px;
        }

        .menu-items {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .filter-options {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .filter-options label {
            margin-right: 20px;
        }

        .container {
            margin-top: 69px;
            padding-top: 60px; /* Adjusted padding for navbar */
            padding: 20px;
        }

        .filter-options {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .filter-options label {
            margin-right: 20px;
        }

        .food-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .food-card {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            width: 200px;
            box-sizing: border-box;
            transition: transform 0.3s;
        }

        .food-card:hover {
            transform: scale(1.05);
        }

        .food-card img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        #cart {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .cart-item button {
            background-color: #ff3333;
            color: white;
            border: none;
            padding: 3px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php
    session_start();

    echo '<nav>';
    echo '<div class="menu-icon" onclick="toggleMenu()"><i class="fa fa-bars"></i></div>';
    echo '<div class="menu-items">';
    if (isset($_SESSION['username'])) {
        echo 'Welcome, ' . $_SESSION['username'];
        echo '<a href="index.php">Logout</a>';
    } else {
        echo 'Welcome, Guest';
    }
    echo '<a href="orderhistory.php">My Order History</a>';
    echo '</div>';
    echo '</nav>';
    ?>

<div class="container">
    <h2>Book a Table</h2>

    <div class="food-container" id="food-container">
        <!-- Food items will be displayed here dynamically -->
    </div>

    <div id="cart">
        <h3>Cart</h3>
        <!-- Cart items and Buy Now button will be displayed here -->
    </div>
</div>

<script>
    function toggleMenu() {
        const menuIcon = document.querySelector('.menu-icon');
        const menuItems = document.querySelector('.menu-items');
        menuItems.classList.toggle('show-menu');
    }

    const cartItems = []; // Array to store cart items

    function addToCart(foodName, foodPrice) {
        cartItems.push({ foodName, foodPrice }); // Add to cart
        updateCartDisplay();
    }

    function removeFromCart(index) {
        cartItems.splice(index, 1);
        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartContainer = document.getElementById('cart');
        cartContainer.innerHTML = '<h3>Cart</h3>';

        let totalPrice = 0;

        // Display cart items and calculate total price
        cartItems.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `${item.foodName} - $${item.foodPrice}
                                <button onclick="removeFromCart(${index})">Remove</button>`;
            cartContainer.appendChild(cartItem);

            totalPrice += parseFloat(item.foodPrice);
        });

        // Display total price
        const totalElement = document.createElement('div');
        totalElement.innerHTML = `<strong>Total: $${totalPrice.toFixed(2)}</strong>`;
        cartContainer.appendChild(totalElement);

        // Add Buy Now button
        const buyNowButton = document.createElement('button');
        buyNowButton.classList.add('buy-button');
        buyNowButton.innerText = 'Buy Now';
        buyNowButton.addEventListener('click', buyNow);
        cartContainer.appendChild(buyNowButton);
    }

    function buyNow() {
    // Send the cart items to the server for processing
    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cartItems)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Order placed successfully:', data);
        const orderID = data.order_id;
        window.location.href = `payment.php?order_id=${orderID}&username=${data.username}`;
        // You can show a confirmation message or redirect to another page
        cartItems.length = 0;
        updateCartDisplay();
    })
    .catch(error => {
        console.error('Error placing the order:', error);
    });
}


    // Fetch food data from the backend
    fetch('fetch_food.php')
        .then(response => response.json())
        .then(data => {
            const foodContainer = document.getElementById('food-container');
            foodContainer.innerHTML = '';

            data.forEach(foodItem => {
                const card = document.createElement('div');
                card.classList.add('food-card');

                const img = document.createElement('img');
                img.src = foodItem.food_image;
                img.alt = foodItem.food_name;

                const name = document.createElement('h3');
                name.innerText = foodItem.food_name;

                const description = document.createElement('p');
                description.innerText = `Price: $${foodItem.food_price}`;

                const addToCartButton = document.createElement('button');
                addToCartButton.classList.add('buy-button');
                addToCartButton.innerText = 'Add to Cart';
                addToCartButton.addEventListener('click', () => addToCart(foodItem.food_name, foodItem.food_price));

                card.appendChild(img);
                card.appendChild(name);
                card.appendChild(description);
                card.appendChild(addToCartButton);

                foodContainer.appendChild(card);
            });
        })
        .catch(error => console.error('Error fetching food data:', error));
</script>

</body>
</html>
