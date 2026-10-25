<?php
/* ---------- HELPER ---------- */

// Reads an id from the URL (?customer_id=3). Sends the user home if it is missing.
function requireId($key) {
    if (!isset($_GET[$key]) || !ctype_digit((string)$_GET[$key])) {
        $inCore = basename(dirname($_SERVER['SCRIPT_NAME'])) === 'core';
        header("Location: " . ($inCore ? "../index.php" : "index.php"));
        exit;
    }
    return (int)$_GET[$key];
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

/* ---------- CUSTOMERS (the "one" side) ---------- */

function insertCustomer($pdo, $username, $first_name, $last_name, $date_of_birth, $license_number) {
    $sql = "INSERT INTO customers (username, first_name, last_name, date_of_birth, license_number)
            VALUES (?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$username, $first_name, $last_name, $date_of_birth, $license_number]);
}

function getAllCustomers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM customers ORDER BY customer_id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getCustomerByID($pdo, $customer_id) {
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_id = ?");
    $stmt->execute([$customer_id]);
    return $stmt->fetch();
}

function updateCustomer($pdo, $first_name, $last_name, $date_of_birth, $license_number, $customer_id) {
    $sql = "UPDATE customers
            SET first_name = ?, last_name = ?, date_of_birth = ?, license_number = ?
            WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$first_name, $last_name, $date_of_birth, $license_number, $customer_id]);
}

function deleteCustomer($pdo, $customer_id) {
    // Delete the child rows (rentals) first, then the parent
    $stmt = $pdo->prepare("DELETE FROM rentals WHERE customer_id = ?");
    if ($stmt->execute([$customer_id])) {
        $stmt2 = $pdo->prepare("DELETE FROM customers WHERE customer_id = ?");
        return $stmt2->execute([$customer_id]);
    }
    return false;
}

/* ---------- RENTALS (the "many" side) ---------- */

function getRentalsByCustomer($pdo, $customer_id) {
    $sql = "SELECT rentals.rental_id, rentals.car_model, rentals.rental_days,
                   rentals.date_added,
                   CONCAT(customers.first_name, ' ', customers.last_name) AS customer_name
            FROM rentals
            JOIN customers ON rentals.customer_id = customers.customer_id
            WHERE rentals.customer_id = ?
            ORDER BY rentals.rental_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id]);
    return $stmt->fetchAll();
}

function insertRental($pdo, $car_model, $rental_days, $customer_id) {
    $sql = "INSERT INTO rentals (car_model, rental_days, customer_id) VALUES (?,?,?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$car_model, $rental_days, $customer_id]);
}

function getRentalByID($pdo, $rental_id) {
    $sql = "SELECT rentals.rental_id, rentals.car_model, rentals.rental_days,
                   rentals.date_added,
                   CONCAT(customers.first_name, ' ', customers.last_name) AS customer_name
            FROM rentals
            JOIN customers ON rentals.customer_id = customers.customer_id
            WHERE rentals.rental_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$rental_id]);
    return $stmt->fetch();
}

function updateRental($pdo, $car_model, $rental_days, $rental_id) {
    $sql = "UPDATE rentals SET car_model = ?, rental_days = ? WHERE rental_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$car_model, $rental_days, $rental_id]);
}

function deleteRental($pdo, $rental_id) {
    $stmt = $pdo->prepare("DELETE FROM rentals WHERE rental_id = ?");
    return $stmt->execute([$rental_id]);
}
