<?php
require_once __DIR__ . "/vendor/autoload.php";

if (isset($_POST["vote"])) {
    $vote = $_POST["vote"];
    $id_song = $_POST["id_song"];
    $id_user = $_POST["id_user"];
    $vote = new Vote($id_user, $id_song, $vote);
    $vote->save();
    header("Location: index.php");
}

?>