<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to signin.php if not logged in
    header("Location: signin.php");
    exit();
}

// Delete all cookies
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 3600, '/'); // Set the expiration time to the past
}

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Order Confirmed!</h1>
        <p class="confirmation-message">Thank you for your order.</p>
        <a href="home.php" class="button">Continue Shopping</a>
    </div>
</body>
</html>

