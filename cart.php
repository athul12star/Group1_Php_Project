<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
    <?php include 'navbar.php'; ?>
</head>
<body>
    
    <h1 class="title">Shopping Cart</h1>

    <div class="table-container">
        <?php
        if (isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])) {
            // Include your database connection file or initialize database connection here
            include 'dbinit.php';
            
            // Retrieve product IDs from the cart cookie
            $cart = unserialize($_COOKIE['cart']);
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each product ID in the cart
                    foreach ($cart as $product_id) {
                        // Query to fetch product details from the database based on product ID
                        $query = "SELECT * FROM products WHERE id = $product_id";
                        $result = mysqli_query($dbc, $query);
                        $product = mysqli_fetch_assoc($result);
                        
                        // Display product details in table rows
                        echo "<tr>";
                        echo "<td><img src='{$product['image_path']}' alt='Product Image' height='100'></td>";
                        echo "<td>{$product['name']}</td>";
                        echo "<td>{$product['price']}</td>";
                        echo "<td><form method='post'><input type='hidden' name='productId' value='$product_id'><button type='submit' name='delete'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
            // If cart is empty, display a message
            echo "<p>Your cart is empty.</p>";
        }
        ?>
    </div>

    <p><a href="checkout.php" class="button">Checkout</a></p>

    <?php
    if (isset($_POST['delete'])) {
        $productIdToDelete = $_POST['productId'];
        if (isset($_COOKIE['cart'])) {
            // Remove the product ID from the cart cookie array
            $cart = unserialize($_COOKIE['cart']);
            $key = array_search($productIdToDelete, $cart);
            if ($key !== false) {
                unset($cart[$key]);
                // Serialize the updated cart array and set it as a cookie
                setcookie('cart', serialize($cart), time() + (86400 * 30), "/"); // 30 days expiration
            }
        }
        // Redirect to refresh the page and reflect the changes
        header('Location: cart.php');
    }
    ?>
</body>
</html>