<?php
session_start(); // Start session to access user data
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/favicon_picnic.ico" type="image/x-icon"> <!-- Favicon -->
    <title>Login - Picnic</title>
</head>
<body>
    <div class="container">
        <h1>Login to Your Account</h1>

        <?php
        // Display error message if login failed
        if (isset($_SESSION['login_error'])) {
            echo "<p class='error'>" . $_SESSION['login_error'] . "</p>";
            unset($_SESSION['login_error']); // Clear the error after displaying
        }
        ?>

        <form action="login_action.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a>.</p>

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
