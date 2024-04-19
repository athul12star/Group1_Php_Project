<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('dbinit.php');

    // Form Validations
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email_clean = prepare_string($dbc, $email);

    $query = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 's', $email_clean);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $email_result, $hashed_password);
        mysqli_stmt_fetch($stmt);

        
        if (password_verify($password, $hashed_password)) {
            
            session_regenerate_id();
            $_SESSION['user_id'] = $email_result;
           
            header("Location: home.php");
            exit;
        } else {
            echo "<p>Incorrect email or password. Please try again.</p>";
        }
    } else {
        echo "<p>Incorrect email or password. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign In</title>
</head>

<body>
    <h1 class="title-left1">Sign In</h1>

    <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="subtitle">Enter Your Credentials:</div>
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
        <button type="submit" class="submit">Sign In</button>
        <button type="button" onclick="window.location.href='signup.php';" class="submit">Sign Up</button>
    </form>
</body>

</html>