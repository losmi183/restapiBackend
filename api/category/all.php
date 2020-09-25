<?php 

header("Access-Control-Allow-Origin: *");

// Vraca kao JSON / Bez ovog zaglavlja php vraca Header Content-Type:text/html;charset=UTF-8 bez obzira sto je json_encode
header("Content-Type: application/json");

require_once "../../config/Database.php";
require_once "../../model/Category.php";

$db = new Database;
$conn = $db->connect();

$cat = new Category($conn);

$result = $cat->all();

/*
* Prvi nacin sa fetchAll, fechuje kao assoc niz i samo se kreira json i posalje
*/
$all_categories = $result->fetchAll(PDO::FETCH_ASSOC);
// var_dump($result);

if($all_categories) {
    echo json_encode(['data' => $all_categories]);
}
else {
    echo json_encode(['message' => 'No category found']);
}

// /*
// * Drugi nacin / Isti kurac
// */

// // kreiramo niz koji ce biti poslat kao json
// $categories_array = [];
// $categories_array['data'] = [];


// while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    
//     $category_data = [];
//     // Podeli niz na posebno promenjive, key postaje ime promenjive
//     extract($row);

//     $category_data['id'] = $id;
//     $category_data['name'] = $name;
//     $category_data['created_at'] = $created_at;

//     array_push($categories_array['data'], $category_data);
// }

// echo json_encode($categories_array);
