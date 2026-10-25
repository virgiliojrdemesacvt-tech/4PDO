<?php
require_once __DIR__ . '/core/dbConfig.php';
require_once __DIR__ . '/core/models.php';
$customers = getAllCustomers($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome To The Car Rental System. Register new Customers!</h1>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </p>
        <p>
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" id="firstName" required>
        </p>
        <p>
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" id="lastName" required>
        </p>
        <p>
            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" name="dateOfBirth" id="dateOfBirth" required>
        </p>
        <p>
            <label for="license_number">License Number</label>
            <input type="text" name="license_number" id="license_number" required>
            <input type="submit" name="insertCustomerBtn" value="Add Customer">
        </p>
    </form>

    <h2>Registered Customers</h2>
    <?php if (count($customers) === 0) { ?>
        <p>No customers yet. Add one above.</p>
    <?php } ?>

    <?php foreach ($customers as $row) { ?>
    <div class="container">
        <h3>Username: <?php echo e($row['username']); ?></h3>
        <h3>First Name: <?php echo e($row['first_name']); ?></h3>
        <h3>Last Name: <?php echo e($row['last_name']); ?></h3>
        <h3>Date Of Birth: <?php echo e($row['date_of_birth']); ?></h3>
        <h3>License Number: <?php echo e($row['license_number']); ?></h3>
        <h3>Date Added: <?php echo e($row['date_added']); ?></h3>

        <div class="editAndDelete">
            <a href="viewrentals.php?customer_id=<?php echo (int)$row['customer_id']; ?>">View Rentals</a>
            <a href="editcustomer.php?customer_id=<?php echo (int)$row['customer_id']; ?>">Edit</a>
            <a href="deletecustomer.php?customer_id=<?php echo (int)$row['customer_id']; ?>">Delete</a>
        </div>
    </div>
    <?php } ?>
</body>
</html>
