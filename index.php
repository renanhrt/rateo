<?php 
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();
    
    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["id"];
    $user = User::find($user_id);

    $song = Song::random_song($user->getId_user());

    if (isset($song)) {
        $score = $song->getScore();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="logo.webp" type="image/x-icon">
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
        <div class="song song-index">
            <?php if (isset($song)): ?>
                <div class="stats">
                    <div class="stat-box">
                        <span class="stat-title">Average</span>
                        <span class="stat-value"><?= $score['average']; ?></span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-title">Votes</span>
                        <span class="stat-value"><?= $score['total_votes']; ?></span>
                    </div>
                </div>
                <?php
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
            <?php else: ?>
                <p>You've already rated all songs. 👍</p>
                <a href="ranking.php">Go to Ranking</a>
                <?php if ($user->getRole() === 'admin'): ?>
                <br>
                <a href="manage_requests.php">Manage Requests</a>
                <br>
                <a href="add_songs.php">Add new songs</a>
                <?php endif; ?>

                <?php if ($user->getRole() === 'user'): ?>
                <br>
                <a href="requests.php" class="alink">Request new songs</a>
                <?php endif; ?>
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
