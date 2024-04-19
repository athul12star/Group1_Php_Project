<?php
require('dbinit.php'); // Assuming this file contains database connection and helper functions
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Form Validations
    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $errors[] = "<p>Watch Name is required!</p>";
    }

    if (!empty($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $errors[] = "<p>Description is required!</p>";
    }

    if (!empty($_POST['price'])) {
        $price = $_POST['price'];
    } else {
        $errors[] = "<p>Price is required!</p>";
    }

    if (!empty($_POST['category_id'])) {
        $category_id = $_POST['category_id'];
    } else {
        $errors[] = "<p>Category is required!</p>";
    }

    if (!empty($_POST['brand'])) {
        $brand = $_POST['brand'];
    } else {
        $errors[] = "<p>Brand is required!</p>";
    }

    // Image Processing
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES["image_path"]["name"]);
        $image_path = "img/" . $image_name;
        if (move_uploaded_file($_FILES['image_path']['tmp_name'], $image_path)) {
            // Image uploaded successfully
        } else {
            $errors[] = "<p>Image upload failed!</p>";
        }
    } else {
        $errors[] = "<p>Image is required!</p>";
    }

    // If no errors, proceed with database insertion
    if (empty($errors)) {
        $name_clean = prepare_string($dbc, $name);
        $description_clean = prepare_string($dbc, $description);
        $price_clean = prepare_string($dbc, $price);
        $category_id_clean = prepare_string($dbc, $category_id);
        $brand_clean = prepare_string($dbc, $brand);

        $query = "INSERT INTO products (name, description, price, category_id, image_path, brand) VALUES (?,?,?,?,?,?)";

        $stmt = mysqli_prepare($dbc, $query);

        mysqli_stmt_bind_param(
            $stmt,
            'sssiss',
            $name_clean,
            $description_clean,
            $price_clean,
            $category_id_clean,
            $image_path,
            $brand_clean
        );

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("Location: admin_add.php");
            exit;
        } else {
            echo "<p>Error in saving the data!</p>";
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo $error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add New Watch</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <h1 class="title-left1">Add New</h1>
    <h1 class="title-left2">WATCH</h1>
    <p><a class="button2" href="admin_products.php">View All Watches</a></p>
    <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" id="watch_insert_form">
        <div class="subtitle">Enter Watch Details:</div>
        <div class="input-container ic2">
            <input type="text" class="input" id="name" name="name" />
            <div class="cut"></div>
            <label for="name" class="placeholder">Watch Name</label>
        </div>

        <div class="input-container ic2">
            <input type="text" class="input" id="brand" name="brand" />
            <div class="cut"></div>
            <label for="brand" class="placeholder">Brand</label>
        </div>

        <div class="input-container ic2">
            <textarea class="input" id="description" name="description"></textarea>
            <div class="cut"></div>
            <label for="description" class="placeholder">Description</label>
        </div>
        <div class="input-container ic2">
            <input type="number" class="input" id="price" name="price" />
            <div class="cut"></div>
            <label for="price" class="placeholder">Price</label>
        </div>
        <div class="input-container ic2">
            <select class="input" id="category_id" name="category_id">
                <?php
                $query = "SELECT id, name FROM categories";
                $result = mysqli_query($dbc, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <div class="cut"></div>
            <label for="category_id" class="placeholder">Category</label>
        </div>

        <div class="input-container ic2">
            <input type="file" class="input" id="image_path" name="image_path" accept="img/*" />
            <div class="cut"></div>
            <label for="image_path" class="placeholder">Upload Image</label>
        </div>
        <button type="submit" class="submit">Add Product</button>
    </form>
</body>

</html>