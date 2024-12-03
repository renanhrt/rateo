<?php 
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();
    
    $user_id = $_SESSION["id"];
    $user = User::find($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Rateo</title>
</head>
<body>
    <header class="header">
        <div class="logo">Rateo</div>
        <nav>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#contact">Contact</a>
        </nav>
        <div class="user">
            <span><?php echo $user->getUsername(); ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <a href="add_songs.php">Add songs</a>
</body>
</html>
