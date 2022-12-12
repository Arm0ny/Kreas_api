<?php

require("../vendor/autoload.php");
require("../config/headers.php");
require("../config/database.php");
header('Access-Control-Allow-Methods: POST');

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();

$order = new Order($db);

if(!empty($data->id)){
    $order->id = $data->id;

    if ($order->delete()){
        http_response_code(201);
        echo json_encode(
            array("message" => "Order Successfully Deleted")
        );
    }else{
        http_response_code(500);
        echo json_encode(
            array("message" => "Internal Server Error")
        );
    }
}else{
    http_response_code(400);
    echo json_encode(
        array("message" => "Bad Request")
    );
}