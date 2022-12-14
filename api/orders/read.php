<?php

require("../vendor/autoload.php");
require("../config/headers.php");

$database = new Database();
$db = $database->connect();

$order = new Order($db);
$orderDetails = new OrderDetails($db);

if (isset($_GET["order_by"])){
    $order->order_by = $_GET["order_by"];
}
if (isset($_GET["order"])){
    $order->order = $_GET["order"];
}

$res = $order->read();
$res_count = $res->rowCount();

if ($res_count > 0){
    $orders_array = array();
    $orders_array['records'] = array();

    while ($orders_row = $res->fetch(PDO::FETCH_ASSOC)){
        extract($orders_row);
        $order_entry = array(
            'order_id' => $id,
            "sell_date" => $sell_date,
            "dest_country" => $dest_country,
            'total_co2' => $total_co2,
            'order_details' => []
        );

        $orderDetails->order_id = $id;
        $details_array = $orderDetails->readByOrderId();
        if($details_array->rowCount() > 0){
            while ($details_row = $details_array->fetch(PDO::FETCH_ASSOC)){
                extract($details_row);
                $details_entry = array(
                    "product_id" => $id,
                    "product_name" => $name,
                    "qty" => $qty,
                );
                $order_entry["order_details"][] = $details_entry;

            }
        }


        $orders_array['records'][] = $order_entry;
    }
    echo json_encode($orders_array);
}
else{
    echo json_encode(
        array("message" => "No item found")
    );
}