<?php
include('db.php'); // Include the database connection file

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session to access user information
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/favicon_picnic.ico" type="image/x-icon"> <!-- Favicon -->
    <title>Welcome to Picnic</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>
                <img src="img/Picnic_Logo.svg" alt="Picnic Logo" style="width: 150px; height: auto;"> <!-- Logo -->
            </h1>
            <h1>Welcome to Picnic</h1>
            <nav>
                <?php
                // Display links based on user login status
                if (isset($_SESSION['username'])) {
                    echo '<a href="logout.php">Logout</a>';
                    echo '<a href="products.php">View Products</a>';
                    echo '<a href="basket.php">View Basket</a>';
                    echo '<a href="profile.php">Profile</a>'; // Profile link
                } else {
                    echo '<a href="register.php">Register</a>';
                    echo '<a href="login.php">Login</a>';
                    echo '<a href="products.php">View Products</a>';
                }
                ?>
            </nav>
        </div>
    </header>

    <?php
    if (isset($_SESSION['username'])) {
        echo "<div class='user-status'>Hello, " . htmlspecialchars($_SESSION['username']) . "! You are logged in.</div>";
    } else {
        echo "<div class='user-status error'>You are not logged in. Please register or log in.</div>";
    }
    ?>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Picnic. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
