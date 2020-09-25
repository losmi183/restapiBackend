<?php

// HTTP Headers

// Dozvola pristupa svima, bez ogranicenja i tokena
header("Access-Control-Allow-Origin: *"); 

// PHP prihvata samo application/json, takodje treba dodati u postmanu isti header
header("Content-Type: application/json"); 

// Dozvoljava samo DELETE method
header("Access-Control-Allow-Metods: DELETE");
// Headeri koji ce biti dozvoljeni
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Metods, Authorisation, X-Requested-With");

require_once "../../config/Database.php";
require_once "../../model/Category.php";

$db = new Database;
$conn = $db->connect();

$cat = new Category($conn);

$data = json_decode(file_get_contents("php://input"));

$cat->id=$data->id;

if($cat->delete()){
    echo json_encode(['message' => 'Category Deleted']);
} else {
    echo json_encode(['message' => 'Category Not Deleted']);
}