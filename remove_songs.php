<?php
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();

    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["id"];
    $user = User::find($user_id);

    # Only admin can access this page
    if ($user->getRole() != "admin") {
        header("Location: index.php");
    }

    if (isset($_POST["remove_song_id"])) {
        $song = Song::find($_POST["remove_song_id"]);
        if ($song) {
            $song->delete();
        }
    }

    $songs = Song::findAll();

    # Search song in Spotify
    if (isset($_GET["search_text"])) {
        $songs = Song::searchSongs($_GET["search_text"]);
    }

    # Remove song from rateo
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="logo.webp" type="image/x-icon">
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
                
                        if ($exists) {
                            echo "<form action='remove_songs.php' method='POST'>";
                            echo "<input type='hidden' name='remove_song_id' value='" . $song->getId_song() . "'>";
                            echo "<input type='submit' value='Remove song from rateo' class='submit-input remove'>";
                            echo "</form>";
                        } 

                        echo "</div>";
                    }
                }
            ?>

            <?php if (count($songs) == 0): ?>
                <p>No songs added...</p>
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