<?php
require_once './enums/ProductStatus.php';

use Enums\ProductStatus;

header('Content-Type: application/json');

$products=[
    [
        "id"=>1,
        "name"=>"Product A",
        "price"=>100,
        "status"=>ProductStatus::ACTIVE->value
    ]
    ];


// Endpoint for retrieving products
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/products') {
    echo json_encode($products);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Not Found"]);
}
?>