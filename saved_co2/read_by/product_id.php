<?php
require("../../vendor/autoload.php");
require("../../config/headers.php");

$database = new Database();
$db = $database->connect();

$savedCo2 = new SavedCo2($db);

if(isset($_GET["product_id"])){
    $res = $savedCo2->readByProduct($_GET["product_id"]);
    if($res){
        $row = $res->fetchAll(PDO::FETCH_ASSOC);
        http_response_code(200);
        echo json_encode($row);
    }else{
        http_response_code(500);
        json_encode(array("message" => "Internal Server Error"));
    }
}
http_response_code(400);
json_encode(array("message" => "Bad Request"));