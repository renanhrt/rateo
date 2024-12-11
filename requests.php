<?php
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();

    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["id"];
    $user = User::find($user_id);

    $songs = [];

    # Only admin can access this page
    if ($user->getRole() != "user") {
        header("Location: index.php");
    }

    # Search song in Spotify
    if (isset($_GET["search_text"])) {
        $songs = Song::searchSongSpotify($_GET["search_text"]);
    }

    # Add song to rateo and create request
    if (isset($_POST["song_id"])) {
        $songs = Song::searchSongSpotify($_POST["search_text"]);
        $_GET["search_text"] = $_POST["search_text"];
        $song = new Song(
            $_POST["title"],
            $_POST["year"],
            $_POST["artist"],
            $_POST["cover"],
            1
        );
        $song->setId_song($_POST["song_id"]);
        $song->save();

        $request = new Request($user->getId_user(), $_POST["song_id"]);
        $request->save();
    }

    # Remove request from rateo
    if (isset($_POST["remove_request_id"])) {
        $songs = Song::searchSongSpotify($_POST["search_text"]);
        $_GET["search_text"] = $_POST["search_text"];
        $request = Request::find($_POST["remove_request_id"]);
        $request->delete();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Requests</title>
    <link rel="icon" href="logo.webp" type="image/x-icon">
</head>
<body>
    <header class="header">
        <div class="logo">Rateo</div>
        <nav>
        <a href="index.php">Home</a>
        <a href="ranking.php">Ranking</a>
        <?php if ($user->getRole() === 'admin'): ?>
            <a href="add_songs.php">Add songs</a>
            <a href="remove_songs.php">Remove songs</a>
            <a href="manage_requests.php">Manage Requests</a>
        <?php endif; ?>
        <?php if ($user->getRole() === 'user'): ?>
            <a href="requests.php">Requests</a>
        <?php endif; ?>
        </nav>
        <div class="user">
            <span><?php echo $user->getUsername(); ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="main-container">
        <div class="songs">
            <form action="" method="GET" class="search-form">
                <input type="text" name="search_text" placeholder="Search for a song or artist...">
                <input type="submit" value="Search" class="submit-input search-input">
            </form>
            <?php
                if (isset($songs)) {
                    foreach ($songs as $song) {
                        $exists = Song::find($song->getId_song());
                        echo "<div class='song'>";
                
                        echo '<iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/' . $song->getId_song() . '?utm_source=generator" width="100%" height="256" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>';
                        
                        $request = Request::findByUserAndSong($user->getId_user(), $song->getId_song());
                        if ($exists && $exists->getIs_request() == 0) {
                            echo "<p>Song is already on rateo.</p>";
                        } else if ($exists && $request) {
                            echo "<form action='requests.php' method='POST'>";
                            echo "<input type='hidden' name='remove_request_id' value='" . $request->getId_request() . "'>";
                            echo "<input type='hidden' name='search_text' value='" . $_GET["search_text"] . "'>";
                            echo "<input type='submit' value='Remove request' class='submit-input remove'>";
                            echo "</form>";
                        } else {
                            echo "<form action='requests.php' method='POST'>";
                            echo "<input type='hidden' name='song_id' value='" . $song->getId_song() . "'>";
                            echo "<input type='hidden' name='title' value='" . htmlspecialchars($song->getTitle(), ENT_QUOTES, 'UTF-8') . "'>";
                            echo "<input type='hidden' name='year' value='" . $song->getYear() . "'>";
                            echo "<input type='hidden' name='artist' value='" . htmlspecialchars($song->getArtist(), ENT_QUOTES, 'UTF-8') . "'>";
                            echo "<input type='hidden' name='cover' value='" . htmlspecialchars($song->getCover(), ENT_QUOTES, 'UTF-8') . "'>";
                            echo "<input type='hidden' name='is_request' value='" . htmlspecialchars($song->getIs_request(), ENT_QUOTES, 'UTF-8') . "'>";
                            echo "<input type='hidden' name='search_text' value='" . $_GET["search_text"] . "'>";
                            echo "<input type='submit' value='Create song request' class='submit-input add'>";
                            echo "</form>";
                        }
                
                        echo "</div>";
                    }
                }
            ?>

            <?php if (count($songs) == 0): ?>
                <p>Search for a song to request to be added...</p>
            <?php endif; ?>
        </div>
    </div>
    
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-about">
                <br>
                <p>&copy; 2024 Rateo. All Rights Reserved.</p>
                <p>Crafted by Renan, Davi, Enzo and Joao.</p>
                <br>
            </div>
        </div>
    </footer>
</body>
</html>