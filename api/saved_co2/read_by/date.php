<?php

require("../../vendor/autoload.php");
require("../../config/headers.php");

$database = new Database();
$db = $database->connect();

$savedCo2 = new SavedCo2($db);

if(isset($_GET['from'], $_GET['to'])){
    $res = $savedCo2->readByDate($_GET['from'], $_GET['to']);
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
