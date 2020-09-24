<?php

class Database {

    // Database parametars
    private $host = 'localhost';
    private $db = 'restapi';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    
    // Private connection object
    private $conn;

    public function connect() {

        $this->conn = null;

        $dsn = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset.";";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        try {            
            $this->conn = new PDO($dsn, $this->user, $this->password, $options);
        } 
        catch (PDOException $e) {
            echo 'Connection Error' . $e->getMessage();
        }

        return $this->conn;

    }
}