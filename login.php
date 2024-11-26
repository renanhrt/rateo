<?php
    require_once __DIR__ . "/vendor/autoload.php";

    if (isset($_POST["button"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = new User($username, $email, $password);
        $user->save();
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
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <a href="register.php">Don't have an account? Register Here.</a>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>