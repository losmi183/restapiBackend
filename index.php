<?php

require_once "config/Database.php";
require_once "model/Post.php";

$db = new Database();

$conn = $db->connect();

$post = new Post($conn);

$result = $post->single(1);

$post = $result->fetch(PDO::FETCH_ASSOC);

var_dump($post);

