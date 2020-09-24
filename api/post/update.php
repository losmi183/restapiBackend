<?php

// HTTP Headers

// Dozvola pristupa svima, bez ogranicenja i tokena
header("Access-Control-Allow-Origin: *"); 

// PHP prihvata samo application/json, takodje treba dodati u postmanu
header("Content-Type: application/json"); 

// Dozvoljava samo PUT oor PATCH method
header("Access-Control-Allow-Metods: PATCH");
// Headeri koji ce biti dozvoljeni
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Metods, Authorisation, X-Requested-With");

require_once "../../config/Database.php";
require_once "../../model/Post.php";

// Instantiate DB connection
$db = new Database();
$conn = $db->connect();

// Creating post obj
$post = new Post($conn);

// // Getting data 
$data = json_decode(file_get_contents("php://input"));

// // init Post object
$post->id = $data->id;
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;



if($post->update()) {
    echo json_encode(['message' => 'Update Success']);
} else {
    echo json_encode(['message' => 'Update Failed']);
}
