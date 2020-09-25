<?php

header("Access-Control-Allow-Origin: *"); 

header("Content-Type: application/json");

require_once "../../config/Database.php";
require_once "../../model/Category.php";

$db = new Database;
$conn = $db->connect();

$cat = new Category($conn);


if(isset($_GET['id'])) {
    $cat->id = $_GET['id'];
} else {
    echo 'Error: No id in get request';
    exit();
} 

$category = $cat->single();

if($category) {
    echo json_encode(['data' => $category]);
} 
else {
    echo json_encode(['message' => "No Category Found"]);
}