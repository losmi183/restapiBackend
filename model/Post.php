<?php

class Post {

    // Private db connection
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;
    private $conn;

    // Constructor taking Database object as argument ald call connect method
    // Initialize private $conn variable with PDO object
    public function __construct($db) {        
        $this->conn = $db;
    }

    // Select all Posts method
    public function all()
    {
        $stmt = $this->conn->prepare("SELECT 
                                        c.name AS category_name,
                                        p.id,
                                        p.category_id,
                                        p.title, 
                                        p.body,
                                        p.author,
                                        p.created_at
                                      FROM posts AS p 
                                      INNER JOIN categories AS c 
                                      ON p.category_id = c.id
                                      ORDER BY p.created_at DESC
        ");
                          
        $stmt->execute();
        
        return $stmt;
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // return $result;
    }

    // Select Single Post
    public function single()
    {
        $query = ("SELECT  
                    c.name AS category_name,
                    p.id,
                    p.category_id,
                    p.title, 
                    p.body,
                    p.author,
                    p.created_at   
                  FROM posts AS p 
                  LEFT JOIN categories AS c 
                  ON p.category_id = c.id        
                  WHERE p.id=:id
        ");
        // Prepare Query
        $stmt = $this->conn->prepare($query);
        // Bind Param and execute
        $stmt->execute([':id' => $this->id]);
        // Fetch ROW
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->created_at = $row['created_at'];
    }

    // Create Post
    public function create()
    {
        $query = "INSERT INTO posts(category_id, title, body, author) VALUES (:category_id, :title, :body, :author)";
        $stmt = $this->conn->prepare($query);

        // Clean inputs
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(':category_id', $this->category_id); 
        $stmt->bindParam(':title', $this->title); 
        $stmt->bindParam(':body', $this->body); 
        $stmt->bindParam(':author', $this->author); 
        

        if($stmt->execute()) {
            return true;
        } else {

            // Print error if something goes wrong WE could see in Postman
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    public function update()
    {
        $query = "UPDATE posts
                  SET 
                    category_id=:category_id,
                    title=:title,
                    body=:body,
                    author=:author
                  WHERE id=:id 
        ";
        // Prepare statment
        $stmt = $this->conn->prepare($query);

        // Cleaning inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind Params 
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam('title', $this->title);
        $stmt->bindParam('body', $this->body);
        $stmt->bindParam('author', $this->author);
        // Execute 
        if($stmt->execute()) {
            return true;
        } else {
            printf('Error: %s\n', $stmt->error);
            return false;
        }
    }

    public function delete() {

        $query = "DELETE FROM posts WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s\n", $stmt->error);
        }

    }



}