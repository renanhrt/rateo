<?php

class Vote implements ActiveRecord {

    private int $id_vote;

    public function __construct(private int $id_user, private string $id_song, private int $vote_number) {
    }

    public function setVote_number(int $vote_number): void {
        $this->vote_number = $vote_number;
    }

    public function getVote_number(): int {
        return $this->vote_number;
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

    public function setId_song(string $id_song): void {
        $this->id_song = $id_song;
    }

    public function getId_song(): string {
        return $this->id_song;
    }

    // Update save method to handle vote_number
    public function save(): bool {
        $connection = new MySQL();

        if (isset($this->id_vote)) {
            // Update query now includes vote_number
            $sql = "UPDATE vote SET 
                id_user = '{$this->id_user}', 
                id_song = '{$this->id_song}',
                vote_number = '{$this->vote_number}'
                WHERE id_vote = {$this->id_vote}";
        } else {
            // Check if the user has already voted for this song
            $sql = "SELECT * FROM vote WHERE id_user = '{$this->id_user}' AND id_song = '{$this->id_song}'";
            $result = $connection->query($sql);
            if (count($result) > 0) {
                throw new Exception("User has already voted for this song");
            }
            
            // Insert new vote with vote_number
            $sql = "INSERT INTO vote (id_user, id_song, vote_number) 
                VALUES ('{$this->id_user}', '{$this->id_song}', '{$this->vote_number}')";
        }
        return $connection->execute($sql);
    }

    // Update delete method (no change needed for vote_number)
    public function delete(): bool {
        $connection = new MySQL();
        $sql = "DELETE FROM vote WHERE id_vote = {$this->id_vote}";
        return $connection->execute($sql);
    }

    // Update find method to include vote_number
    public static function find($id_vote): Vote {
        $connection = new MySQL();
        $sql = "SELECT * FROM vote WHERE id_vote = {$id_vote}";
        $resultado = $connection->query($sql);
        
        // Include vote_number when creating the Vote object
        $vote = new Vote($resultado[0]['id_user'], $resultado[0]['id_song'], $resultado[0]['vote_number']);
        $vote->setId_vote($resultado[0]['id_vote']);
        return $vote;
    }

    // Update findAll method to handle vote_number
    public static function findAll(): array {
        $connection = new MySQL();
        $sql = "SELECT * FROM vote";
        $resultados = $connection->query($sql);
        $votes = array();
        
        foreach ($resultados as $resultado) {
            // Include vote_number when creating the Vote object
            $vote = new Vote($resultado['id_user'], $resultado['id_song'], $resultado['vote_number']);
            $vote->setId_vote($resultado['id_vote']);
            $votes[] = $vote;
        }
        return $votes;
    }

    // Update findByUserAndSong method to handle vote_number
    public static function findByUserAndSong(int $id_user, string $id_song): ?Vote {
        $connection = new MySQL();
        $sql = "SELECT * FROM vote WHERE id_user = '{$id_user}' AND id_song = '{$id_song}'";
        $result = $connection->query($sql);
        
        if (count($result) > 0) {
            $vote_data = $result[0];
            // Include vote_number when creating the Vote object
            $vote = new Vote($vote_data['id_user'], $vote_data['id_song'], $vote_data['vote_number']);
            $vote->setId_vote($vote_data['id_vote']);
            return $vote;
        }
        
        return null;
    }
}

?>
