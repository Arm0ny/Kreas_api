<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: Application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, 
        Authorization, X-Requested-With');

$database = new Database;
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

$product = new Product($db);

if($data->id){
    $product->id = $data->id;

    if ($product->delete()){
        http_response_code(201);
        echo json_encode(
            array("message" => "Product Successfully Deleted")
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