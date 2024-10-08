<?php
include('db.php'); // Include the database connection file

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session if not already started
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to add items to the basket.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id']; // Assuming this comes from a form
    $user_id = $_SESSION['user_id'];

    // Prepare statement to add product to basket
    $stmt = $conn_users->prepare("INSERT INTO basket (user_id, product_id, quantity) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE quantity = quantity + 1");
    if (!$stmt) {
        echo "Prepare failed: " . $conn_users->error;
        exit();
    }

    $stmt->bind_param("ii", $user_id, $product_id);
    if ($stmt->execute()) {
        echo "Product added to basket successfully.";
    } else {
        echo "Error adding product to basket: " . $stmt->error;
    }

    $stmt->close();
}

$conn_users->close(); // Close the user connection
?>
