<?php
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'watch_shop');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die('Could not connect to MySQL: ' . mysqli_connect_error());

mysqli_set_charset($dbc, 'utf8');

function prepare_string($dbc, $string) {
    $string_trimmed = trim($string);
    $string = mysqli_real_escape_string($dbc, $string_trimmed);
    return $string;
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS buddies_watch_shop";
if ($dbc->query($sql) === TRUE) {
    //echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $dbc->error;
}

// Select database
$dbc->select_db("buddies_watch_shop");

// Create table users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL
)";
if ($dbc->query($sql) === TRUE) {
    
} else {
    echo "Error creating table: " . $dbc->error;
}

// Create table categories
$sql = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL
)";
if ($dbc->query($sql) === TRUE) {
    
} else {
    echo "Error creating table: " . $dbc->error;
}

// Insert categories
$sql = "INSERT INTO categories (name) SELECT * FROM (SELECT 'Luxury') AS tmp WHERE NOT EXISTS (SELECT name FROM categories WHERE name = 'Luxury')";
$dbc->query($sql);

$sql = "INSERT INTO categories (name) SELECT * FROM (SELECT 'Sports') AS tmp WHERE NOT EXISTS (SELECT name FROM categories WHERE name = 'Sports')";
$dbc->query($sql);

$sql = "INSERT INTO categories (name) SELECT * FROM (SELECT 'Fashion') AS tmp WHERE NOT EXISTS (SELECT name FROM categories WHERE name = 'Fashion')";
$dbc->query($sql);

$sql = "INSERT INTO categories (name) SELECT * FROM (SELECT 'Smart') AS tmp WHERE NOT EXISTS (SELECT name FROM categories WHERE name = 'Smart')";
$dbc->query($sql);

$sql = "INSERT INTO categories (name) SELECT * FROM (SELECT 'Vintage') AS tmp WHERE NOT EXISTS (SELECT name FROM categories WHERE name = 'Vintage')";
$dbc->query($sql);
if ($dbc->query($sql) === TRUE) {
    
} else {
    echo "Error inserting data: " . $dbc->error;
}

// Create table products
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL,
    description text DEFAULT NULL,
    price decimal(10,2) NOT NULL,
    category_id int(11) DEFAULT NULL,
    image_path varchar(255) DEFAULT NULL,
    brand varchar(250) NOT NULL
)";
if ($dbc->query($sql) === TRUE) {
    
} else {
    echo "Error creating table: " . $dbc->error;
}


// Check if any rows exist in the products table
$sql = "SELECT COUNT(*) as count FROM products";
$result = mysqli_query($dbc, $sql);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];


if ($count == 0) {
// Prepare your images
    $image_paths = array(
        'img/Rolex Submariner.jpg',
        'img/Patek_Philippe_Nautilus.jpg',
        'img/Audemars_Piguet_Royal_Oak.jpg',
        'img/Garmin_Fenix_6.jpg',
        'img/Suunto_9_Baro.jpg',
        'img/Casio_G-Shock_Mudmaster.jpg',
        'img/Michael Kors Lexington.jpg',
        'img/Fossil Gen 5 Carlyle.jpg',
        'img/Daniel Wellington Classic Petite.jpeg',
        'img/Apple Watch Series 7.jpg',
    );

    $product_data = array(
        array('name' => 'Rolex Submariner', 'description' => 'The Submariner is an iconic timepiece whose renown now extends beyond the professional world it was first designed for. The Submariner, the ultimate standard.', 'price' => 10000.00, 'category_id' => 1, 'brand' => 'Rolex'),
        array('name' => 'Patek Philippe Nautilus', 'description' => 'With the rounded octagonal shape of its bezel, the ingenious porthole construction of its case, and its horizontally embossed dial, the Nautilus has epitomized the elegant sports watch since 1976. Forty years later, it comprises a splendid collection of models for men and women.', 'price' => 30000.00, 'category_id' => 1, 'brand' => 'Lux'),
        array('name' => 'Royal Oak', 'description' => 'Characterized by its eight-sided bezel punctuated with exposed screws, hobnail dial, and integrated bracelet, the Royal Oak is an iconic watch design. The Royal Oak celebrates its 50th anniversary this year and as expected, Audemars Piguet has announced a slew of new models and references to celebrate the occasion.', 'price' => 25000.00, 'category_id' => 1, 'brand' => 'Audemars Piguet'),
        array('name' => 'Fenix 6', 'description' => 'These rugged fēnix multisport GPS watches let you add mapping, music, intelligent pace planning and more to your workouts — so you can take any challenge in stride. It\\\'s your body. Know it better with wrist-based heart rate1 and Pulse Ox2. Battery life doesn\\\'t limit you.', 'price' => 600.00, 'category_id' => 2, 'brand' => 'Garmin'),
        array('name' => '9 Baro', 'description' => 'Suunto 9 is a multisport GPS watch designed for athletes who demand the best from their sports watch. Intelligent battery life management system with smart reminders ensures your watch will last just as long as you need it to. The robust Suunto 9 is made for long, arduous training and racing and extreme adventures.', 'price' => 500.00, 'category_id' => 2, 'brand' => 'Suunto'),
        array('name' => 'G-Shock Mudmaster', 'description' => 'It comes with Multi-Band 6 Atomic Timekeeping and Triple Sensor capabilities (altimeter/barometer, compass, and thermometer), ensuring that you\\\'re never off-course. The Vibration Resistant Structure adds an extra layer of durability, especially for those in seismic research fields or construction.', 'price' => 199.00, 'category_id' => 2, 'brand' => 'Casio'),
        array('name' => 'Lexington', 'description' => 'Designed with the aspirational man in mind, our Lexington watch brings sleek and streamlined to a whole new level. The beveled gold-tone stainless steel bezel and bracelet strap provide tactile texture, while the date function and chronograph dials complete a dynamic piece.', 'price' => 249.00, 'category_id' => 3, 'brand' => 'Michael Kors'),
        array('name' => 'Gen 5 Carlyle', 'description' => 'This 44mm Carlyle HR touchscreen smartwatch features a black silicone strap, speaker functionality, increased storage capacity and three smart battery modes to extend battery life for multiple days. Smartwatches powered with Wear OS by Google are compatible with iPhone® and Android™ phones.', 'price' => 299.00, 'category_id' => 3, 'brand' => 'Fossil'),
        array('name' => 'Classic Petite', 'description' => 'A TIMELESS CLASSIC. Petite Melrose features an eggshell white dial and an undeniably elegant rose gold mesh strap. This watch elevates your everyday outfit, your mood and your spirit.', 'price' => 149.00, 'category_id' => 3, 'brand' => 'Daniel Wellington'),
        array('name' => 'Watch Series 7', 'description' => 'Series 7 is the most durable Apple Watch ever built. Fundamental design changes were needed to achieve the vision of the larger Always-On Retina display. These same innovations also helped make the most crack-resistant front crystal yet. Crack ResistantOur strongest front crystal ever.', 'price' => 399.00, 'category_id' => 4, 'brand' => 'Apple'),
    );

    // Insert data into the table
    for ($i = 0; $i < count($image_paths); $i++) {
        $image_path = $image_paths[$i];
        $product = $product_data[$i];

        // Upload image to the server and get the path
        $image_filename = basename($image_path);
        $target_path = "img/" . $image_filename;
        if (!file_exists($target_path)) {
            // Copy the image to the target directory
            if (!copy($image_path, $target_path)) {
                echo "Failed to copy $image_path...\n";
                continue;
            }
        }

        // Insert product into the database
        $sql = "INSERT INTO products (name, description, price, category_id, image_path, brand) VALUES (
            '{$product['name']}', '{$product['description']}', {$product['price']}, {$product['category_id']}, '$target_path', '{$product['brand']}'
        )";

        if ($dbc->query($sql) === TRUE) {
            //echo "Data inserted successfully\n";
        } else {
            echo "Error inserting data: " . $dbc->error;
        }
    }
} else {
    //echo "Data already exists in the products table.";
}
// Close the database connection
//$dbc->close();
?>