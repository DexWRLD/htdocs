<?php
// Note: This file should ideally contain order processing logic.
// For demonstration, we’ll keep it simple.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/favicon_picnic.ico" type="image/x-icon"> <!-- Favicon -->
    <title>Order</title>
</head>
<body>
    <h1>Order Products</h1>
    <form method="post">
        Product Name: <input type="text" name="product_name" required><br>
        Quantity: <input type="number" name="quantity" required><br>
        <input type="submit" value="Place Order">
    </form>
</body>
</html>
