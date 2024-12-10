<?php

class User implements ActiveRecord{

    private int $id_user;
    
    public function __construct(private string $username,private string $email, private string $password, private string $role){
    }

    public function setId_user(int $id_user):void{
        $this->id_user = $id_user;
    }

    public function getId_user():int{
        return $this->id_user;
    }

    public function setUsername(string $username):void{
        $this->username = $username;
    }

    public function getUsername():string{
        return $this->username;
    }

    public function setEmail(string $email):void{
        $this->email = $email;
    }

    public function getEmail():string{
        return $this->email;
    }

    public function setPassword(string $password):void{
        $this->password = $password;
    }

    public function getPassword():string{
        return $this->password;
    }

    public function setRole(string $role):void{
        $this->role = $role;
    }

    public function getRole():string{
        return $this->role;
    }

    public function save(): bool {
        $connection = new MySQL();
        $hash_password = password_hash($this->password, PASSWORD_BCRYPT);
        
        #if (!str_ends_with($this->email, 'feliz.ifrs.edu.br')) {
        #    throw new Exception("Invalid email domain. Must be @aluno.feliz.ifrs.edu.br");
        #}

        if (strlen($this->password) < 8) {
            throw new Exception("Password must have at least 8 characters!");
        }

        if (strlen($this->username) < 3 || strlen($this->username) > 20) {
            throw new Exception("Username must have between 3 and 20 characters!");
        }

        if (isset($this->id_user)) {
            $sql = "UPDATE User SET 
                username = '{$this->username}', 
                email = '{$this->email}', 
                password = '{$hash_password}', 
                role = '{$this->role}'
                WHERE id_user = {$this->id_user}";
        } else {
            $sql = "SELECT * FROM user WHERE email = '{$this->email}'";
            $result = $connection->query($sql);
            if (count($result) > 0) {
                throw new Exception("Email already exists!");
            }

            $sql = "INSERT INTO user (username, email, password, role) 
                VALUES ('{$this->username}', '{$this->email}', '{$hash_password}', '{$this->role}')";
        }
        return $connection->execute($sql);
    }

    public function delete():bool{
        $connection = new MySQL();
        $sql = "DELETE FROM user WHERE id_user = {$this->id_user}";
        return $connection->execute($sql);
    }

    public static function find($id_user):User{
        $connection = new MySQL();
        $sql = "SELECT * FROM user WHERE id_user = {$id_user}";
        $resultado = $connection->query($sql);
        $user = new User($resultado[0]['username'],$resultado[0]['email'],$resultado[0]['password'],$resultado[0]['role']);
        $user->setid_user($resultado[0]['id_user']);
        return $user;
    }

    public static function findall():array{
        $connection = new MySQL();
        $sql = "SELECT * FROM user";
        $resultados = $connection->query($sql);
        $users = array();
        foreach($resultados as $resultado){
            $user = new User($resultado['username'],$resultado['email'],$resultado['password'],$resultado['role']);
            $user->setid_user($resultado['id_user']);
            $users[] = $user;
        }
        return $users;
    }

    public static function login(string $email, string $password): ?User {
        $connection = new MySQL();
        $sql = "SELECT * FROM user WHERE email = '{$email}'";
    
        $result = $connection->query($sql);
    
        if (count($result) === 0) {
            throw new InvalidArgumentException("Email does not exist.");
        }
    
        $user_data = $result[0];
    
        if (!password_verify($password, $user_data['password'])) {
            throw new InvalidArgumentException("Invalid password.");
        }
    
        $user = new User(
            $user_data['username'],
            $user_data['email'],
            $user_data['password'],
            $user_data['role']
        );
        $user->setId_user($user_data['id_user']);
    
        return $user;
    }
    
    
}