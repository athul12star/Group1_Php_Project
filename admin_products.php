<?php
require('dbinit.php');

// Delete functionality
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM products WHERE id = '$id';";
    $result = mysqli_query($dbc, $query);

    if (!$result) {
        echo "<p>Some error in deleting the record</p>";
    }
}

// Fetch updated data
$query = 'SELECT * FROM products;';
$results = @mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Product Details</title>
</head>

<body>
<?php include 'navbar.php'; ?>
<p><a class="button" href="admin_add.php">Add New Product</a></p>
    <div class="table-container">
        <table width="80%">
            <thead>
                <tr align="left">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Brand</th> 
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sr_no = 0;
                while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                    $sr_no++;
                    $str_to_print = "";
                    $str_to_print .= "<tr> <td>{$row['id']}</td>";
                    $str_to_print .= "<td> {$row['name']}</td>";
                    $str_to_print .= "<td> {$row['brand']}</td>"; 
                    $str_to_print .= "<td> {$row['description']}</td>";
                    $str_to_print .= "<td> \${$row['price']}</td>";
                    $str_to_print .= "<td> {$row['category_id']}</td>";
                    $str_to_print .= "<td><img src='{$row['image_path']}' alt='{$row['name']}' width='100' height='100'></td>";
                    $str_to_print .= "<td> <a href='edit_watch.php?id={$row['id']}'>Edit</a> | <a href='" . $_SERVER['PHP_SELF'] . "?id={$row['id']}' >Delete</a> </td> </tr>";

                    echo $str_to_print;
                }
                ?>
            </tbody>
        </table>
    </div>

    
</body>

</html>
