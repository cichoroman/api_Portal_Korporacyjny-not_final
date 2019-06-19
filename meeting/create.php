<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
include_once '../objects/meeting.php';
$database = new Database();
$db = $database->getConnection();
$meeting = new meeting($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if( !empty($data->title) &&
    !empty($data->description) &&
    !empty($data->selectedTopic) &&
    !empty($data->date))
    {// set property values
      $meeting->title = $data->title;
      $meeting->description = $data->description;
      $meeting->selectedTopic = $data->selectedTopic;
      $meeting->date = $data->date;
    // create the meeting
      if($meeting->create()){
        // set response code - 201 created
          http_response_code(201);
          echo json_encode(array("message" => "meeting was created."));
        }
    // if unable to create the product, tell the user
      else{

        // set response code - 503 service unavailable
          http_response_code(503);

        // tell the user
          echo json_encode(array("message" => "Unable to create meeting."));
        }
    }

// tell the user data is incomplete
  else{

    // set response code - 400 bad request
      http_response_code(400);

    // tell the user
      echo json_encode(array("message" => "Unable to create meeting. Data is incomplete."));
  }
?>
