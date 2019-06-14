<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/post.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$post = new Post($db);
// query products
$stmt = $post->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
    $posts_arr=array();
    $posts_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item=array(
            "id" => $id,
            "title" => $title,
            "content" => html_entity_decode($content),
            "selectedTopic" => $selectedTopic,
        );
        array_push($posts_arr["records"], $post_item);
    }
    http_response_code(200);
    // show products data in json format
    echo json_encode($posts_arr);
  }
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No posts found.")
    );
}
