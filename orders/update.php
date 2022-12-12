<?php

require("../vendor/autoload.php");
require("../config/headers.php");
header('Access-Control-Allow-Methods: POST');

$data = json_decode(file_get_contents("php://input"), true);

$database = new Database();
$db = $database->connect();

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



