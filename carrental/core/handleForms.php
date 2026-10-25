<?php
require_once __DIR__ . '/dbConfig.php';
require_once __DIR__ . '/models.php';

/* ---------- CUSTOMERS (the "one" side) ---------- */

if (isset($_POST['insertCustomerBtn'])) {
    $query = insertCustomer($pdo, $_POST['username'], $_POST['firstName'],
        $_POST['lastName'], $_POST['dateOfBirth'], $_POST['license_number']);

    if ($query) { header("Location: ../index.php"); exit; }
    echo "Insertion failed";
}

if (isset($_POST['editCustomerBtn'])) {
    $query = updateCustomer($pdo, $_POST['firstName'], $_POST['lastName'],
        $_POST['dateOfBirth'], $_POST['license_number'], requireId('customer_id'));

    if ($query) { header("Location: ../index.php"); exit; }
    echo "Edit failed";
}

if (isset($_POST['deleteCustomerBtn'])) {
    $query = deleteCustomer($pdo, requireId('customer_id'));

    if ($query) { header("Location: ../index.php"); exit; }
    echo "Deletion failed";
}

/* ---------- RENTALS ---------- */

if (isset($_POST['insertNewRentalBtn'])) {
    $customerId = requireId('customer_id');
    $query = insertRental($pdo, $_POST['carModel'], $_POST['rental_days'], $customerId);

    if ($query) { header("Location: ../viewrentals.php?customer_id=" . $customerId); exit; }
    echo "Insertion failed";
}

if (isset($_POST['editRentalBtn'])) {
    $customerId = requireId('customer_id');
    $query = updateRental($pdo, $_POST['carModel'], $_POST['rental_days'], requireId('rental_id'));

    if ($query) { header("Location: ../viewrentals.php?customer_id=" . $customerId); exit; }
    echo "Update failed";
}

if (isset($_POST['deleteRentalBtn'])) {
    $customerId = requireId('customer_id');
    $query = deleteRental($pdo, requireId('rental_id'));

    if ($query) { header("Location: ../viewrentals.php?customer_id=" . $customerId); exit; }
    echo "Deletion failed";
}
