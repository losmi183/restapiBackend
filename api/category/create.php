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
require_once "../../model/Category.php";

$db = new Database;
$conn = $db->connect();

$cat = new Category($conn);


// Kada se koristi "Content-Type: application/json" onda ne moze $_POST superglobal da se koristi
// Otvaramo glavni input stream, i iz njega izvlacimo poslate podatke kao json
$data = json_decode(file_get_contents("php://input"));

// Inicijalizujemo polje name u Category objektu
$cat->name = $data->name;

if($cat->create()) {
    echo json_encode(['message' => 'Category Added']);
} else {
    echo json_encode(['message' => 'Category Not Added']);
}