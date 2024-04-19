<?php
include 'dbinit.php';

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Screen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Product Screen</h1>
        <div class="product-grid">
            <?php
            // Display products in cards
            while ($row = mysqli_fetch_assoc($result)) {
                
                echo '<div class="product-card">';
                echo '<a href="details.php?id=' . $row["id"] . '" class="product-link">';
                echo '<img src="' . $row['image_path'] . '" alt="' . $row["name"] . '">';
                echo '<h3>' . $row["name"] . '</h3>';
                echo '<p>$' . $row["price"] . '</p>';
                echo '<p>$' . $row["category_id"] . '</p>';
                echo '<a href="add_to_cart.php?id=' . $row["id"] . '" class="btn">Add to Cart</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>