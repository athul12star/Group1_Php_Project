<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Add your CSS stylesheets here -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Include the navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Auto-sliding images -->
    <div class="slideshow-container">
        <input type="radio" name="slide" id="slide1" checked>
        <input type="radio" name="slide" id="slide2">
        <input type="radio" name="slide" id="slide3">
        <input type="radio" name="slide" id="slide4">
        
        <div class="slides">
            <div class="slide" id="slide1">
                <img src="img/slide1.jpg" alt="Slide 1">
            </div>
            <div class="slide" id="slide2">
                <img src="img/slide2.jpg" alt="Slide 2">
            </div>
            <div class="slide" id="slide3">
                <img src="img/slide3.jpg" alt="Slide 3">
            </div>
            <div class="slide" id="slide4">
                <img src="img/slide4.jpg" alt="Slide 4">
            </div>
        </div>

        <div class="navigation">
            <label for="slide1"></label>
            <label for="slide2"></label>
            <label for="slide3"></label>
            <label for="slide4"></label>
        </div>
    </div>

    <!-- Connect to database -->
    <?php 
        include 'dbinit.php'; // Include the database initialization file
        // Your PHP code using $dbc goes here
    ?>
</body>
</html>