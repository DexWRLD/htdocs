<?php
include 'db.php'; // Include the database connection

// Initialize an empty message variable for feedback
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the posted data and sanitize it
    $username = $conn_users->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $conn_users->real_escape_string($_POST['email']);

    // Check if the username or email already exists
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn_users->query($check_query);

    if ($result->num_rows > 0) {
        $message = "Username or email already exists. Please try another.";
    } else {
        // Insert new user into the database
        $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        
        if ($conn_users->query($query) === TRUE) {
            $message = "Registration successful! You can now <a href='login.php'>log in</a>.";
        } else {
            $message = "Error: " . $query . "<br>" . $conn_users->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/favicon_picnic.ico" type="image/x-icon"> <!-- Favicon -->
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <form action="register.php" method="POST"> <!-- Change the action to the same page -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Register">
        </form>
        <a href="index.php" class="back-button">Back</a>
    </div>
</body>
</html>
