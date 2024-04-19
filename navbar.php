<?php

session_start();
// Check if the user is logged in and their role
$is_logged_in = false; // Set to true if user is logged in
$is_admin = false; // Set to true if user is an admin

// Example of authentication logic (replace this with your actual authentication logic)
if(isset($_SESSION['user_id'])) {
    // User is logged in
    $is_logged_in = true;

    // Check if the user is an admin (you would replace this with your actual admin role check)
    if($_SESSION['user_id'] == 'admin@gmail.com') {
        $is_admin = true;
    }
}

// Function to logout the user
function logout() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or homepage
    header("Location: home.php");
    exit;
}

// Check if the user clicked on the logout link
if(isset($_GET['logout'])) {
    logout();
}
?>

<nav>
    <div class="logo">
        <img src="img/logo.png" alt="Logo">
        <!-- <h1> Buddies Watch House </h1> -->
    </div>
    <ul>
        <li><a href="home.php">Home</a></li>
        <?php if ($is_logged_in) { ?>
            <?php if ($is_admin) { ?>
                <li><a href="admin_add.php">Admin</a></li>
                <li><a href="?logout=1">Logout</a></li>
            <?php } else { ?>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="?logout=1">Logout</a></li>
            <?php } ?>
        <?php } else { ?>
            <li><a href="products.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="signin.php">Login</a></li>
        <?php } ?>
    </ul>
</nav>