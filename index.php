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
    
    <div class="song">
        <iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/<?php echo $song->getId_song(); ?>?utm_source=generator" width="60%" height="512px" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
        <form action="vote.php" method="post">
            <input type="hidden" name="id_song" value="<?php echo $song->getId_song(); ?>">
            <input type="hidden" name="id_user" value="<?php echo $user_id; ?>">
            <label for="vote_number">Rate this song:</label>
            <select name="vote_number" id="vote">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <button type="submit">Submit</button>
        </form>
    </div>

</body>
</html>
