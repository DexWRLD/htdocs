<?php
session_start(); // Start session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

include('db.php'); // Database connection

// Fetch items in the user's basket
$user_id = $_SESSION['user_id'];
$query = "
    SELECT p.name, p.price, b.quantity
    FROM picnic_users_db.basket b
    JOIN picnic_products_db.products p ON b.product_id = p.id
    WHERE b.user_id = ?
";

$stmt = $conn_users->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$totalPrice = 0; // Initialize total price
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/favicon_picnic.ico" type="image/x-icon"> <!-- Favicon -->
    <title>Your Basket</title>
</head>
<body>
    <div class="container">
        <h1>Your Basket</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): 
                    $itemTotal = $row['price'] * $row['quantity'];
                    $totalPrice += $itemTotal; // Calculate total price
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo number_format($itemTotal, 2); ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td><strong><?php echo number_format($totalPrice, 2); ?></strong></td>
                </tr>
            </table>
        <?php else: ?>
            <p>Your basket is empty.</p>
        <?php endif; ?>

        <a href="index.php" class="back-button">Back</a>
    </div>
    <?php
    if (isset($_SESSION['username'])) {
        echo "<div class='user-status'>Hello, " . htmlspecialchars($_SESSION['username']) . "! You are logged in.</div>";
    } else {
        echo "<div class='user-status error'>You are not logged in. Please register or log in.</div>";
    }
    ?>
</body>
</html>

<?php
$stmt->close(); // Close statement
$conn_users->close(); // Close the user connection
?>
