<?php

require("../vendor/autoload.php");
require("../config/headers.php");
require("../config/database.php");
header('Access-Control-Allow-Methods: POST');

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();

$product = new Product($db);

if(!empty($data->name) && !empty($data->co2_value)){
    $product->name = $data->name;
    $product->co2_value = $data->co2_value;

    if ($product->create()){
        http_response_code(201);
        echo json_encode(
            array("message" => "Product Successfully Created")
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





