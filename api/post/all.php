<?php

// HTTP Headers

// Dozvola pristupa svima, bez ogranicenja i tokena
header("Access-Control-Allow-Origin: *"); 

// Vraca kao JSON / Bez ovog zaglavlja php vraca Header Content-Type:text/html;charset=UTF-8 bez obzira sto je json_encode
header("Content-Type: application/json"); 

require_once "../../config/Database.php";
require_once "../../model/Post.php";

// Instantiate DB connection
$db = new Database();
$conn = $db->connect();

// Instantiate Blog ObjectI
$post = new Post($conn);

// Blog post query before fetch
$result = $post->all();
// Number of rows
$num = $result->rowCount();

if($num > 0) 
{
    $posts_arr = array();
    $posts_arr['data'] = array();

    // Fetch rows
    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $post_item = [
            'id' => $id,
            'title' => $title,
            'body' => $body,
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
            'created_at' => $created_at,
        ];

        array_push($posts_arr['data'], $post_item);
    }

    // Turn it to JSON & output
    echo json_encode($posts_arr);

}
else
{
    echo json_encode([
        'message' => 'No Posts found'
    ]);
}


// Fetch All result
// $posts = $result->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode($posts);