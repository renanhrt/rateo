<?php

class Song implements ActiveRecord {

    private String $id_song;

    public function __construct(private string $title, private int $year, private string $artist, private string $cover, private string $preview_url) {
    }

    public function setId_song(String $id_song): void {
        $this->id_song = $id_song;
    }

    public function getId_song(): String {
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
        $sql = "INSERT INTO song (id_song, title, year, artist, cover, preview_url) VALUES ('{$this->id_song}', '{$this->title}', {$this->year}, '{$this->artist}', '{$this->cover}', '{$this->preview_url}')";
        return $connection->execute($sql);
    }

    public function delete(): bool {
        $connection = new MySQL();
        $sql = "DELETE FROM song WHERE id_song = '{$this->id_song}'";
        return $connection->execute($sql);
    }

    public static function find($id_song) {
        $connection = new MySQL();
        $sql = "SELECT * FROM song WHERE id_song = '{$id_song}'";
        $result = $connection->query($sql);
        if (count($result) === 0) {
            return NULL;
        }
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
        $sql = "SELECT * FROM song";
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

    public static function random_song($id_user){
        $connection = new MySQL();
        $sql = "SELECT * FROM song WHERE id_song NOT IN (SELECT id_song FROM vote WHERE id_user = {$id_user})";
        $result = $connection->query($sql);
        if(count($result) > 0){
            $totalcount = count($result);
            $song_data = $result[rand(0,$totalcount - 1)];
            $song = new Song(
                $song_data['title'],
                $song_data['year'],
                $song_data['artist'],
                $song_data['cover'],
                $song_data['preview_url']
            );
            $song->setId_song($song_data['id_song']);
            return $song;   
        }        
        return NULL;
    }

    public static function searchSongSpotify($search_string): array {
        // GET ACCESS TOKEN
        $params = [
            'grant_type' => 'client_credentials',
            'client_id' => '2667aa6e88a249108b9a6228d266c4d3',
            'client_secret' => '1141d42afb8c4dde8f37ad6b7527157e',
        ];
        
        $authUrl = 'https://accounts.spotify.com/api/token';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $authUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $responseData = json_decode($response, true);
        if (!isset($responseData['access_token'])) {
            die("Error retrieving access token: " . $response);
        }
        $token = $responseData['access_token'];
        


        // SEARCH FOR SONGS OR ARTISTS
        $searchUrl = 'https://api.spotify.com/v1/search?q='. str_replace(' ', '+', $search_string) .'&type=track,artist&limit=10&include_external=audio';
        
        $headers = [
            "Authorization: Bearer $token",
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $searchUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $searchResponse = curl_exec($ch);
        curl_close($ch);
        
        $searchData = json_decode($searchResponse, true);

        $file = 'response.json';
        if (!file_put_contents($file, json_encode($searchData, JSON_PRETTY_PRINT))) {
            echo "Failed to save the response to $file\n";
        }

        if (isset($searchData['tracks']['items'])) {
            $songs = array();
            foreach ($searchData['tracks']['items'] as $track) {
                if (!isset($track['preview_url'])) {
                    $track['preview_url'] = '';
                }
                $song = new Song(
                    $track['name'],
                    (int)substr($track['album']['release_date'], 0, 4),
                    $track['artists'][0]['name'],
                    $track['album']['images'][0]['url'],
                    $track['preview_url']
                );
                $song->setId_song($track['id']);
                $songs[] = $song;
            }
            if (count($songs) > 0) {
                return $songs;
            } else {
                return [];
            }
        }
     
        return [];
    }

    public static function ranking($filter, $order): array {
        $connection = new MySQL();
        if ($filter == 'votes') {
            $sql = "SELECT song.*, AVG(vote_number) AS average, COUNT(vote_number) AS total_votes FROM song LEFT JOIN vote ON song.id_song = vote.id_song GROUP BY song.id_song HAVING total_votes > 0 ORDER BY total_votes " . strtoupper($order);
        } else if ($filter == 'rating') {
            $sql = "SELECT song.*, AVG(vote_number) AS average, COUNT(vote_number) AS total_votes FROM song LEFT JOIN vote ON song.id_song = vote.id_song GROUP BY song.id_song HAVING total_votes > 0 ORDER BY average " . strtoupper($order);
        } else {
            $sql = "SELECT song.*, AVG(vote_number) AS average, COUNT(vote_number) AS total_votes FROM song LEFT JOIN vote ON song.id_song = vote.id_song GROUP BY song.id_song HAVING total_votes > 0 ORDER BY year " . strtoupper($order);
        }        
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

    public function getScore(): array {
        $connection = new MySQL();
        $sql = "SELECT AVG(vote_number) as average, COUNT(vote_number) as total_votes FROM vote WHERE id_song = '{$this->id_song}'";
        $result = $connection->query($sql);
        return [
            'average' => round((float)$result[0]['average'], 1),
            'total_votes' => (int)$result[0]['total_votes']
        ];
    }

}
?>
