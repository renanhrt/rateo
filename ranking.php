<?php
    require_once __DIR__ . "/vendor/autoload.php";

    session_start();

    if (!isset($_SESSION["id"])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION["id"];
    $user = User::find($user_id);

    if (!isset($_GET["filter"])) {
        $_GET["filter"] = "votes";
        $_GET["order"] = "desc";
    }

    $songs = Song::ranking($_GET["filter"], $_GET["order"]);

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
        <?php if ($user->getRole() === 'admin'): ?>
            <a href="requests.php">Requests</a>
        <?php endif; ?>
        </nav>
        <div class="user">
            <span><?php echo $user->getUsername(); ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </header>
    
    <div class="main-container">
        <h1 class="ranktitle">Ranking</h1>
        <div class="filters">
            <form action="ranking.php" method="get">
                <label for="filter">Filter by:</label>
                <select name="filter" id="filter">
                    <option value="year" <?php if (isset($_GET["filter"]) && $_GET["filter"] === "year") echo "selected"; ?>>Year</option>
                    <option value="rating" <?php if (isset($_GET["filter"]) && $_GET["filter"] === "rating") echo "selected"; ?>>Rating</option>
                    <option value="votes" <?php if (isset($_GET["filter"]) && $_GET["filter"] === "votes") echo "selected"; ?>>Votes</option>
                </select>

                <input type="hidden" name="order" id="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>">

                <button type="submit" id="toggleOrder">
                    Order: <?php echo isset($_GET['order']) && $_GET['order'] === 'desc' ? 'Descending' : 'Ascending'; ?>
                </button>
            </form> 
        </div>

        <script>
            document.getElementById('toggleOrder').addEventListener('click', function (event) {
                event.preventDefault();
                const orderInput = document.getElementById('order');
                if (orderInput.value === 'asc') {
                    orderInput.value = 'desc';
                } else {
                    orderInput.value = 'asc';
                }
                this.form.submit();
            });

            document.getElementById('filter').addEventListener('change', function () {
                this.form.submit();
            });
        </script>


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