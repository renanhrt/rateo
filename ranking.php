<?php
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();

    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["id"];
    $user = User::find($user_id);

    $songs = Song::ranking("new");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rateo Ranking</title>
    <link rel="stylesheet" href="styles.css">
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
    
    <div class="songs">
        <?php
            if (isset($songs)) {
                foreach ($songs as $index => $song): 
                    $position = $index + 1; 
                    $score = $song->getScore(); 
                ?>
                    <div class="song">
                        <div class="stats">
                            <div class="stat-box">
                                <span class="stat-title">Average</span>
                                <span class="stat-value"><?= $score['average']; ?></span>
                            </div>
                            <div class="stat-box">
                                <span class="stat-title">Position</span>
                                <span class="stat-value">#<?= $position; ?></span>
                            </div>
                            <div class="stat-box">
                                <span class="stat-title">Votes</span>
                                <span class="stat-value"><?= $score['total_votes']; ?></span>
                            </div>
                        </div>
                
                        <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/<?= $song->getId_song(); ?>?utm_source=generator" width="100%" height="256" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy">
                        </iframe>
                
                        <p><?= $song->getTitle(); ?> - <?= $song->getArtist(); ?> (<?= $song->getYear(); ?>)</p>
                    </div>
                <?php 
                endforeach; 
            }
        ?>

        <?php if (count($songs) == 0): ?>
            <p>Search for a song to add...</p>
        <?php endif; ?>
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