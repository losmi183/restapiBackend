<?php

// HTTP Headers

// Dozvola pristupa svima, bez ogranicenja i tokena
header("Access-Control-Allow-Origin: *"); 
// Vraca kao JSON
header("Content-Type: application/json"); 

require_once "../../config/Database.php";
require_once "../../model/Post.php";

// Instantiate DB connection
$db = new Database();
$conn = $db->connect();

// Creating post obj
$post = new Post($conn);

// Geting post id from GET request
$post->id = isset($_GET['id']) ? $_GET['id'] : die();
// Calling single method init post properties
$post->single();

// Kreate post Array
$post_array = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name,
    'created_at' => $post->created_at,
);

echo json_encode($post_array);







