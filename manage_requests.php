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

    if (isset($_POST["accept"])) {
        $request = Request::find($_POST["accept"]);
        if ($request) {
            $song = Song::find($request->getId_song());
            if ($song) {
                $song->setIs_request(0);
                $song->save();
                Request::deleteBySong($song->getId_song());
            }
        }
    }

    if (isset($_POST["reject"])) {
        $request = Request::find($_POST["reject"]);
        if ($request) {
            $song = Song::find($request->getId_song());
            if ($song) {
                Request::deleteBySong($song->getId_song());
                $song->delete();
            }
        }
    }

    $requests = Request::findAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="logo.webp" type="image/x-icon">
    <title>Manage Requests</title>
</head>
<body>
    <header class="header">
        <div class="logo">Rateo</div>
        <nav>
        <a href="index.php">Home</a>
        <a href="ranking.php">Ranking</a>
        <?php if ($user->getRole() === 'admin'): ?>
            <a href="add_songs.php">Add songs</a>
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
            <?php
                if (isset($requests)) {
                    foreach ($requests as $request) {
                        $song = Song::find($request['id_song']);
                        if ($song) { ?>
                            <div class='song'>
                                <iframe  style="border-radius:12px" src="https://open.spotify.com/embed/track/<?= htmlspecialchars($song->getId_song(), ENT_QUOTES, 'UTF-8'); ?>?utm_source=generator" width="100%"  height="256"  frameborder="0"  allowfullscreen  allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"  loading="lazy"></iframe>
                                <p><?= htmlspecialchars($song->getTitle(), ENT_QUOTES, 'UTF-8'); ?> - <?= htmlspecialchars($song->getArtist(), ENT_QUOTES, 'UTF-8'); ?> (<?= htmlspecialchars($song->getYear(), ENT_QUOTES, 'UTF-8'); ?>)</p>
                                <p>Requested by: 
                                    <?php 
                                    $user_ids = $request['user_ids'];
                                    $count = 0;
                                    foreach ($user_ids as $id) {
                                        if ($count >= 3) {
                                            echo 'and others...';
                                            break;
                                        }
                                        $user = User::find($id);
                                        if ($user) {
                                            if ($count > 0) {
                                                echo ', ';
                                            }
                                            echo htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8');
                                            $count++;
                                        }
                                    }
                                    ?>
                                </p>
                                <div class="buttons-request">
                                    <form action="manage_requests.php" method="post">
                                        <input type="hidden" name="accept" value="<?= htmlspecialchars($request['id_request'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="submit" value="Accept" class="submit-input accept">
                                    </form>
                                    <form action="manage_requests.php" method="post">
                                        <input type="hidden" name="reject" value="<?= htmlspecialchars($request['id_request'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="submit" value="Reject" class="submit-input remove">
                                    </form>
                                </div>
                                
                            </div>
                        <?php }
                    }
                }
            ?>
            <?php if (count($requests) == 0): ?>
                <p>No more requests...</p>
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