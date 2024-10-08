<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root"; // Adjust as needed
$password = ""; // Adjust as needed

// Create a connection to MySQL server
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create databases if they do not exist
$conn->query("CREATE DATABASE IF NOT EXISTS picnic_products_db");
$conn->query("CREATE DATABASE IF NOT EXISTS picnic_users_db");

// Create connection for products database
$conn_products = new mysqli($servername, $username, $password, "picnic_products_db");
if ($conn_products->connect_error) {
    die("Connection failed: " . $conn_products->connect_error);
}

// Create connection for users database
$conn_users = new mysqli($servername, $username, $password, "picnic_users_db");
if ($conn_users->connect_error) {
    die("Connection failed: " . $conn_users->connect_error);
}

// Function to check and create necessary tables
function checkAndCreateTables($conn_products, $conn_users) {
    // Create products table if it does not exist
    $conn_products->query("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            price DECIMAL(10, 2),
            description TEXT,
            stock INT
        )");

    // Create users table if it does not exist
    $conn_users->query("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE,
            password VARCHAR(255),
            address VARCHAR(255),
            city VARCHAR(100),
            zip VARCHAR(100),
            email VARCHAR(100) UNIQUE
        )");

    // Create basket table if it does not exist
    $conn_users->query("
        CREATE TABLE IF NOT EXISTS basket (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES picnic_products_db.products(id) ON DELETE CASCADE
        )");
}

// Check and create tables
checkAndCreateTables($conn_products, $conn_users);

// Keep connections open for use in other scripts
// You can return connections or set them in a global variable if necessary
return [$conn_products, $conn_users];
?>
