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
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add songs</title>
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

    <form action="" method="POST" class="search-form">
        <input type="text" name="search_text" placeholder="Search song or artist...">
        <input type="submit" value="Search">
    </form>

    <div class="songs">
        <?php
            if (isset($songs)) {
                foreach ($songs as $song) {
                    echo "<div class='song'>";
                    echo '<iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/' . $song->getId_song() . '?utm_source=generator" width="60%" height="256" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>';
                    echo "<a href='add_song.php?song_id=" . $song->getId_song() . "'>Add song to rateo</a>";
                    echo "<br>";
                    echo "</div>";
                }
            }
        ?>
    </div>

</body>
</html>