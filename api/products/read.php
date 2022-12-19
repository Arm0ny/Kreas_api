<?php

require("../vendor/autoload.php");
require("../config/headers.php");
require('../config/database.php');

$database = new Database();
$db = $database->connect();

$product = new Product($db);
$result = $product->read();
$res_count = $result->rowCount();

if ($res_count > 0){
    $products_array = array();
    $products_array['records'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $product_entry = array(
            'id' => $id,
            'name' => $name,
            'co2_value' => $co2_value
        );
        $products_array['records'][] = $product_entry;
    }
    echo json_encode($products_array);
}
else{
    echo json_encode(
        array("message" => "No item found")
    );
}

