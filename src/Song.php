<?php

class Song implements ActiveRecord {

    private int $id_song;

    public function __construct(private string $title, private int $year, private string $artist, private string $cover, private string $preview_url) {
    }

    public function setId_song(int $id_song): void {
        $this->id_song = $id_song;
    }

    public function getId_song(): int {
        return $this->id_song;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setYear(int $year): void {
        $this->year = $year;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function setArtist(string $artist): void {
        $this->artist = $artist;
    }

    public function getArtist(): string {
        return $this->artist;
    }

    public function setCover(string $cover): void {
        $this->cover = $cover;
    }

    public function getCover(): string {
        return $this->cover;
    }

    public function setPreview_url(string $preview_url): void {
        $this->preview_url = $preview_url;
    }

    public function getPreview_url(): string {
        return $this->preview_url;
    }

    public function save(): bool {
        $connection = new MySQL();
        if (isset($this->id_song)) {
            $sql = "UPDATE Song SET title = '{$this->title}', year = {$this->year}, artist = '{$this->artist}', cover = '{$this->cover}', preview_url = '{$this->preview_url}' WHERE id_song = {$this->id_song}";
        } else {
            $sql = "INSERT INTO Song (title, year, artist, cover, preview_url) 
                VALUES ('{$this->title}', {$this->year}, '{$this->artist}', '{$this->cover}', '{$this->preview_url}')";
        }
        return $connection->execute($sql);
    }

    public function delete(): bool {
        $connection = new MySQL();
        $sql = "DELETE FROM Song WHERE id_song = {$this->id_song}";
        return $connection->execute($sql);
    }

    public static function find($id_song): Song {
        $connection = new MySQL();
        $sql = "SELECT * FROM Song WHERE id_song = {$id_song}";
        $result = $connection->query($sql);
        $s = new Song(
            $result[0]['title'],
            $result[0]['year'],
            $result[0]['artist'],
            $result[0]['cover'],
            $result[0]['preview_url']
        );
        $s->setId_song($result[0]['id_song']);
        return $s;
    }

    public static function findAll(): array {
        $connection = new MySQL();
        $sql = "SELECT * FROM Song";
        $results = $connection->query($sql);
        $songs = array();
        foreach ($results as $result) {
            $s = new Song(
                $result['title'],
                $result['year'],
                $result['artist'],
                $result['cover'],
                $result['preview_url']
            );
            $s->setId_song($result['id_song']);
            $songs[] = $s;
        }
        return $songs;
    }
}
?>
