<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('dbinit.php');
    $errors = [];

    // Form Validations
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = null;
        $errors[] = "<p>Email is required!</p>";
    }

    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = null;
        $errors[] = "<p>Password is required!</p>";
    }

    if (count($errors) == 0) {
        $email_clean = prepare_string($dbc, $email);
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($dbc, $query);

        mysqli_stmt_bind_param($stmt, 'ss', $email_clean, $password_hashed);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<p>Data successfully saved!</p>";
            header("Location: signin.php");
            exit;
        } else {
            echo "<p>Error in saving the data!</p>";
        }
    } else {
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
    <title>Signup</title>
</head>

<body>
    <h1 class="title-left1">Sign Up</h1>

    <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="subtitle">Enter Your Details:</div>
        <div class="input-container ic2">
            <input type="email" class="input" id="email" name="email" required>
            <div class="cut"></div>
            <label for="email" class="placeholder">Email</label>
        </div>
        <div class="input-container ic2">
            <input type="password" class="input" id="password" name="password" required>
            <div class="cut"></div>
            <label for="password" class="placeholder">Password</label>
        </div>
        <button type="submit" class="submit">Sign Up</button>
    </form>
</body>

</html>
