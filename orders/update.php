<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: Application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$database = new Database;
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"), true);

$order = new Order($db);
$orderDetails = new OrderDetails($db);

if(!empty($data["id"]) && !empty($data["params"])) {
    $order->id = $data["id"];
    if ($order->update($data["params"])) {
        http_response_code(200);
        echo json_encode(array("message" => "OK, order Updated Successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Internal Server Error"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}



