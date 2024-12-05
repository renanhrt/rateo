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

    if (isset($_POST["song_id"])) {
        $song = new Song(
            $_POST["title"],
            $_POST["year"],
            $_POST["artist"],
            $_POST["cover"],
            $_POST["preview_url"]
        );
        $song->setId_song($_POST["song_id"]);
        $song->save();
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
        <a href="index.php">Home</a>
        <a href="ranking.php">Ranking</a>
        <?php if ($user->getRole() === 'admin'): ?>
        <a href="add_songs.php">Add songs</a>
        <?php endif; ?>
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
                    echo "<form action='add_songs.php' method='POST'>";
                    echo "<input type='hidden' name='song_id' value='" . $song->getId_song() . "'>";
                    echo "<input type='hidden' name='title' value='" . htmlspecialchars($song->getTitle(), ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<input type='hidden' name='year' value='" . $song->getYear() . "'>";
                    echo "<input type='hidden' name='artist' value='" . htmlspecialchars($song->getArtist(), ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<input type='hidden' name='cover' value='" . htmlspecialchars($song->getCover(), ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<input type='hidden' name='preview_url' value='" . htmlspecialchars($song->getPreview_url(), ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<input type='submit' value='Add song to rateo'>";
                    echo "</form>";
                    echo "<br>";
                    echo "</div>";
                }
            }
        ?>
    </div>

</body>
</html>