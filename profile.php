<?php
include('db.php'); // Include the database connection file

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session to access user information
}

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn_users->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user information
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];

    $update_query = "UPDATE users SET username = ?, email = ?, address = ?, city = ?, zip = ? WHERE id = ?";
    $update_stmt = $conn_users->prepare($update_query);

    // Correct the bind_param call to include six parameters
    $update_stmt->bind_param("sssssi", $username, $email, $address, $city, $zip, $user_id);

    if ($update_stmt->execute()) {
        echo "<p>Profile updated successfully!</p>";
        // Refresh user information in session
        $_SESSION['username'] = $username;
    } else {
        echo "<p>Error updating profile: " . $update_stmt->error . "</p>";
    }

    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/favicon_picnic.ico" type="image/x-icon"> <!-- Favicon -->
    <title>Your Profile</title>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <form action="profile.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>

            <label for="zip">Zip Code:</label>
            <input type="text" id="zip" name="zip" value="<?php echo htmlspecialchars($user['zip']); ?>" required>

            <input type="submit" value="Update Profile">
        </form>
        <a href="index.php" class="back-button">Back</a>
    </div>
</body>
</html>
