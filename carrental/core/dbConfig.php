<?php
// Show errors while learning
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ---- CHANGE THESE IF NEEDED ----
$host     = "localhost";
$port     = "3306";        // XAMPP default. MAMP often uses 8889
$user     = "root";
$password = "";            // XAMPP: empty.  MAMP: "root"
$dbname   = "carrental_db";
// --------------------------------

try {
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // 1) Connect to the MySQL server and create the database if it is missing
    $server = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $user, $password, $options);
    $server->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4");

    // 2) Connect to that database
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $user, $password, $options);

    // 3) Create the tables if they are missing
    $pdo->exec("CREATE TABLE IF NOT EXISTS customers (
        customer_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        first_name VARCHAR(50),
        last_name VARCHAR(50),
        date_of_birth VARCHAR(50),
        license_number TEXT,
        date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS rentals (
        rental_id INT AUTO_INCREMENT PRIMARY KEY,
        car_model VARCHAR(50),
        rental_days TEXT,
        customer_id INT,
        date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("<h2>Database connection problem</h2>
         <p><b>Message:</b> " . htmlspecialchars($e->getMessage()) . "</p>
         <p>Check that MySQL is running in XAMPP, then check the host, port, user and password in <code>core/dbConfig.php</code>.</p>");
}
