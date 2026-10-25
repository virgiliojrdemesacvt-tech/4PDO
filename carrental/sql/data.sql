-- Optional: dbConfig.php creates all of this automatically.
CREATE DATABASE IF NOT EXISTS carrental_db;
USE carrental_db;

CREATE TABLE IF NOT EXISTS customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    date_of_birth VARCHAR(50),
    license_number TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS rentals (
    rental_id INT AUTO_INCREMENT PRIMARY KEY,
    car_model VARCHAR(50),
    rental_days TEXT,
    customer_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
