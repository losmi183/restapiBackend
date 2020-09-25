<?php

class Category {

    public $id;
    public $name;
    public $created_at;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function all() 
    {
        $query = "SELECT * FROM categories ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function single() 
    {
        $query = "SELECT * FROM categories WHERE id=:id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

        // Prepare Query
        $stmt = $this->conn->prepare($query);
        // Bind Param and execute
        $stmt->execute([':id' => $this->id]);
        // Fetch ROW
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $query = "INSERT INTO categories(name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        // Clean inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(':name', $this->name);
        
        if($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s\n", $stmt->error);
        }
    }
    
    public function update()
    {
        $query = "UPDATE categories SET name=:name WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        // Clean inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        // Bind Params
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        
        if($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s\n", $stmt->error);
        }
    }

    public function delete()
    {
        $query = "DELETE FROM categories WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        // Bind Params
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s\n", $stmt->error);
        }
    }

}