<?php

require("../vendor/autoload.php");
require("../config/headers.php");
require("../config/database.php");
header('Access-Control-Allow-Methods: POST');

$data = json_decode(file_get_contents("php://input"), true);

$database = new Database();
$db = $database->connect();

$product = new Product($db);

if(!empty($data["id"]) && !empty($data["params"])) {
    $product->id = $data["id"];
    if ($product->update($data["params"])) {
        http_response_code(200);
        echo json_encode(array("message" => "OK, product Updated Successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Internal Server Error"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}