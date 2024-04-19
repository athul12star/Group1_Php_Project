<?php
include 'dbinit.php';

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    $query = "SELECT * FROM products WHERE id = $product_id";
    
    $result = mysqli_query($dbc, $query);
    
    $product = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $product["name"]; ?></h1>
        <div class="product-details">
            <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product["name"]; ?>">
            <p><?php echo $product["description"]; ?></p>
            <p>$<?php echo $product["price"]; ?></p>
            <a href="cart.php?id=<?php echo $product['id']; ?>" class="btn">Add to Cart</a>
        </div>
    </div>
</body>
</html>