<?php

class Vote implements ActiveRecord {

    private int $id_vote;
    
    public function __construct(private int $id_user, private int $id_song){
    }

    public function setId_vote(int $id_vote): void {
        $this->id_vote = $id_vote;
    }

    public function getId_vote(): int {
        return $this->id_vote;
    }

    public function setId_user(int $id_user): void {
        $this->id_user = $id_user;
    }

    public function getId_user(): int {
        return $this->id_user;
    }

    public function setId_song(int $id_song): void {
        $this->id_song = $id_song;
    }

    public function getId_song(): int {
        return $this->id_song;
    }

    public function save(): bool {
        $connection = new MySQL();
        
        if (isset($this->id_vote)) {
            $sql = "UPDATE vote SET 
                id_user = '{$this->id_user}', 
                id_song = '{$this->id_song}'
                WHERE id_vote = {$this->id_vote}";
        } else {
            $sql = "SELECT * FROM vote WHERE id_user = '{$this->id_user}' AND id_song = '{$this->id_song}'";
            $result = $connection->query($sql);
            if (count($result) > 0) {
                throw new Exception("User has already voted for this song");
            }
            
            $sql = "INSERT INTO vote (id_user, id_song) 
                VALUES ('{$this->id_user}', '{$this->id_song}')";
        }
        return $connection->execute($sql);
    }

    public function delete(): bool {
        $connection = new MySQL();
        $sql = "DELETE FROM vote WHERE id_vote = {$this->id_vote}";
        return $connection->execute($sql);
    }

    public static function find($id_vote): Vote {
        $connection = new MySQL();
        $sql = "SELECT * FROM vote WHERE id_vote = {$id_vote}";
        $resultado = $connection->query($sql);
        $vote = new Vote($resultado[0]['id_user'], $resultado[0]['id_song']);
        $vote->setId_vote($resultado[0]['id_vote']);
        return $vote;
    }

    public static function findAll(): array {
        $connection = new MySQL();
        $sql = "SELECT * FROM vote";
        $resultados = $connection->query($sql);
        $votes = array();
        foreach ($resultados as $resultado) {
            $vote = new Vote($resultado['id_user'], $resultado['id_song']);
            $vote->setId_vote($resultado['id_vote']);
            $votes[] = $vote;
        }
        return $votes;
    }

    public static function findByUserAndSong(int $id_user, int $id_song): ?Vote {
        $connection = new MySQL();
        $sql = "SELECT * FROM vote WHERE id_user = '{$id_user}' AND id_song = '{$id_song}'";
        $result = $connection->query($sql);
        
        if (count($result) > 0) {
            $vote_data = $result[0];
            $vote = new Vote($vote_data['id_user'], $vote_data['id_song']);
            $vote->setId_vote($vote_data['id_vote']);
            return $vote;
        }
        
        return null;
    }
}

?>
