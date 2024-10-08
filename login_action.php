<?php
include('db.php'); // Include the database connection file

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session if not already started
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use the correct connection for user accounts
    $stmt = $conn_users->prepare("SELECT id, username, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn_users->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password (assuming passwords are hashed)
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            header("Location: index.php");
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}

$conn_users->close(); // Close the user connection
?>
