<?php
session_start(); // Start session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

include('db.php'); // Database connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Products</title>
    <link rel="icon" href="img/favicon_picnic.ico" type="image/x-icon"> <!-- Favicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>
<body>
    <div class="container">
        <h1>Available Products</h1>

        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! You are logged in.</p>

        <div id="message"></div> <!-- Div for displaying messages -->

        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
            <?php
            // Fetch products from the database
            $query = "SELECT * FROM products";
            $result = $conn_products->query($query);

            // Check if the query was successful
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['stock']}</td>
                            <td>
                                <button class='add-to-basket' data-product-id='{$row['id']}'>Add to Basket</button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found.</td></tr>";
            }
            ?>
        </table>
        <a href="index.php" class="back-button">Back</a>
    </div>

    <script>
        $(document).ready(function() {
            // Handle the click event for adding products to the basket
            $('.add-to-basket').click(function() {
                var productId = $(this).data('product-id');

                // AJAX request to add the product to the basket
                $.ajax({
                    url: 'basket_action.php',
                    type: 'POST',
                    data: { product_id: productId },
                    success: function(response) {
                        $('#message').html("<p>" + response + "</p>").fadeIn().delay(2000).fadeOut(); // Show success message
                    },
                    error: function() {
                        $('#message').html("<p>Error adding product to basket.</p>").fadeIn().delay(2000).fadeOut(); // Show error message
                    }
                });
            });
        });
    </script>
</body>
</html>
