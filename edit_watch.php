<?php
require('dbinit.php');

$errors = [];
$id = $name = $description = $price = $category_id = $image_path = $brand = null; // Initialize brand variable

function uploadImage($image_path, $image_name)
{
    $target_dir = "img/";
    $target_file = $target_dir . $image_name;

    // Check if the upload directory exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image_path['tmp_name'], $target_file)) {
        return $target_file;
    } else {
        return null;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Handle GET request to populate the form
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM products WHERE id = $id;";
        $result = @mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $category_id = $row['category_id'];
            $brand = $row['brand']; // Populate brand variable
            $image_path = $row['image_path'];
        } else {
            $errors[] = "<p>Error! Watch details not found.</p>";
        }
    } else {
        $errors[] = "<p>Error! Watch ID not provided.</p>";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle POST request to update the data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $brand = $_POST['brand']; // Get brand from form data
    $image_path = $_FILES['image_path'];
    $image_name = basename($image_path['name']);
    $uploaded_image_path = uploadImage($image_path, $image_name);
    if ($uploaded_image_path) {
        $image_path = $uploaded_image_path;
    } else {
        $errors[] = "<p>Error! Failed to upload the image.</p>";
    }

    // Form Validation
    // Validation logic for name, description, price, category_id, and image_path remains the same

    if (count($errors) == 0) {
        $id_clean = prepare_string($dbc, $id);
        $name_clean = prepare_string($dbc, $name);
        $description_clean = prepare_string($dbc, $description);
        $price_clean = prepare_string($dbc, $price);
        $category_id_clean = prepare_string($dbc, $category_id);
        $brand_clean = prepare_string($dbc, $brand); // Clean brand input

        $query = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image_path = ?, brand = ? WHERE  id = ?;";
        $stmt = mysqli_prepare($dbc, $query);

        mysqli_stmt_bind_param(
            $stmt,
            'sssissi', // Adjust parameter types accordingly
            $name_clean,
            $description_clean,
            $price_clean,
            $category_id_clean,
            $image_path,
            $brand_clean, // Bind brand parameter
            $id_clean
        );

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header("Location: admin_products.php");
            exit;
        } else {
            $errors[] = "<p>Some error in updating the data</p>";
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
    <title>Update Watch Details</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    }
    ?>

    <h1 class="title-left1">Update Watch </h1>
    <h1 class="title-left2">DETAILS</h1>
    <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="edit_update_watch_form">
        <div class="subtitle">Enter Values to be Updated:</div>
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
        <div class="input-container ic2">
            <input type="text" class="input" id="name" name="name" value="<?php echo $name; ?>" />
            <div class="cut"></div>
            <label for="name" class="placeholder">Watch Name</label>
        </div>

        <div class="input-container ic2">
            <input type="text" class="input" id="brand" name="brand" value="<?php echo $brand; ?>" />
            <div class="cut"></div>
            <label for="brand" class="placeholder">Brand</label>
        </div>
        <div class="input-container ic2">
            <textarea class="input" id="description" name="description"><?php echo $description; ?></textarea>
            <div class="cut"></div>
            <label for="description" class="placeholder">Description</label>
        </div>
        <div class="input-container ic2">
            <input type="number" class="input" id="price" name="price" value="<?php echo $price; ?>" />
            <div class="cut"></div>
            <label for="price" class="placeholder">Price</label>
        </div>
        <div class="input-container ic2">
            <select class="input" id="category_id" name="category_id">
                <?php
                $query = "SELECT id, name FROM categories";
                $result = mysqli_query($dbc, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $selected = ($row['id'] == $category_id) ? "selected" : "";
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
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
        <button type="submit" class="submit">Update Product</button>
    </form>
</body>

</html>
