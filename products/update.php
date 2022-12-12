<?php

require("../vendor/autoload.php");
require("../config/headers.php");
require("../config/database.php");
header('Access-Control-Allow-Methods: POST');

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$product->id = $data->id;
$product->name = $data->name;
$product->co2_value = $data->co2_value;

if(!empty($data->id) && !empty($data->name) && !empty($data->co2_value)){
    if($product->update()){
        http_response_code(200);
        echo json_encode(array("message" => "OK, Product Updated"));
    }else{
        http_response_code(500);
        echo json_encode(array("message" => "Internal Server Error"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}