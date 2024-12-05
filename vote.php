<?php
require_once __DIR__ . "/vendor/autoload.php";

if (isset($_POST["vote_number"])) {
    $id_song = $_POST["id_song"];
    $id_user = $_POST["id_user"];
    $vote_number = (int)$_POST["vote_number"];
    $vote = new Vote($id_user, $id_song, $vote_number);
    $vote->save();
    header("Location: index.php");
}

?>