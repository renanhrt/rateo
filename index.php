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
    <title>Rateo</title>
</head>
<body>
    <a href="add_songs.php">Add songs</a>
</body>
</html>
