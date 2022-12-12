<?php
require("../vendor/autoload.php");
require("../config/headers.php");
header('Access-Control-Allow-Methods: POST');

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();

$orderDetails = new OrderDetails($db);
$order = new Order($db);

if (!empty($data->order_id) && !empty($data->product_id) && !empty($data->qty)){
    $orderDetails->order_id = $data->order_id;
    $orderDetails->product_id = $data->product_id;
    $orderDetails->qty = $data->qty;

    $order->id = $data->order_id;

    if ($orderDetails->create()){
        $order->updateTotalCo2();
        http_response_code(200);
        echo json_encode(array("message" => "Product Successfully Added to order"));
    }else{
        http_response_code(500);
        echo json_encode(array("message" => "Internal Server  Error"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}

