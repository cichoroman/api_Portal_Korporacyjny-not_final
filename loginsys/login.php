<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../loginsys/user.php';

$user = new User;
//echo $object->getAllUsers();

$data = json_decode(file_get_contents("php://input"));
//
//// make sure data is not empty
//
//
if(
   !empty($data->{'mailuid'}) &&
    !empty($data->{'pwd'}) ) {

    if (isset($_POST['login-submit'])) {
        require './config/database.php';


        $mailuid = $_POST['mailuid'];
        $password = $_POST['pwd'];

        if (empty($mailuid) || empty($password)) {
            http_response_code(404);

            // tell the user no products found
            echo json_encode(
                array("message" => "Empty")
            );
            exit();
        } else {
            $uloginResult=$user->getUserByIdOrEmail($mailuid);

           if($uloginResult = false){
               http_response_code(404);

//                 tell the user no products found
             echo json_encode(
                 array("message" => "SqlError")
             );
               exit();
           }
        }
//
  } else {
        if (!$password = ""){
            $row = $uloginResult;
            $pwdCheck = password_verify($password, $row['pwdUsers']);
                    if ($pwdCheck == false) {
                        http_response_code(404);

                        // tell the user no products found
                        echo json_encode(
                            array("message" => "WrongPwd")
                        );
                        exit();
                    } else if ($pwdCheck == true) {
                        //w razie gdyby przez nietypowy blad pwdCheck nie bylo boolenem
                        //i ktoś przypadkiem by sie zalogował
                        session_start();
                        $_SESSION['userId'] = $row['idUsers'];
                        $_SESSION['userUId'] = $row['uidUsers'];

                        http_response_code(200);

                        // show products data in json format
                        echo json_encode(array("message" => "success"));
                        exit();
                    }


                }
        else {
                    http_response_code(404);

                    // tell the user no products found
                    echo json_encode(
                        array("message" => "NoUser")
                    );
                    exit();
                }
            }
        }

