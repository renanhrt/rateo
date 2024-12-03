<?php
    require_once __DIR__ . "/vendor/autoload.php";

    if (isset($_POST["email"] , $_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = User::login($email, $password);
        
        if ($user) {
            session_start();
            $_SESSION["id"] = $user->getId_user();
            header("Location: index.php");
        } else {
            echo "Invalid email or password";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Screen</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group" action="">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            Don't have an account?<a href="register.php"> Register Here.</a>
        </div>
        <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>