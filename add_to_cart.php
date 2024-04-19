<?php
// Check if the product ID is set in the URL
if(isset($_GET['id'])) {
    // Get the product ID from the URL
    $product_id = $_GET['id'];
    
    // Add the product ID to the cart cookie
    // First, check if the cart cookie is already set
    if(isset($_COOKIE['cart'])) {
        // If cart cookie is set, unserialize it and add the new product ID
        $cart = unserialize($_COOKIE['cart']);
        // Check if the product ID is already in the cart to avoid duplicates
        if(!in_array($product_id, $cart)) {
            $cart[] = $product_id;
        }
    } else {
        // If cart cookie is not set, create a new array with the product ID
        $cart = array($product_id);
    }
    // Serialize the cart array and set it as a cookie
    setcookie('cart', serialize($cart), time() + (86400 * 30), "/"); // 30 days expiration
}

// Redirect back to the previous page (or any other page you want)
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>