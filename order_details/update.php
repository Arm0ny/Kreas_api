<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: Application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$database = new Database;
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

$orderDetails = new OrderDetails($db);
$order = new Order($db);


if(!empty($data->order_id) && !empty($data->product_id) && !empty($data->qty)){

    $orderDetails->product_id = $data->product_id;
    $orderDetails->qty = $data->qty;
    $orderDetails->order_id = $data->order_id;
    $order->id = $data->order_id;

    if($orderDetails->update()){
        $order->updateTotalCo2();
        http_response_code(200);
        echo json_encode(array("message" => "OK, Order Details Updated Successfully"));
    }else{
        http_response_code(500);
        echo json_encode(array("message" => "Internal Server Error"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}