<?php

require("../../vendor/autoload.php");
require("../../config/headers.php");

$database = new Database();
$db = $database->connect();

$savedCo2 = new SavedCo2($db);

if(isset($_GET["dest_country"])){
    $res = $savedCo2->readByCountry($_GET["dest_country"]);
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
