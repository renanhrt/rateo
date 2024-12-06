<?php 
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();
    
    $user_id = $_SESSION["id"];
    $user = User::find($user_id);

    $song = Song::random_song($user->getId_user());
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

    <div class="main-container">
        <h1>Rateo</h1>
        <p>Rate the song below:</p>
        <div class="song song-index">
            <?php
                $score = $song->getScore();
                echo "<p>Average Score: {$score['average']}</p>";
                echo '<iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/' . $song->getId_song() . '?utm_source=generator" width="100%" height="256" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>';
                echo "<p>{$song->getTitle()} - {$song->getArtist()} ({$song->getYear()})</p>";
            ?>
            <form action="vote.php" method="post">
                <input type="hidden" name="id_song" value="<?php echo $song->getId_song(); ?>">
                <input type="hidden" name="id_user" value="<?php echo $user_id; ?>">
                <div class="rating-buttons">
                    <input type="radio" id="rating1" name="vote_number" value="1">
                    <label for="rating1">1</label>

                    <input type="radio" id="rating2" name="vote_number" value="2">
                    <label for="rating2">2</label>

                    <input type="radio" id="rating3" name="vote_number" value="3">
                    <label for="rating3">3</label>

                    <input type="radio" id="rating4" name="vote_number" value="4">
                    <label for="rating4">4</label>

                    <input type="radio" id="rating5" name="vote_number" value="5">
                    <label for="rating5">5</label>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-about">
                <p>&copy; 2024 Your Website. All Rights Reserved.</p>
                <p>Crafted by Renan, Davi, Enzo and Joao.</p>
            </div>
        </div>
    </footer>
</body>
</html>
