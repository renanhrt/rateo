<?php
    require_once __DIR__ . "/vendor/autoload.php";

    if (isset($_POST["username"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = "user";
        
        try {
            $user = new User($username, $email, $password, $role);
            $user->save();
            header("Location: login.php");
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Rateo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-body">
    <div class="login-container">
    <h2>Register</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="username" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
        Already have an account? <a href="login.php">Login Here.</a>
        </div>
        <?php if (isset($error)): ?>
            <div class="error">
                <p class="error"><?php echo $error; ?></p>
            </div>
        <?php endif; ?>
        <button type="submit" name="button">Register</button>
    </form>
  </div>
</body>
</html>