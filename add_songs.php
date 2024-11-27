<?php
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();

    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["id"];

    $user = User::find($user_id);

    //if ($user->getRole() != "admin") {
    //    header("Location: index.php");
    //}

    if (isset($_POST["search_text"])) {
        $songs = Song::searchSongSpotify($_POST["search_text"]);

        foreach ($songs as $song) {
            echo "<p>{$song->getTitle()} - {$song->getArtist()} <a href='add_song.php?id={$song->getId_song()}'>Add</a></p>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add songs</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="search_text" placeholder="Search song or artist...">
        <input type="submit" placeholder="search">
    </form>
</body>
</html>