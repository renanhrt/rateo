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
            $sql = "SELECT * FROM requests WHERE id_user = '{$this->id_user}' AND id_song = '{$this->id_song}'";
            $result = $connection->query($sql);
            if (count($result) > 0) {
                throw new Exception("User has already Requestd for this song");
            }
            
            $sql = "INSERT INTO Request (id_user, id_song) 
                VALUES ('{$this->id_user}', '{$this->id_song}')";
        }
        return $connection->execute($sql);
    }

    public function delete(): bool {
        $connection = new MySQL();
        $sql = "DELETE FROM requests WHERE id_request = {$this->id_request}";
        return $connection->execute($sql);
    }

    public static function find($id_request): Request {
        $connection = new MySQL();
        $sql = "SELECT * FROM requests WHERE id_request = {$id_request}";
        $resultado = $connection->query($sql);
        
        $request = new Request($resultado[0]['id_user'], $resultado[0]['id_song']);
        $request->setid_request($resultado[0]['id_request']);
        return $request;
    }

    public static function findAll(): array {
        $connection = new MySQL();
        $sql = "SELECT * FROM requests";
        $resultados = $connection->query($sql);
        $requests = array();
        
        foreach ($resultados as $resultado) {
            $request = new Request($resultado['id_user'], $resultado['id_song']);
            $request->setid_request($resultado['id_request']);
            $requests[] = $request;
        }
        return $requests;
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
}

?>
