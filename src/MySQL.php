<?php

require_once __DIR__ . "\Config.php";

class MySQL {
    
    private $connection;
    
    public function __construct() {
        $this->connection = new \mysqli(HOST, USER, PASSWORD, DATABASE);
        $this->connection->set_charset("utf8");
    }

    public function execute($sql) {
        $result = $this->connection->query($sql);
        return $result;
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        $item = array();
        $data = array();
        while ($item = mysqli_fetch_array($result)) {
            $data[] = $item;
        }
        return $data;
    }
}
?>
