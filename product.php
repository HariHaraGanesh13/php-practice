<?php
header("Content-Type: application/json");
require "config.php";
global $pdo;

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid ID"]);
    exit;
}

$stmt = $pdo->prepare(
    "SELECT id, name, category, price, description,image_url
            FROM products 
            WHERE id = ?"
);
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    http_response_code(404);
    echo json_encode(["error" => "Product not found"]);
    exit;
}

echo json_encode(["product" => $product]);// wrapping the product inside a named container "product" ea