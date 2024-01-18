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
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            margin-top: 69px;
            padding-top: 60px;
            text-align: center;
        }

        .confirmation-message {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .moving-text {
            font-size: 18px;
            color: green;
            animation: moveText 2s linear infinite;
        }

        @keyframes moveText {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }

        #food-message {
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-message">Payment Coming Soon!</div>
        <div class="moving-text">Your payment is being processed...</div>
        <div id="food-message">Your food will be served on your table within 10 to 20 minutes. Thank you for ordering!</div>
    </div>

    <script>
        // You can add any additional JavaScript logic if needed
    </script>
</body>
</html>
