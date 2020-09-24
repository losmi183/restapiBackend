<?php

// HTTP Headers

// Dozvola pristupa svima, bez ogranicenja i tokena
header("Access-Control-Allow-Origin: *"); 

// PHP prihvata samo application/json, takodje treba dodati u postmanu isti header
header("Content-Type: application/json"); 

// Dozvoljava samo POST method
header("Access-Control-Allow-Metods: POST");
// Headeri koji ce biti dozvoljeni
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Metods, Authorisation, X-Requested-With");

require_once "../../config/Database.php";
require_once "../../model/Post.php";

// Instantiate DB connection
$db = new Database();
$conn = $db->connect();

// Creating post obj
$post = new Post($conn);

// Getting Raw posted data
// php://input is a read-only stream that allows you to read raw data from the request body / file_get_contents - open file as string
$data = json_decode(file_get_contents("php://input"));

// Init created post object
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

// Post::create method create row in database
if($post->create())
{
    echo json_encode(['message' => 'Post Created']);
}
else 
{
    echo json_encode(['message' => 'Post Not Created']);
}

