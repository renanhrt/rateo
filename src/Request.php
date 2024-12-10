<?php

class Request implements ActiveRecord {

    private int $id_request;

    public function __construct(private int $id_user, private string $id_song) {
    }

    public function setRequest_number(int $request_number): void {
        $this->Request_number = $request_number;
    }

    public function getRequest_number(): int {
        return $this->Request_number;
    }

    public function setId_request(int $id_request): void {
        $this->id_request = $id_request;
    }

    public function getId_request(): int {
        return $this->id_request;
    }

    public function setId_user(int $id_user): void {
        $this->id_user = $id_user;
    }

    public function getId_user(): int {
        return $this->id_user;
    }

    public function setId_song(string $id_song): void {
        $this->id_song = $id_song;
    }

    public function getId_song(): string {
        return $this->id_song;
    }

    public function save(): bool {
        $connection = new MySQL();

        if (isset($this->id_request)) {
            $sql = "UPDATE requests SET 
                id_user = '{$this->id_user}', 
                id_song = '{$this->id_song}',
                WHERE id_request = {$this->id_request}";
        } else {
            $sql = "SELECT * FROM requests WHERE id_user = {$this->id_user} AND id_song = '{$this->id_song}'";
            $result = $connection->query($sql);
            if (count($result) > 0) {
                throw new Exception("User has already Requestd for this song");
            }
            
            $sql = "INSERT INTO requests (id_user, id_song) 
                VALUES ('{$this->id_user}', '{$this->id_song}')";
        }
        return $connection->execute($sql);
    }

    public function delete(): bool {
        $connection = new MySQL();
        $id_song = $this->id_song;

        $sql = "DELETE FROM requests WHERE id_request = {$this->id_request}";
        $deletion = $connection->execute($sql);

        $sql = "SELECT * FROM requests WHERE id_song = '{$id_song}'";
        $result = $connection->query($sql);
        if (count($result) == 0) {
            $song = Song::find($id_song);
            $song->delete();
        }

        return $deletion;
    }

    public static function find($id_request): Request {
        $connection = new MySQL();
        $sql = "SELECT * FROM requests WHERE id_request = {$id_request}";
        $result = $connection->query($sql);
        
        $request = new Request($result[0]['id_user'], $result[0]['id_song']);
        $request->setid_request($result[0]['id_request']);
        return $request;
    }

    public static function findAll(): array {
        $connection = new MySQL();
        $sql = "SELECT r.id_request, r.id_song, GROUP_CONCAT(r.id_user) AS user_ids FROM requests r GROUP BY r.id_song ORDER BY LENGTH(GROUP_CONCAT(r.id_user)) DESC;";
        $results = $connection->query($sql);
        $requests = array();
        
        $results = $connection->query($sql);
        $songRequests = array();

        foreach ($results as $result) {
            $songRequests[] = [
                'id_request' => $result['id_request'],
                'id_song' => $result['id_song'],
                'user_ids' => explode(',', $result['user_ids']) // Convert the string to an array
            ];
        }
        return $songRequests;
    }

    public static function findByUserAndSong(int $id_user, string $id_song): ?Request {
        $connection = new MySQL();
        $sql = "SELECT * FROM requests WHERE id_user = '{$id_user}' AND id_song = '{$id_song}'";
        $result = $connection->query($sql);
        
        if (count($result) > 0) {
            $request_data = $result[0];
            $request = new Request($request_data['id_user'], $request_data['id_song']);
            $request->setid_request($request_data['id_request']);
            return $request;
        }
        
        return null;
    }

    public static function deleteBySong(string $id_song): bool {
        $connection = new MySQL();
        $sql = "DELETE FROM requests WHERE id_song = '{$id_song}'";
        return $connection->execute($sql);
    }
}

?>
