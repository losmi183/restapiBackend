<?php

// HTTP Headers

// Dozvola pristupa svima, bez ogranicenja i tokena
header("Access-Control-Allow-Origin: *"); 

// PHP prihvata samo application/json, takodje treba dodati u postmanu
header("Content-Type: application/json"); 

// Dozvoljava samo DELETE method
header("Access-Control-Allow-Metods: DELETE");
// Headeri koji ce biti dozvoljeni
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Metods, Authorisation, X-Requested-With");

require_once "../../config/Database.php";
require_once "../../model/Post.php";

// Instantiate DB connection
$db = new Database();
$conn = $db->connect();

// Creating post obj
$post = new Post($conn);

$id = $_GET['id'];

$post->id = $id;    

if($post->delete()) {
    echo json_encode(['message' => 'Post Deleted']);
}
else {
    echo json_encode(['message' => 'Not Deleted']);
}


