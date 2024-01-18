<?php
session_start();

if (isset($_GET['order_id'])) {
    $orderID = $_GET['order_id'];
} else {
    // Handle the case where order_id is not provided in the URL
    echo "Order ID not provided.";
    // You might want to redirect the user to another page or display an error message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
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

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            margin-top: 69px;
            padding-top: 60px;
        }

        .payment-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .payment-button {
            padding: 10px;
            cursor: pointer;
            color: brown;
            transition: background-color 0.3s; /* Add smooth transition for color change */
        }

        .payment-button.selected {
            background-color: green; /* Set the background color to green when selected */
        }

        #payment-message {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="book.php">Home</a>
    </nav>

    <div class="container">
        <h2>Order ID: <?php echo $orderID; ?></h2>

        <div class="payment-options">
            <div class="payment-button" onclick="selectPayment('cash')">Pay with Cash</div>
            <div class="payment-button" onclick="selectPayment('online')">Pay Online</div>
        </div>

        <button onclick="payNow()">Pay Now</button>

        <p id="payment-message"></p>
    </div>

    <script>
    let selectedPaymentMethod = '';

    function selectPayment(method) {
        selectedPaymentMethod = method;

        // Remove the 'selected' class from all payment buttons
        document.querySelectorAll('.payment-button').forEach(button => {
            button.classList.remove('selected');
        });

        // Add the 'selected' class to the clicked payment button
        document.querySelector(`.payment-button[data-method="${method}"]`).classList.add('selected');
    }

    function payNow() {
        if (selectedPaymentMethod === 'cash' || selectedPaymentMethod === 'online') {
            // Handle payment logic here

            // Redirect to paymentdone.php after payment
            window.location.href = `paymentdone.php?order_id=<?php echo $orderID; ?>`;
        } else {
            document.getElementById('payment-message').innerHTML = `Please select a payment method.`;
        }
    }
</script>

</body>
</html>
